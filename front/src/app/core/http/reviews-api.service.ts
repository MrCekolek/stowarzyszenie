import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";

@Injectable({
  providedIn: 'root'
})
export class ReviewsApiService {

  constructor(
      private apiService: ApiService
  ) { }

  addReview(review) {
    return this.apiService.post('conference/track/article/review/update', review);
  }

  getReviewers(articleId) {
    const obj = {
      id: articleId
    };

    return this.apiService.post('conference/track/article/reviewer/get', obj);
  }

  assignReviewer(articleId, userId) {
    const obj = {
      track_article_id: articleId,
      user_id: userId
    };

    return this.apiService.post('conference/track/article/review/create', obj);
  }
}
