import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ReviewsApiService } from 'src/app/core/http/reviews-api.service';
import { UserProviderService } from "../../../core/services/user-provider.service";
import * as _ from 'lodash';

@Component({
  selector: 'app-article-review',
  templateUrl: './article-review.component.html',
  styleUrls: ['./article-review.component.scss']
})
export class ArticleReviewComponent implements OnInit {

  private article;
  private articleID;
  private review;
  private loading;
  private addingReview;

  constructor(
    private route: ActivatedRoute,
    private articlesApi: ArticlesApiService,
    private reviewsApi: ReviewsApiService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.articleID = this.route.snapshot.paramMap.get('id');

    this.articlesApi.getReview(this.articleID).subscribe(
        (res) => {
          if (res.success) {
            this.article = res.articleReview;
            this.review = _.cloneDeep(res.articleReview);
          }
        },
        () => {},
        () => {
          this.loading = false;
        }
    );
  }

  isReviewed() {
    return this.article.description && this.article.mark;
  }

  markChange(mark, status) {
    this.review.mark = mark;
    this.review.status = status;
  }

  addReview() {
    this.addingReview = true;

    this.reviewsApi.addReview(this.review).subscribe(
        (res) => {
          this.article = res.articleReview;
          this.review = _.cloneDeep(res.articleReview);
        },
        () => {},
        () => {
          this.addingReview = false;
        }
    );
  }

}
