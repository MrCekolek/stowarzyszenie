import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { TokenService } from "../token/token.service";
import { TranslateService } from "@ngx-translate/core";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedIn = new BehaviorSubject <boolean> (this.tokenService.loggedIn());
  authStatus = this.loggedIn.asObservable();
  private baseURL = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private tokenService: TokenService,
    private translateService: TranslateService
  ) { }

  signup(data) {
    data.lang = this.translateService.currentLang;
    return this.http.post(`${this.baseURL}/signup`, data);
  }

  login(data) {
    return this.http.post(`${this.baseURL}/login`, data);
  }

  changeAuthStatus(value: boolean) {
    this.loggedIn.next(value);
  }

  sendPasswordResetLink(data) {
    return this.http.post(`${this.baseURL}/sendPasswordResetLink`, data);
  }

  changePassword(data) {
    return this.http.post(`${this.baseURL}/changePassword`, data);
  }
}
