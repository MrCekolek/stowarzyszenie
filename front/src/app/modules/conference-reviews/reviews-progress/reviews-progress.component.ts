import { Component, OnInit } from '@angular/core';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { LanguageService } from "../../../shared/services/user/language.service";
import { MatDialog, MatDialogConfig } from "@angular/material";
import { PreviewReviewerComponent } from "../preview-reviewer/preview-reviewer.component";
import {ReviewModalComponent} from "../review-modal/review-modal.component";

@Component({
    selector: 'app-reviews-progress',
    templateUrl: './reviews-progress.component.html',
    styleUrls: ['./reviews-progress.component.scss']
})
export class ReviewsProgressComponent implements OnInit {

    private allArticles = [];
    private loading;
    private lang;

    constructor(
        private articlesApi: ArticlesApiService,
        private languageService: LanguageService,
        private dialog: MatDialog
    ) {
    }

    ngOnInit() {
        this.loading = true;

        this.languageService.currentLang.subscribe(res => {
            this.lang = res;
        });

        this.articlesApi.getAllConferenceArticles().subscribe(
            (res) => {
                this.allArticles = res.conferenceArticles.filter(x => x.status !== 'waiting' && x.status !== 'in pc' && x.status !== 'rejected');
            },
            () => {
            },
            () => {
                this.loading = false;
            }
        );
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

    seeReview(review) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            review: review,
            lang: this.lang
        };

        const dialogRef = this.dialog.open(ReviewModalComponent, dialogConfig);
    }

}
