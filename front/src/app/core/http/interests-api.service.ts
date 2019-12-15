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

  deleteInterest(id: any) {
    return this.api.post(`interest/${id.id}/destroy`, id);
  }

  update(interest) {
    return this.api.post(`interest/${interest.id}/update`, interest);
  }
}
