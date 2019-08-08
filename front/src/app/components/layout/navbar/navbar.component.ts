import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { Router } from "@angular/router";
import { TokenService } from "../../../services/token/token.service";
import { TranslateService } from "@ngx-translate/core";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  public loggedIn: boolean;
  public browserLanguage;

  constructor(
    private authService: AuthService,
    private tokenService: TokenService,
    private router: Router,
    public translateService: TranslateService
  ) {
    translateService.addLangs([
      'en',
      'pl',
      'ru'
    ]);
    translateService.setDefaultLang('en');
    this.browserLanguage = translateService.getBrowserLang();
    translateService.use(this.browserLanguage.match(/en|pl|ru/) ? this.browserLanguage : 'en');
  }

  ngOnInit() {
    this.authService.authStatus.subscribe(value => this.loggedIn = value);
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.tokenService.remove();
    this.authService.changeAuthStatus(false);
    this.router.navigateByUrl('/login');
  }
}
