import { Component, OnInit } from '@angular/core';
import { ArticleModel } from 'src/app/shared/models/article.model';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ActivatedRoute } from '@angular/router';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-edit-article',
  templateUrl: './edit-article.component.html',
  styleUrls: ['./edit-article.component.scss']
})
export class EditArticleComponent implements OnInit {
  
  private articleID;
  private article: ArticleModel;
  private lang;

  private loading;

  constructor(
    private articlesApi: ArticlesApiService,
    private route: ActivatedRoute,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.articleID = this.route.snapshot.paramMap.get('id');
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;

      this.loading = false;
    });
    // TODO: pobranie artykulu po id z route'a
    // this.articlesApi.getArticle
  }

}
