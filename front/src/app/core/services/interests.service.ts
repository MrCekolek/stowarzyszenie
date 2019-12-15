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

  addNewInterest(name: string) {
    const obj = {
      name: name
    };
    return this.interestsApiService.addInterest(obj);
  }

  deleteInterest(interestID: number) {
    const obj = {
      id: interestID
    };
    return this.interestsApiService.deleteInterest(obj);
  }

  updateInterest(interestID, new_name) {
    const obj = {
      id: interestID,
      name: new_name
    };
    return this.interestsApiService.update(obj);
  }
}
