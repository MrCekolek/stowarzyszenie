import { Component, OnInit } from '@angular/core';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { ArticlePreviewComponent } from '../article-preview/article-preview.component';
import { AddCommentComponent } from '../add-comment/add-comment.component';

@Component({
  selector: 'app-all-articles',
  templateUrl: './all-articles.component.html',
  styleUrls: ['./all-articles.component.scss']
})
export class AllArticlesComponent implements OnInit {

  private allArticles = [];
  private acceptedArticles = [];
  private rejectedArticles = [];
  private toManageArticles = [];
  private loading;
  private conference;

  private lang;

  constructor(
    private articlesApi: ArticlesApiService,
    private conferenceApi: ManageConferenceApiService,
    private languageService: LanguageService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
    });
    this.conferenceApi.getConference().subscribe(res => {
      this.conference = res.conference;
    });
    this.articlesApi.getAllConferenceArticles().subscribe(res => {
      this.allArticles = res.conferenceArticles;
      console.log(this.allArticles);
      this.acceptedArticles = this.allArticles.filter(t => t.status === 'accepted' || (t.status !== 'rejected' && t.status !== 'waiting'));
      this.rejectedArticles = this.allArticles.filter(t => t.status === 'rejected');
      this.toManageArticles = this.allArticles.filter(t => t.status === 'waiting');
      this.loading = false;
    });
  }

  openPreviewModal(article) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      article: article,
      lang: this.lang
    };

    const dialogRef = this.dialog.open(ArticlePreviewComponent, dialogConfig);
  }

  // TODO: o tutaj o nie dziala update i tam nizej tez ;c
  acceptArticle(article) {
    article.status = 'accepted';
    this.articlesApi.updateArticle(article).subscribe(res => {
      if (res.success) {
        this.acceptedArticles.push(article);
        const ind = this.toManageArticles.indexOf(article);
        this.toManageArticles.splice(ind, 1);
      }
    });
  }

  rejectArticle(article) {
    article.status = 'rejected';
    this.articlesApi.updateArticle(article).subscribe(res => {
      if (res.success) {
        this.rejectedArticles.push(article);
        const ind = this.toManageArticles.indexOf(article);
        this.toManageArticles.splice(ind, 1);
      }
    });
  }

  restoreArticle(article) {
    article.status = 'waiting';
    this.articlesApi.updateArticle(article).subscribe(res => {
      if (res.success) {
        this.allArticles.push(article);
        this.toManageArticles.push(article);
        const ind = this.toManageArticles.indexOf(article);
        this.rejectedArticles.splice(ind, 1);
      }
    });
  }

  addComment(article) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      article: article
    };

    const dialogRef = this.dialog.open(AddCommentComponent, dialogConfig);
  }

  assignReviewer(article) {

  }

}
