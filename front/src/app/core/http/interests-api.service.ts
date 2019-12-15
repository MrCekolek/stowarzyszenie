import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class InterestsApiService {

  constructor(
    private api: ApiService
  ) { }

  getAllInterests() {
    return this.api.post('interest/get');
  }

  addInterest(name: Object) {
    return this.api.post('interest/create', name);
  }
}
