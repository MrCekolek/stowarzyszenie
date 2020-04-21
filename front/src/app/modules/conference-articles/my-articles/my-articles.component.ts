import {Component, OnInit} from '@angular/core';
import {UserProviderService} from 'src/app/core/services/user-provider.service';
import {Router} from '@angular/router';
import {ArticleModel} from 'src/app/shared/models/article.model';
import {LanguageService} from 'src/app/shared/services/user/language.service';
import {ManageConferenceApiService} from 'src/app/core/http/manage-conference-api.service';
import {MatDialog, MatDialogConfig} from '@angular/material';
import {CommentsModalComponent} from '../comments-modal/comments-modal.component';
import {ArticlesApiService} from 'src/app/core/http/articles-api.service';

@Component({
    selector: 'app-my-articles',
    templateUrl: './my-articles.component.html',
    styleUrls: ['./my-articles.component.scss']
})
export class MyArticlesComponent implements OnInit {

    private articles = [];
    private loading;
    private lang;
    private conference;

    constructor(
        private userProvider: UserProviderService,
        private router: Router,
        private languageService: LanguageService,
        private conferenceApi: ManageConferenceApiService,
        private dialog: MatDialog,
        private articlesApi: ArticlesApiService
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

        const obj = {
            user_id: this.userProvider.getUser().id
        };

        this.articlesApi.getUserArticles(obj).subscribe(
            (res) => {
                this.articles = res.conferenceArticles;
            },
            () => {
            },
            () => {
              this.loading = false;
            }
        );
    }

    goToArticleAdd() {
        this.router.navigateByUrl('conference-articles/add');
    }

    openComments(article) {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            comments: article.article_comments
        };

        const dialogRef = this.dialog.open(CommentsModalComponent, dialogConfig);
    }
}
