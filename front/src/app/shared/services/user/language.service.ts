import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject } from "rxjs";
import { TranslateService } from "@ngx-translate/core";
import { UserService } from "./user.service";
import { ApiService } from "../../../core/http/api.service";

@Injectable({
  providedIn: 'root'
})
export class LanguageService {
  public loggedIn: boolean;
  public supportedLangs = [
    'pl',
    'en',
    'ru',
  ];
  private lang = new BehaviorSubject <string> (this.translateService.getBrowserLang());
  public currentLang = this.lang.asObservable();

  constructor(
    private http: HttpClient,
    private translateService: TranslateService,
    private userService: UserService,
    private api: ApiService
  ) {
    this.userService.loginStatus.subscribe(value => this.loggedIn = value);

    if (this.loggedIn) {
      this.getLang();
    }
  }

  setLang(lang) {
    if (this.supportedLangs.includes(lang)) {
      let data = {
        lang: lang
      };

      return this.api.post('lang/set', data).subscribe(
        data => {
          this.lang.next(data['lang']);
        }
      );
    }
  }

  getLang() {
    return this.api.post('lang/get').subscribe(
      data => {
        this.setLang(data['lang'])
      }
    );
  }
}
