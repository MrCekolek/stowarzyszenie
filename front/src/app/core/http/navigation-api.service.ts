import { Injectable } from '@angular/core';
import { ApiService } from './api.service';
import { HomeNavigation } from 'src/app/shared/models/home-navigation';

@Injectable({
  providedIn: 'root'
})
export class NavigationApiService {

  constructor(
    private api: ApiService
  ) { }

  // pobiera linki nawigacji ze strony głównej
  getHomeLinks() {
    return this.api.post('home_navigation');
  }

  getHomeLink(linkID: any) {
    return this.api.post(`home_navigation/${linkID.id}`, linkID);
  }

  addHomeLink(newLink: HomeNavigation) {
    return this.api.post('home_navigation/create', newLink);
  }

  updateHomeLink(link: HomeNavigation) {
    return this.api.post('home_navigation/update', link);
  }

  deleteHomeLink(linkID: number) {
    return this.api.post('home_navigation/destroy');
  }
}
