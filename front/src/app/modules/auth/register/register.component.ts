import { Component, OnInit } from '@angular/core';
import { RegisterModel } from "./model/register.model";
import { FormGroup, FormBuilder, Validators, AbstractControl } from "@angular/forms";
import { RegisterService } from "./service/register.service";
import { distinctUntilChanged } from "rxjs/operators";
import {TranslateService} from "@ngx-translate/core";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  public registerForm: FormGroup;
  private passwordIsHidden: boolean;
  private registerCompleted: boolean = false;
  private isLoading: boolean = false;
  private emailExist: boolean = false;
  private newUser: RegisterModel;
  private errors: string;

  constructor(
    private formBuilder: FormBuilder,
    private registerService: RegisterService,
    private translateService: TranslateService
  ) {
    this.passwordIsHidden = true;
    this.createForm();
    this.registerFormValuesChanged();
  }

  createForm() {
    this.registerForm = this.formBuilder.group({
      'login_email': ['', [
        Validators.required,
        Validators.email,
        this.emailExistValidator.bind(this)
      ]],
      'password': ['', [
        Validators.required,
        Validators.minLength(8)
      ]],
      'first_name': ['', [
        Validators.required
      ]],
      'last_name': ['', [
        Validators.required
      ]],
      'birthdate': ['', [
        Validators.required,
        Validators.minLength(10),
        Validators.maxLength(10),
        Validators.pattern('^([0-2][0-9]|(3)[0-1])(\\/)(((0)[0-9])|((1)[0-2]))(\\/)[1-9][0-9][0-9][0-9]$')
      ]],
      'gender': ['', [
        Validators.required
      ]],
      'title': ['', [
        Validators.required
      ]],
      'institution': [],
      'department': [],
      'street': [],
      'city': [],
      'country': [],
      'contact_email': ['', [
        Validators.email
      ]],
      'phone_number': [],
    });
  }

  registerFormValuesChanged() {
    this.isLoading = true;

    this.login_email.valueChanges.subscribe(
      data => {
        if (!this.login_email.errors || (this.login_email.errors && this.login_email.errors.emailExist)) {
          this.registerService.verifyEmail(data)
            .pipe(
              distinctUntilChanged()
            )
            .subscribe(
            dataRegister => {
              if (dataRegister['success']) {
                this.emailExist = false;
              } else {
                this.emailExist = true;
              }

              this.isLoading = false;
              this.login_email.updateValueAndValidity({ emitEvent: false });
            }
          )
        }
      }
    );
  }

  emailExistValidator(control: AbstractControl): {[key: string]: any} | null {
    if (!this.isLoading) {
      if (this.emailExist) {
        return {
          'emailExist': true
        }
      }

      return null;
    }

    return null;
  }

  createNewUser(registerModel: Object) {
    this.newUser = new RegisterModel(registerModel);
    this.registerService.registerAccount(this.newUser).subscribe();
  }

  resendEmailActivation(registerModel: RegisterModel) {
    this.registerService.resendEmailActivation(registerModel).subscribe();
  }

  ngOnInit() {
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }

  get login_email() {
    return this.registerForm.get('login_email');
  }

  get password() {
    return this.registerForm.get('password');
  }

  get first_name() {
    return this.registerForm.get('first_name');
  }

  get last_name() {
    return this.registerForm.get('last_name');
  }

  get birthdate() {
    return this.registerForm.get('birthdate');
  }

  get gender() {
    return this.registerForm.get('gender');
  }

  get contact_email() {
    return this.registerForm.get('contact_email');
  }
}

