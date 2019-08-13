import { Component } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { TokenService } from "../../../services/token/token.service";
import { Router } from "@angular/router";
import { TranslateService } from "@ngx-translate/core";
import { LanguageService } from "../../../services/language/language.service";
import { AppComponent } from "../../../app.component";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  public form = {
    email: null,
    password: null
  };

  public error = null;

  constructor(
    private authService: AuthService,
    private tokenService: TokenService,
    private router: Router,
    private translateService: TranslateService,
    private languageService: LanguageService,
    private appComponent: AppComponent
  ) { }

  onSubmit() {
     this.authService.login(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.handleError(error)
    );
  }

  handleResponse(data) {
    this.tokenService.handle(data.access_token);
    this.authService.changeAuthStatus(true);
    this.router.navigateByUrl('/profile');
    this.languageService.setLang(this.appComponent.detectLang(data['user']['original']['preference_user']['lang']));
  }

  handleError(error) {
    this.error = error.error.error;
  }
}
