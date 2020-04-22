import { Component, OnInit } from '@angular/core';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ArticlePreviewComponent } from '../../conference-articles/article-preview/article-preview.component';
import { PreviewReviewerComponent } from '../preview-reviewer/preview-reviewer.component';
import { Router } from '@angular/router';
import { AddCommentReviewerComponent } from '../add-comment-reviewer/add-comment-reviewer.component';

@Component({
  selector: 'app-my-reviews',
  templateUrl: './my-reviews.component.html',
  styleUrls: ['./my-reviews.component.scss']
})
export class MyReviewsComponent implements OnInit {

  private loading;
  private lang;
  private assignedArticles = [];

  constructor(
    private languageService: LanguageService,
    private dialog: MatDialog,
    private router: Router
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
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

  goToReview(article?) {
    this.router.navigateByUrl('conference-reviews/review', article.id);
  }

  addComment(article) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        article: article
    };

    const dialogRef = this.dialog.open(AddCommentReviewerComponent, dialogConfig);
}
}
