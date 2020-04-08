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

  updateConference(conference: Object) {
    return this.api.post('conference/update', conference);
  }

  //TODO: endpoint do pobrania jednego tracku
  // zwrocenie z trackiem razem listy recenzentow, chairsow
  getTrack(track) {
    return this.api.post(`conference/track/${track.id}/get`, track);
  }

  //TODO:
  // zwracanei z trackiem razem listy recenzentow, chairsow
  getTracks(conference: Object) {
    return this.api.post('conference/track/get', conference);
  }

  addTrack(track: Object) {
    return this.api.post('conference/track/create', track);
  }

  updateTrack(track: Object) {
    return this.api.post('conference/track/update', track);
  }

  getTrackReviewers(track) {
    return this.api.post(`conference/track/reviewer/${track.id}/get`, track);
  }

  getTrackChair(track) {
    return this.api.post(`conference/track/chair/${track.id}/get`, track);
  }

  addChairToTrack(chair) {
    return this.api.post(`conference/track/chair/create`, chair);
  }

  addReviewerToTrack(reviewer) {
    return this.api.post(`conference/track/reviewer/create`, reviewer);
  }

  // TODO: endpoint do pobrania wszystkich userow zarejestrowanych do konferencji
  getRegisteredUsers() {
    
  }

  getCFP(conference) {
    return this.api.post('conference/cfp', conference);
  }

  addCFP(cfp) {
    return this.api.post('conference/cfp/create', cfp);
  }

  getConferenceNavigation(cfp) {
    return this.api.post('conference/page/get', cfp);
  }

  getSubpage(subpage) {
    return this.api.post(`conference/page/${subpage.id}`, subpage);
  }

  addConfpage(confpage) {
    return this.api.post('conference/page/create', confpage);
  }

  // calendar
  getCalendar(confid) {
    return this.api.post('conference/event/get', confid);
  }

  addEvent(event) {
    return this.api.post('conference/event/create', event);
  }
  
  updateEvent(event) {
    return this.api.post('conference/event/update', event);
  }
}
