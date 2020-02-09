import { Injectable } from '@angular/core';
import { ApiService } from './api.service';
import { PortfolioTab } from 'src/app/shared/models/portfolio-tab.model';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PortfolioApiService {

  constructor(
    private apiService: ApiService
  ) { }

  getTabs(userID) {
    return this.apiService.post(`portfolio/tabs/${userID}/get`);
  }

  getTabCards(tabID: number) {
    return this.apiService.post(`portfolio/tile/${tabID}/get`);
  }

  addCard(tab: Object) {
    return this.apiService.post('portfolio/tile/create', tab);
  }

  updateCard(card: Object) {
    return this.apiService.post('portfolio/tile/update', card);
  }

  deleteCard(card) {
    return this.apiService.post('portfolio/tile/destroy', card);
  }

  hideOrShowCard(card: Object) {
    return this.apiService.post('portfolio/tile/visibility/update', card);
  }

  addTab(tab) {
    return this.apiService.post('portfolio/tabs/create', tab);
  }

  updateTab(tab) {
    return this.apiService.post('portfolio/tabs/update', tab);
  }

  deleteTab(tab) {
    return this.apiService.post('portfolio/tabs/destroy', tab);
  }

  // hide / show by admin or user
  // tab with id, shared id, visibility
  hideOrShowTab(tab) {
    return this.apiService.post('portfolio/tabs/visibility/update', tab);
  }

  addNewContentToCard(content: Object) {
    return this.apiService.post('portfolio/tile/content/create', content);
  }

  deleteContentFromCard(content: Object) {
    return this.apiService.post('portfolio/tile/content/destroy', content);
  }

  updateContentInCard(content: Object) {
    return this.apiService.post('portfolio/tile/content/update', content);
  }

  getCardContent(cardID: number) {
    return this.apiService.post(`portfolio/tile/content/${cardID}/get`);
  }

  addContentToCardContent(content) {
    return this.apiService.post('portfolio/tile/content/content/create', content);
  }

  deleteContentFromCardContent(content) {
    return this.apiService.post('portfolio/tile/content/content/destroy', content);
  }

  updateDescription(portfolio: Object) {
    return this.apiService.post('portfolio/update', portfolio);
  }
}
