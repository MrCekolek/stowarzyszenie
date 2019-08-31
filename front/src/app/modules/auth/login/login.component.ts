import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { TranslateService } from "@ngx-translate/core";
import { LoginService } from "./service/login.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public loginForm: FormGroup;
  error = false;
  passwordIsHidden = true;

  constructor(
    private formBuilder: FormBuilder,
    private loginService: LoginService,
    private translateService: TranslateService
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
    console.log(loginForm);
  }

  ngOnInit() {
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
