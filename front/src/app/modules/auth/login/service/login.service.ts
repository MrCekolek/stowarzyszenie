import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { TranslateService } from "@ngx-translate/core";
import { LoginModel } from "../model/login.model";

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private baseURL = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    // private tokenService: TokenService,
    private translateService: TranslateService
  ) { }

  login(loginModel: LoginModel) {
    return this.http.post(`${this.baseURL}/account/login`, loginModel);
  }
}
