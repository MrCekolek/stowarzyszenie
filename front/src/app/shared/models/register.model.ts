export class RegisterModel {
  login_email: string;
  password: string;
  first_name: string;
  last_name: string;
  birthdate: string;
  gender: number;
  title?: string;
  institution?: string;
  department?: string;
  street?: string;
  city?: string;
  country?: string;
  contact_email?: string;
  phone_number?: string;
  lang: string;
  avatar: string;

  constructor(registerModel: Object) {
    this.login_email = registerModel['login_email'];
    this.password = registerModel['password'];
    this.first_name = registerModel['first_name'];
    this.last_name = registerModel['last_name'];
    this.birthdate = registerModel['birthdate'];
    this.gender = registerModel['gender'];
    this.title = registerModel['title'];
    this.institution = registerModel['institution'];
    this.department = registerModel['department'];
    this.street = registerModel['street'];
    this.city = registerModel['city'];
    this.country = registerModel['country'];
    this.contact_email = registerModel['contact_email'];
    this.phone_number = registerModel['phone_number'];
    this.avatar = this.gender === 0 ? '../../../../assets/images/default_man.png' : '../../../../assets/images/default_woman.png';
  }

  setLang(lang: string) {
    this.lang = lang;
  }
}
