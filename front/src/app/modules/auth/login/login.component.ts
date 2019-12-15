import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { TranslateService } from "@ngx-translate/core";
import { LoginApiService } from "../../../core/http/login-api.service";
import { LoginModel } from "../../../shared/models/login.model";
import { TokenService } from "./service/token.service";
import { LanguageService } from "../../../shared/services/user/language.service";
import { SharedModule } from "../../../shared/shared.module";
import { UserService } from "../../../shared/services/user/user.service";
import { UserModel } from "../../../shared/models/user.model";
import { Router } from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public loginForm: FormGroup;
  private loginError: string = '';
  private passwordIsHidden: boolean = true;
  private loginModel: LoginModel;
  private isLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private loginApiService: LoginApiService,
    private tokenService: TokenService,
    private translateService: TranslateService,
    private languageService: LanguageService,
    private sharedModule: SharedModule,
    private userService: UserService,
    private router: Router
  ) {
    this.passwordIsHidden = true;
    this.createForm();
  }

  createForm() {
    this.loginForm = this.formBuilder.group({
      'login_email': ['', [
        Validators.required,
        Validators.email
      ]],
      'password': ['', [
        Validators.required,
        Validators.minLength(8)
      ]]
    });
  }

  login(loginForm: FormGroup) {
    this.isLoading = true;
    this.loginModel = new LoginModel(loginForm, this.translateService.currentLang);

    this.loginApiService.login(this.loginModel).subscribe(
      next => {
        this.handleResponse(next);
        this.isLoading = false;
      },
      error => {
        this.handleError(error);
        this.isLoading = false;
      }
    )
  }

  handleResponse(response) {
    this.loginError = '';
    this.tokenService.handle(response.access_token);
    this.userService.changeLoginStatus(true);
    this.userService.changeUser(new UserModel(response['user']['original']));
    this.languageService.setLang(this.sharedModule.detectLang(response['user']['original']['user']['preference_user']['lang']));
    this.router.navigateByUrl('dashboard');
  }

  handleError(error) {
    this.loginError = error.error;
  }

  ngOnInit() {
    this.isLoading = false;
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }

  get login_email() {
    return this.loginForm.get('login_email');
  }

  get password() {
    return this.loginForm.get('password');
  }
}
