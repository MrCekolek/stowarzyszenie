import { Component, OnInit } from '@angular/core';
import { ArticlesApiService } from 'src/app/core/http/articles-api.service';

@Component({
  selector: 'app-reviews-progress',
  templateUrl: './reviews-progress.component.html',
  styleUrls: ['./reviews-progress.component.scss']
})
export class ReviewsProgressComponent implements OnInit {

  private allArticles = [];
  private loading;

  constructor(
    private articlesApi: ArticlesApiService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.articlesApi.getAllConferenceArticles().subscribe(res => {
      this.allArticles = res.conferenceArticles.filter(x => x.status !== 'waiting' && x.status !== 'in pc'&&  x.status !== 'rejected' );
      this.loading = false;
    });
  }

}
