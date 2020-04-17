import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class ArticlesApiService {

  constructor(
    private api: ApiService
  ) { }

  createArticle(article: Object) {
    return this.api.post('conference/track/article/create', article);
  }

  updateArticle(article: Object) {
    return this.api.post('conference/track/article/update', article);
  }
}
