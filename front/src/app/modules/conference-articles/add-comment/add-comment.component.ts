import {Component, OnInit, Inject} from '@angular/core';
import {MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';
import {ArticlesApiService} from 'src/app/core/http/articles-api.service';
import {UserProviderService} from 'src/app/core/services/user-provider.service';
import {LanguageService} from "../../../shared/services/user/language.service";

@Component({
    selector: 'app-add-comment',
    templateUrl: './add-comment.component.html',
    styleUrls: ['./add-comment.component.scss']
})
export class AddCommentComponent implements OnInit {

    private article;
    private lang;
    private user_id;
    private addLoading;

    private newComment = {
        description: '',
        user_id: '',
        track_article_id: ''
    };

    constructor(
        private dialogRef: MatDialogRef<AddCommentComponent>,
        @Inject(MAT_DIALOG_DATA) data,
        private articlesApi: ArticlesApiService,
        private userProvider: UserProviderService,
        private languageService : LanguageService
    ) {
        if (data.article) {
            this.article = data.article;
        }
    }

    ngOnInit() {
        this.languageService.currentLang.subscribe(res => {
            this.lang = res;
        });

        this.user_id = this.userProvider.getUser().id;

        this.newComment = {
            description: '',
            user_id: this.user_id,
            track_article_id: this.article.id
        };
    }

    dismiss() {
        this.dialogRef.close();
    }

    addComment() {
        this.addLoading = true;

        this.articlesApi.addComment(this.newComment).subscribe(
            (res) => {
                if (res.success) {
                    this.article.article_comments.unshift(res.articleComment);
                    this.newComment.description = '';
                }
            },
            () => {},
            () => {
              this.addLoading = false;
            }
        );
    }
}
