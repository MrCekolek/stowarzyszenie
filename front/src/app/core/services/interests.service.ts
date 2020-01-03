import { Injectable } from '@angular/core';
import { InterestsApiService } from '../http/interests-api.service';

@Injectable({
  providedIn: 'root'
})
export class InterestsService {

  constructor(
    private interestsApiService: InterestsApiService
  ) { }

  getInterests() {
    return this.interestsApiService.getAllInterests();
  }

  addNewInterest(interest: Object) {
    return this.interestsApiService.addInterest(interest);
  }

  deleteInterest(interestID: number) {
    const obj = {
      id: interestID
    };
    return this.interestsApiService.deleteInterest(obj);
  }

  updateInterest(interest) {
    return this.interestsApiService.update(interest);
  }
}
