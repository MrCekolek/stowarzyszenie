import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class BeforeResetService {

  constructor(
    private api: ApiService
  ) { }

  sendReset(beforeResendForm: Object) {
    return this.api.post('account/password/reset', beforeResendForm);
  }
}
