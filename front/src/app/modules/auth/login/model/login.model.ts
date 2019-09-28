import { FormGroup } from "@angular/forms";

export class LoginModel {
  login_email: string;
  password: string;
  lang: string;

  constructor(loginForm: FormGroup, lang: string) {
    this.login_email = loginForm['login_email'];
    this.password = loginForm['password'];

    this.setLang(lang);
  }

  setLang(lang: string) {
    this.lang = lang;
  }
}
