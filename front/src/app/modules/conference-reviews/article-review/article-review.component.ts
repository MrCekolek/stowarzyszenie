import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';
import { ReviewsApiService } from 'src/app/core/http/reviews-api.service';

@Component({
  selector: 'app-article-review',
  templateUrl: './article-review.component.html',
  styleUrls: ['./article-review.component.scss']
})
export class ArticleReviewComponent implements OnInit {

  private article;
  private articleID;
  private review;

  private review_text;

  constructor(
    private route: ActivatedRoute,
    private articlesApi: ArticlesApiService,
    private reviewsApi: ReviewsApiService
  ) { }

  ngOnInit() {
    // TODO: pobranie artykulu / recenzji / jednego i drugiego z api service na podstawie parametru w route (trzeba zrobic endpoint z review do artykulu)
    // this.articleID = this.route.snapshot.paramMap.get('id');
  }

}
