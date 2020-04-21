import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class ArticlesApiService {

  constructor(
    private api: ApiService
  ) { }

  getUserArticles(user: Object) {
    return this.api.post('conference/article/user/get', user);
  }

  createArticle(article: Object) {
    return this.api.post('conference/track/article/create', article);
  }

  updateArticle(article: Object) {
    return this.api.post('conference/track/article/update', article);
  }

  getArticle(articleID: Object) {
    return this.api.post('conference/track/article/show', articleID);
  }

  getAllConferenceArticles() {
    return this.api.post('conference/article/get');
  }

  addComment(comment: Object) {
    return this.api.post('conference/track/article/comment/create', comment);
  }
}
