import {Component, OnInit} from '@angular/core';
import {ArticlesApiService} from 'src/app/core/http/articles-api.service';
import {ManageConferenceApiService} from 'src/app/core/http/manage-conference-api.service';
import {LanguageService} from 'src/app/shared/services/user/language.service';
import {MatDialogConfig, MatDialog} from '@angular/material';
import * as _ from 'lodash';
import { ArticlePreviewComponent } from '../article-preview/article-preview.component';
import { AddCommentComponent } from '../add-comment/add-comment.component';
import { AddCommentReviewerComponent } from '../../conference-reviews/add-comment-reviewer/add-comment-reviewer.component';

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
    ) {
    }

    ngOnInit() {
        this.loading = true;

        this.languageService.currentLang.subscribe(res => {
            this.lang = res;
        });

        this.conferenceApi.getConference().subscribe(res => {
            this.conference = res.conference;
        });

        this.articlesApi.getAllConferenceArticles().subscribe(
            (res) => {
                this.allArticles = res.conferenceArticles;
                this.acceptedArticles = this.allArticles.filter(t => t.status === 'accepted' || (t.status !== 'rejected' && t.status !== 'waiting'));
                this.rejectedArticles = this.allArticles.filter(t => t.status === 'rejected');
                this.toManageArticles = this.allArticles.filter(t => t.status === 'waiting');
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

        const dialogRef = this.dialog.open(ArticlePreviewComponent, dialogConfig);
    }

    acceptArticle(article) {
        this.loading = true;

        var articleTmp = _.cloneDeep(article);
        articleTmp.status = 'accepted';

        this.articlesApi.updateArticle(articleTmp).subscribe(
            (res) => {
                if (res.success) {
                    this.acceptedArticles.push(res.trackArticle);

                    const indexAllArticles = this.allArticles.findIndex(item => item.id === article.id);
                    this.allArticles[indexAllArticles] = res.trackArticle;

                    const index = this.toManageArticles.findIndex(item => item.id === article.id);
                    this.toManageArticles.splice(index, 1);
                }
            },
            () => {},
            () => {
              this.loading = false;
            }
        );
    }

    rejectArticle(article) {
        this.loading = true;

        var articleTmp = _.cloneDeep(article);
        articleTmp.status = 'rejected';

        this.articlesApi.updateArticle(articleTmp).subscribe(
            (res) => {
                if (res.success) {
                    this.rejectedArticles.push(res.trackArticle);

                    const indexAllArticles = this.allArticles.findIndex(item => item.id === article.id);
                    this.allArticles[indexAllArticles] = res.trackArticle;

                    const indexManageArticles = this.toManageArticles.findIndex(item => item.id === article.id);
                    this.toManageArticles.splice(indexManageArticles, 1);
                }
            },
            () => {
            },
            () => {
                this.loading = false;
            }
        );
    }

    restoreArticle(article) {
        this.loading = true;

        var articleTmp = _.cloneDeep(article);
        articleTmp.status = 'waiting';

        this.articlesApi.updateArticle(articleTmp).subscribe(
            (res) => {
                if (res.success) {
                    this.toManageArticles.push(res.trackArticle);

                    const indexAllArticles = this.allArticles.findIndex(item => item.id === article.id);
                    this.allArticles[indexAllArticles] = res.trackArticle;

                    const index = this.rejectedArticles.findIndex(item => item.id === article.id);
                    this.rejectedArticles.splice(index, 1);
                }
            },
            () => {
            },
            () => {
                this.loading = false;
            }
        );
    }

    addComment(article) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            article: article
        };

        const dialogRef = this.dialog.open(AddCommentComponent, dialogConfig);
    }

}
