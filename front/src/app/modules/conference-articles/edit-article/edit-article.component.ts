import { Component, OnInit } from '@angular/core';
import { ArticleModel } from 'src/app/shared/models/article.model';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ActivatedRoute, Router } from '@angular/router';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';

@Component({
  selector: 'app-edit-article',
  templateUrl: './edit-article.component.html',
  styleUrls: ['./edit-article.component.scss']
})
export class EditArticleComponent implements OnInit {
  
  private articleID;
  private article: ArticleModel = {
    title_pl: '',
    title_en: '',
    title_ru: '',
    abstract_pl: '',
    abstract_en: '',
    abstract_ru: '',
    file_name: '',
    file: '',
    user_id: '',
    track_id: '',
    keywords_pl: '',
    keywords_en: '',
    keywords_ru: ''
  };
  private lang;

  private loading;
  private translateNameLoading;
  private translateAbstractLoading;
  private translateKeywordsLoading;

  private nameTranslations = [];
  private abstractTranslations = [];
  private keywordsTranslations = [];

  private submitLoading;

  private tracks = [];

  private selectedTrack;

  constructor(
    private articlesApi: ArticlesApiService,
    private route: ActivatedRoute,
    private languageService: LanguageService,
    private apiService: ApiService,
    private userProvider: UserProviderService,
    private conferenceApi: ManageConferenceApiService,
    private router: Router
  ) { }

  ngOnInit() {
    this.loading = true;
    this.articleID = this.route.snapshot.paramMap.get('id');
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
    });
    // TODO: pobranie artykulu po id z route'a
    const articleObj = {
      id: this.articleID
    };
    this.articlesApi.getArticle(articleObj).subscribe(res => {
      console.log(res);
      this.article = res.trackArticle;
    });

    this.conferenceApi.getConference().subscribe(res => {
      const obj = {
        conference_id: res.conference.id
      };

      this.conferenceApi.getTracks(obj).subscribe(response => {
        this.tracks = response.tracks;
        this.loading = false;
      });
    });
  }

  getNameTranslations() {
    const obj: any = {
      name: this.article['title_' + this.lang]
    };

    this.translateNameLoading = true;
    this.apiService.post('translation/get', obj).subscribe(res => {
      this.nameTranslations[0] = res.translation.name_pl;
      this.nameTranslations[1] = res.translation.name_en;
      this.nameTranslations[2] = res.translation.name_ru;
      
      this.translateNameLoading = false;
    });
  }

  getAbstractTranslations() {
    const obj: any = {
      name: this.article['abstract_' + this.lang]
    };

    this.translateAbstractLoading = true;
    this.apiService.post('translation/get', obj).subscribe(res => {
      this.abstractTranslations[0] = res.translation.name_pl;
      this.abstractTranslations[1] = res.translation.name_en;
      this.abstractTranslations[2] = res.translation.name_ru;

      this.translateAbstractLoading = false;
    });
  }

  getKeywordsTranslations() {
    const obj: any = {
      name: this.article['keywords_' + this.lang]
    };

    this.translateKeywordsLoading = true;
    this.apiService.post('translation/get', obj).subscribe(res => {
      this.keywordsTranslations[0] = res.translation.name_pl;
      this.keywordsTranslations[1] = res.translation.name_en;
      this.keywordsTranslations[2] = res.translation.name_ru;

      this.translateKeywordsLoading = false;
    });
  }

  updateArticle() {
    this.articlesApi.updateArticle(this.article).subscribe(res => {
      if (res.success) {
        this.router.navigateByUrl('conference-articles/my');
      }
    });
  }
}
