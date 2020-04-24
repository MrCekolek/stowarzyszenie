import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SharedModule } from '../../shared/shared.module';
import { ArticlesToAssignComponent } from './articles-to-assign/articles-to-assign.component';
import { MyReviewsComponent } from './my-reviews/my-reviews.component';
import { ReviewsProgressComponent } from './reviews-progress/reviews-progress.component';
import { ArticleReviewComponent } from './article-review/article-review.component';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        redirectTo: 'my'
      },
      {
        path: 'my',
        component: MyReviewsComponent
      },
      {
        path: 'assign',
        component: ArticlesToAssignComponent
      },
      {
        path: 'progress',
        component: ReviewsProgressComponent
      },
      {
        path: 'review',
        component: ArticleReviewComponent
      },
      {
        path: 'review/:id',
        component: ArticleReviewComponent
      }
    ]
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
    SharedModule
  ],
  exports: [RouterModule]
})
export class ConferenceReviewsRoutingModule { }
