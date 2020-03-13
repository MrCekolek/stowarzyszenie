import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NavigationService {

  homepagesList = [];
  selectedPage: any;

  constructor() { }

  getPage(id) {
    return this.homepagesList.find(x => x.id === id );
  }
}
