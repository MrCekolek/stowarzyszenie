import { Component, OnInit } from '@angular/core';
import { MatDialogRef, MatDialogConfig, MatDialog } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { AssignReviewerModalComponent } from '../assign-reviewer-modal/assign-reviewer-modal.component';
import { AddCommentComponent } from 'src/app/shared/components/add-comment/add-comment.component';
import { ArticlePreviewComponent } from 'src/app/shared/components/article-preview/article-preview.component';
import { AddCommentReviewerComponent } from '../add-comment-reviewer/add-comment-reviewer.component';
import { PreviewReviewerComponent } from '../preview-reviewer/preview-reviewer.component';

@Component({
  selector: 'app-articles-to-assign',
  templateUrl: './articles-to-assign.component.html',
  styleUrls: ['./articles-to-assign.component.scss']
})
export class ArticlesToAssignComponent implements OnInit {

  private articles = [];
  private lang;
  private loading;
  private isConferenceCreated;

  constructor(
    private languageService: LanguageService,
    private dialog: MatDialog,
    private articlesApi: ArticlesApiService,
    private conferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
    });

    this.conferenceApi.getConference().subscribe(res => {
    if (res.conference.id) {
      this.isConferenceCreated = true;
    }
    });

    this.articlesApi.getAllConferenceArticles().subscribe(res => {
      this.articles = res.conferenceArticles.filter(x => x.status === 'accepted' && x.status !== 'reviewed' && x.status !== 'review' && x.status !== 'in pc');
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

    const dialogRef = this.dialog.open(PreviewReviewerComponent, dialogConfig);
  }

  addComment(article) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        article: article
    };

    const dialogRef = this.dialog.open(AddCommentReviewerComponent, dialogConfig);
}

  openAssignModal(article) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      article: article,
      lang: this.lang
    };

    const dialogRef = this.dialog.open(AssignReviewerModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(data => {
      if (data) {
        if (data.success) {
          //TODO: usuniecie artykulu z tablicy this.articles
        } else {
          //TODO:  nie wiem jakis error
        }
      }
    });
  }
}
