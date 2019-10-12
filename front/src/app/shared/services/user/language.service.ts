import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { TranslateService } from "@ngx-translate/core";
import { UserService } from "./user.service";

@Injectable({
  providedIn: 'root'
})
export class LanguageService {
  public loggedIn: boolean;
  private baseURL = 'http://localhost:8000/api';
  public supportedLangs = [
    'en',
    'pl',
    'ru',
  ];
  private lang = new BehaviorSubject <string> (this.translateService.getBrowserLang());
  public currentLang = this.lang.asObservable();

  constructor(
    private http: HttpClient,
    private translateService: TranslateService,
    private userService: UserService
  ) {
    this.userService.loginStatus.subscribe(value => this.loggedIn = value);

    if (this.loggedIn) {
      this.getLang();
    }
  }

  setLang(lang) {
    if (this.supportedLangs.includes(lang)) {
      var data = {
        'token': localStorage.getItem('token'),
        'lang': lang
      };

      return this.http.post(`${this.baseURL}/lang/set`, data).subscribe(
        data => {
          this.lang.next(data['lang']);
        }
      );
    }
  }

  getLang() {
    var data = {
      'token': localStorage.getItem('token')
    }

    return this.http.post(`${this.baseURL}/lang/get`, data).subscribe(
      data => {
        this.setLang(data['lang'])
      }
    );

  }
}
