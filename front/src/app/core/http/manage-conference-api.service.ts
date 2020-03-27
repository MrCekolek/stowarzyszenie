import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class ManageConferenceApiService {

  constructor(
    private api: ApiService
  ) { }

  getConference() {
    return this.api.post('conference/active/get');
  }

  addConference(conference: Object) {
    return this.api.post('conference/create', conference);
  }

  removeConference() {

  }
}
