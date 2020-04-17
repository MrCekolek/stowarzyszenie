import { Component, OnInit } from '@angular/core';
import { ArticleModel } from 'src/app/shared/models/article.model';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ApiService } from 'src/app/core/http/api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-submit-article',
  templateUrl: './submit-article.component.html',
  styleUrls: ['./submit-article.component.scss']
})
export class SubmitArticleComponent implements OnInit {
  
  private loading;

  private article: ArticleModel = {
    title_pl: '',
    title_en: '',
    title_ru: '',
    abstract_pl: '',
    abstract_en: '',
    abstract_ru: '',
    file: '',
    user_id: '',
    track_id: '',
    keywords_pl: '',
    keywords_en: '',
    keywords_ru: ''
  };

  private lang;

  private nameTranslations = [];
  private abstractTranslations = [];
  private keywordsTranslations = [];

  private translateNameLoading;
  private translateAbstractLoading;
  private translateKeywordsLoading;
  private submitLoading;

  private tracks = [];

  private selectedTrack;

  constructor(
    private articlesApi: ArticlesApiService,
    private apiService: ApiService,
    private languageService: LanguageService,
    private conferenceApi: ManageConferenceApiService,
    private userProvider: UserProviderService,
    private router: Router
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.article.user_id = this.userProvider.getUser().id.toString();

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
      console.log(res);
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
    console.log(obj);

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

  submitArticle() {
    this.submitLoading = true;
    this.article.title_pl = this.nameTranslations[0];
    this.article.title_en = this.nameTranslations[1];
    this.article.title_ru = this.nameTranslations[2];
    this.article.abstract_pl = this.abstractTranslations[0];
    this.article.abstract_en = this.abstractTranslations[1];
    this.article.abstract_ru = this.abstractTranslations[2];
    this.article.keywords_pl = this.keywordsTranslations[0];
    this.article.keywords_en = this.keywordsTranslations[1];
    this.article.keywords_ru = this.keywordsTranslations[2];
    this.article.track_id = this.selectedTrack;

    this.articlesApi.createArticle(this.article).subscribe(res => {
      console.log(res);
      if (res.success) {
        this.router.navigateByUrl('conference-articles/my');
      }
      this.submitLoading = false;
    });
  }
}
