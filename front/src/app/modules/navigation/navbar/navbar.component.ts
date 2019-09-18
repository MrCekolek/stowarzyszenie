import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { UserService } from "../../../shared/services/user/user.service";
import * as $ from 'jquery';
import { TokenService } from "../../auth/login/service/token.service";
import { Router } from "@angular/router";
import { LanguageService } from "../../../shared/services/user/language.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {
  private loggedIn: boolean;
  private flagsImages = [
    "../../../../assets/images/united_kingdom.png",
    "../../../../assets/images/poland.png",
    "../../../../assets/images/russi.png"
  ];
  private translations = [
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.EN',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.PL',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.RU'
  ];
  private languageIndex = {
    'en': 0,
    'pl': 1,
    'ru': 2,
  };

  constructor(
    private translateService: TranslateService,
    private userService: UserService,
    private tokenService: TokenService,
    private router: Router,
    private languageService: LanguageService
  ) {
    this.userService.loginStatus.subscribe(value => this.loggedIn = value );
  }

  ngOnInit() {
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.tokenService.remove();
    this.userService.changeLoginStatus(false);
    this.router.navigateByUrl('/auth/login');
  }

  setLang(lang) {
    this.languageService.setLang(lang);
  }
}
