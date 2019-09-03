import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { RegisterModel } from "../model/register.model";
import { TranslateService } from "@ngx-translate/core";
import {stringify} from "querystring";

@Injectable({
  providedIn: 'root'
})
export class RegisterService {
  private baseURL: string = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private translateService: TranslateService
  ) { }

  verifyEmail(email: string) {
    return this.http.post(this.baseURL + '/email/exist',{
      email: email
    });
  }

  registerAccount(registerModel: RegisterModel) {
    registerModel.setLang(this.translateService.currentLang);

    return this.http.post(`${this.baseURL}/account/register`, registerModel);
  }

  resendEmailActivation(registerModel: RegisterModel) {
    return this.http.post(`${this.baseURL}/account/register/resend`, registerModel);
  }
}
