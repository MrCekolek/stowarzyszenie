export class UserModel {
  login_email: string;
  first_name: string;
  last_name: string;
  birthdate: string;
  gender: number;
  affilation_user?: object;
  preference_user?: object;
  lang: string;

  constructor(userModel: Object) {
    this.login_email = userModel['login_email'];
    this.first_name = userModel['first_name'];
    this.last_name = userModel['last_name'];
    this.birthdate = userModel['birthdate'];
    this.gender = userModel['gender'];
    this.affilation_user = userModel['affilation_user'];
    this.preference_user = userModel['preference_user'];
  }

  setLang(lang: string) {
    this.lang = lang;
  }
}
