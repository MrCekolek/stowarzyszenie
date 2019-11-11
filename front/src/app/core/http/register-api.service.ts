import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { RegisterModel } from '../../shared/models/register.model';
import { TranslateService } from "@ngx-translate/core";
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class RegisterApiService {

  constructor(
    private api: ApiService,
    private http: HttpClient,
    private translateService: TranslateService
  ) { }

  verifyEmail(email: string) {
    return this.api.post('email/exist', {
      email: email
    });
  }

  registerAccount(registerModel: RegisterModel) {
    registerModel.setLang(this.translateService.currentLang);
    return this.api.post('account/register', registerModel);
  }

  resendEmailActivation(registerModel: RegisterModel) {
    return this.api.post('account/register/resend', registerModel);
  }
}
