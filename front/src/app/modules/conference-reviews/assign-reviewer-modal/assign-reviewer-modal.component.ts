import {Component, OnInit, Inject} from '@angular/core';
import {MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';
import {LanguageService} from 'src/app/shared/services/user/language.service';
import {ReviewsApiService} from 'src/app/core/http/reviews-api.service';

@Component({
    selector: 'app-assign-reviewer-modal',
    templateUrl: './assign-reviewer-modal.component.html',
    styleUrls: ['./assign-reviewer-modal.component.scss']
})
export class AssignReviewerModalComponent implements OnInit {

    private article;
    private lang;
    private possibleReviewers = [];
    private bestReviewers = [];
    private loading;
    private choosingReviewer;

    constructor(
        private dialogRef: MatDialogRef<AssignReviewerModalComponent>,
        @Inject(MAT_DIALOG_DATA) data,
        private languageService: LanguageService,
        private reviewsApi: ReviewsApiService
    ) {
        if (data.article) {
            this.article = data.article;
        }

        if (data.lang) {
            this.lang = data.lang;
        }
    }

    ngOnInit() {
        this.loading = true;

        this.reviewsApi.getReviewers(this.article.id).subscribe(
            (res) => {
                if (res.success) {
                    this.possibleReviewers = res.possibleReviewers;
                    this.bestReviewers = res.bestReviewers;
                }
            },
            () => {
            },
            () => {
                this.loading = false;
            }
        );
    }

    dismiss() {
        this.dialogRef.close();
    }

    chooseReviewer(user) {
        this.choosingReviewer = true;

        this.reviewsApi.assignReviewer(this.article.id, user.id).subscribe(
            (res) => {
                res.article = this.article;

                this.dialogRef.close(res);
            },
            () => {},
            () => {
                this.choosingReviewer = false;
            }
        );
    }

}
