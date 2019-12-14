import { Role } from './role.model';

export class UserModel {
  id: number;
  login_email: string;
  contact_email?: string;
  first_name: string;
  last_name: string;
  birthdate: string;
  gender: number;
  affilation_user?: object;
  preference_user?: object;
  lang: string;
  roles: Array<Role>;
  phone_number?: string; 

  constructor(userModel: Object) {
    this.login_email = userModel['user']['login_email'];
    this.first_name = userModel['user']['first_name'];
    this.last_name = userModel['user']['last_name'];
    this.birthdate = userModel['user']['birthdate'];
    this.gender = userModel['user']['gender'];
    this.affilation_user = userModel['user']['affilation_user'];
    this.preference_user = userModel['user']['preference_user'];
    this.roles = userModel['user']['roles'];
  }

  setLang(lang: string) {
    this.lang = lang;
  }
}
