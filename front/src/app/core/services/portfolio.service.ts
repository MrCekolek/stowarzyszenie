import { Injectable } from '@angular/core';
import { PortfolioApiService } from '../http/portfolio-api.service';

@Injectable({
  providedIn: 'root'
})
export class PortfolioService {


  constructor(
    private portfolioApiService: PortfolioApiService
  ) { }

  getAllTabs() {
    return this.portfolioApiService.getTabs(1);
  }

  getTabCards(tabID) {
     return this.portfolioApiService.getTabCards(tabID);
  }
}
