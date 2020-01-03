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

  
}
