import { Injectable } from '@angular/core';
import { PortfolioApiService } from '../http/portfolio-api.service';
import { ApiService } from '../http/api.service';

@Injectable({
  providedIn: 'root'
})
export class PortfolioService {

  constructor(
    private portfolioApiService: PortfolioApiService,
    private portfolioService: PortfolioService,
    private apiService: ApiService
  ) { }

  getAllTabs() {
    return this.portfolioApiService.getTabs(1);
  }

  getTabCards(tabID) {
     return this.portfolioApiService.getTabCards(tabID);
  }

  addCardToTab(card: Object) {
    return this.portfolioApiService.addCard(card);
  }
}
