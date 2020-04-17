import { Component, OnInit } from '@angular/core';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { Router } from '@angular/router';
import { ArticleModel } from 'src/app/shared/models/article.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-my-articles',
  templateUrl: './my-articles.component.html',
  styleUrls: ['./my-articles.component.scss']
})
export class MyArticlesComponent implements OnInit {

  private articles = [];
  private loading;
  private lang;

  constructor(
    private userProvider: UserProviderService,
    private router: Router,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.articles = this.userProvider.getUser().track_articles;
    console.log(this.userProvider.getUser().track_articles);
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
      this.loading = false;
    });
  }

  goToArticleAdd() {
    this.router.navigateByUrl('conference-articles/add');
  }
}
