import {Component, OnInit} from '@angular/core';
import {MatDialogConfig, MatDialog} from '@angular/material';
import {LanguageService} from 'src/app/shared/services/user/language.service';
import {PreviewReviewerComponent} from '../preview-reviewer/preview-reviewer.component';
import {Router} from '@angular/router';
import {AddCommentReviewerComponent} from '../add-comment-reviewer/add-comment-reviewer.component';
import {ManageConferenceApiService} from "../../../core/http/manage-conference-api.service";
import {UserProviderService} from "../../../core/services/user-provider.service";

@Component({
    selector: 'app-my-reviews',
    templateUrl: './my-reviews.component.html',
    styleUrls: ['./my-reviews.component.scss']
})
export class MyReviewsComponent implements OnInit {

    private loading;
    private lang;
    private assignedArticles = [];
    private conference;
    private articleReviews;
    private loadingReviews;

    constructor(
        private languageService: LanguageService,
        private dialog: MatDialog,
        private router: Router,
        private manageConferenceApiService: ManageConferenceApiService,
        private userProvider: UserProviderService
    ) {
    }

    ngOnInit() {
        this.loading = true;
        this.loadingReviews = true;

        this.languageService.currentLang.subscribe(value => {
            this.lang = value;
        });

        this.manageConferenceApiService.getConference().subscribe(
            (res) => {
                this.conference = res.conference;

                if (this.conference && this.conference.id) {
                    this.manageConferenceApiService.getAllArticleReviews(this.userProvider.getUser().id).subscribe(
                        (data) => {
                            this.assignedArticles = data.articleReviews;
                        },
                        () => {
                        },
                        () => {
                            this.loadingReviews = false;
                        }
                    );
                } else {
                    this.loadingReviews = false;
                }
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

    goToReview(article) {
        this.router.navigateByUrl('conference-reviews/review/' + article.id);
    }

    addComment(article) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            article: article
        };

        const dialogRef = this.dialog.open(AddCommentReviewerComponent, dialogConfig);
    }

    isReviewed(review) {
        return review.description && review.mark;
    }
}
