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
    const object = {
      name: name
    };
    return this.interestsApiService.addInterest(object);
  }
}
