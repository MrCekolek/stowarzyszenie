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

  getTrack(track) {
    return this.api.post(`conference/track/${track.id}/get`, track);
  }

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

  addChairsToTrack(chairs, trackId) {
    const obj = {
      chairs: chairs,
      track_id: trackId
    };

    return this.api.post(`conference/track/chair/create/multi`, obj);
  }

  addReviewerToTrack(reviewer) {
    return this.api.post(`conference/track/reviewer/create`, reviewer);
  }

  addReviewersToTrack(reviewers, trackId) {
    const obj = {
      reviewers: reviewers,
      track_id: trackId
    };

    return this.api.post(`conference/track/reviewer/create/multi`, obj);
  }

  getRegisteredUsers() {
    return this.api.post('conference/user/get');
  }

  getCFP(conference) {
    return this.api.post('conference/cfp', conference);
  }

  addCFP(cfp) {
    return this.api.post('conference/cfp/create', cfp);
  }

  updateCFP(cfp) {
    return this.api.post('conference/cfp/update', cfp);
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

  updateConfpage(confpage) {
    return this.api.post('conference/page/update', confpage);
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

  deleteEvent(event) {
    return this.api.post('conference/event/destroy', event);
  }

  //PC
  getPC(conferenceId) {
    const obj = {
      conference_id: conferenceId
    };

    return this.api.post('conference/programme_committee/get', obj);
  }

  createPC(conferenceId, users) {
    const obj = {
      conference_id: conferenceId,
      users: users
    };

    return this.api.post('conference/programme_committee/createMulti', obj);
  }

  // Gallery
  destroyMultiGalleries(ids, conferenceId) {
    const obj = {
      ids: ids,
      conference_id: conferenceId
    };

    return this.api.post('conference/gallery/destroy/multi', obj);
  }

  downloadFile(obj) {
    return this.api.post('conference/cfp/download/file', obj);
  }
}
