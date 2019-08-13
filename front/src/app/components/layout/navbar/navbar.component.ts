import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { Router } from "@angular/router";
import { TokenService } from "../../../services/token/token.service";
import { TranslateService } from "@ngx-translate/core";
import { LanguageService } from "../../../services/language/language.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  public loggedIn: boolean;

  constructor(
    private authService: AuthService,
    private tokenService: TokenService,
    private router: Router,
    private translateService: TranslateService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.authService.authStatus.subscribe(value => this.loggedIn = value);
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.tokenService.remove();
    this.authService.changeAuthStatus(false);
    this.router.navigateByUrl('/login');
  }

  setLang(lang) {
    this.languageService.setLang(lang);
  }
}
