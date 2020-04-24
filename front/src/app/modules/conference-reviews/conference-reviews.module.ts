import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from 'src/app/shared/shared.module';
import { ArticlesToAssignComponent } from './articles-to-assign/articles-to-assign.component';
import { ConferenceReviewsRoutingModule } from './conference-reviews-routing.module';
import { MyReviewsComponent } from './my-reviews/my-reviews.component';
import { ReviewsProgressComponent } from './reviews-progress/reviews-progress.component';
import { AssignReviewerModalComponent } from './assign-reviewer-modal/assign-reviewer-modal.component';
import { AddCommentReviewerComponent } from './add-comment-reviewer/add-comment-reviewer.component';
import { PreviewReviewerComponent } from './preview-reviewer/preview-reviewer.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ArticleReviewComponent } from './article-review/article-review.component';
import { ReviewModalComponent } from './review-modal/review-modal.component';

@NgModule({
  declarations: [ArticlesToAssignComponent, MyReviewsComponent, ReviewsProgressComponent, AssignReviewerModalComponent, AddCommentReviewerComponent, PreviewReviewerComponent, ArticleReviewComponent, ReviewModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    ConferenceReviewsRoutingModule,
    FormsModule,
    ReactiveFormsModule
  ],
  entryComponents: [AssignReviewerModalComponent, AddCommentReviewerComponent, PreviewReviewerComponent, ReviewModalComponent]
})
export class ConferenceReviewsModule { }
