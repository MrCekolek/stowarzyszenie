import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MyArticlesComponent } from './my-articles/my-articles.component';
import { ConferenceArticlesRoutingModule } from './conference-articles-routing.module';
import { SharedModule } from 'src/app/shared/shared.module';
import { SubmitArticleComponent } from './submit-article/submit-article.component';
import { AllArticlesComponent } from './all-articles/all-articles.component';
import { FormsModule } from '@angular/forms';
import { CommentsModalComponent } from './comments-modal/comments-modal.component';
import { EditArticleComponent } from './edit-article/edit-article.component';
import { ArticlePreviewComponent } from './article-preview/article-preview.component';
import { AddCommentComponent } from './add-comment/add-comment.component';

@NgModule({
  declarations: [MyArticlesComponent, SubmitArticleComponent, AllArticlesComponent, CommentsModalComponent, EditArticleComponent, ArticlePreviewComponent, AddCommentComponent],
  imports: [
    CommonModule,
    ConferenceArticlesRoutingModule,
    SharedModule,
    FormsModule
  ],
  entryComponents: [CommentsModalComponent, ArticlePreviewComponent, AddCommentComponent]
})
export class ConferenceArticlesModule { }
