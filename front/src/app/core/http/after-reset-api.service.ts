import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class AfterResetApiService {

  constructor(
    private api: ApiService
  ) { }

  changePassword(afterResetForm: Object) {
    return this.api.post('account/password/change', afterResetForm);
  }
}
