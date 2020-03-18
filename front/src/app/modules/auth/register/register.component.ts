import { Component, OnInit, ViewChild } from '@angular/core';
import { RegisterModel } from "../../../shared/models/register.model";
import { FormGroup, FormBuilder, Validators, AbstractControl } from "@angular/forms";
import { RegisterApiService } from "../../../core/http/register-api.service";
import { debounceTime, distinctUntilChanged, map, switchMap } from "rxjs/operators";
import { daterangepicker } from "daterangepicker";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  public registerFormStep1: FormGroup;
  public registerFormStep2: FormGroup;
  public registerFormStep3: FormGroup;
  public registerFormStep4: FormGroup;

  private passwordIsHidden: boolean;
  private registerCompleted: boolean = false;
  public isLoading: boolean = false;
  private emailExist: boolean = false;
  private valueChangesSubscription;

  @ViewChild('datepicker', {static: false}) datepicker: daterangepicker; 

  constructor(
    private formBuilder: FormBuilder,
    private registerApiService: RegisterApiService
  ) {
    this.passwordIsHidden = true;
    this.createForm();
    this.registerFormValuesChanged();
  }

  ngOnInit() {

  }
  createForm() {
    this.registerFormStep1 = this.formBuilder.group({
      'login_email': ['', [
        Validators.required,
        Validators.email,
        this.emailExistValidator.bind(this)
      ]],
      'password': ['', [
        Validators.required,
        Validators.minLength(8)
      ]]
    });

    this.registerFormStep2 = this.formBuilder.group({
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
      ]]
    });

    this.registerFormStep3 = this.formBuilder.group({
      'title': ['', [
        Validators.required
      ]],
      'institution': [],
      'department': [],
      'street': [],
      'city': [],
      'country': []
    });

    this.registerFormStep4 = this.formBuilder.group({
      'contact_email': ['', [
        Validators.email
      ]],
      'phone_number': []
    });
  }

  registerFormValuesChanged() {
    this.valueChangesSubscription = this.login_email.valueChanges
      .pipe(
        map(
          email => {
            this.isLoading = true;
            return email;
          }
        ),
        distinctUntilChanged(),
        debounceTime(1500),
        switchMap(
          email => {
            return this.registerApiService.verifyEmail(email);
          }
        ),
      )
      .subscribe(
        exist => {
          this.emailExist = !exist['success'];
          this.login_email.updateValueAndValidity({ emitEvent: false });
          this.isLoading = false;
        }
      );
  }

  emailExistValidator(control: AbstractControl): {[key: string]: any} | null {
    if (this.emailExist) {
      return {
        'emailExist': true
      }
    }

    return null;
  }

  createNewUser(registerModel: Object) {
    return new RegisterModel(registerModel);
  }

  resendEmailActivation(registerModel: Object) {
    this.registerApiService.resendEmailActivation(this.createNewUser(registerModel)).subscribe();
  }

  registerAccount(registerModel: Object) {
    this.registerApiService.registerAccount(this.createNewUser(registerModel)).subscribe();
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }

  get login_email() {
    return this.registerFormStep1.get('login_email');
  }

  get password() {
    return this.registerFormStep1.get('password');
  }

  get first_name() {
    return this.registerFormStep2.get('first_name');
  }

  get last_name() {
    return this.registerFormStep2.get('last_name');
  }

  get birthdate() {
    return this.registerFormStep2.get('birthdate');
  }

  get gender() {
    return this.registerFormStep2.get('gender');
  }

  get title() {
    return this.registerFormStep3.get('title');
  }

  get institution() {
    return this.registerFormStep3.get('institution');
  }

  get department() {
    return this.registerFormStep3.get('department');
  }

  get street() {
    return this.registerFormStep3.get('street');
  }

  get city() {
    return this.registerFormStep3.get('city');
  }

  get country() {
    return this.registerFormStep3.get('country');
  }

  get contact_email() {
    return this.registerFormStep4.get('contact_email');
  }

  get phone_number() {
    return this.registerFormStep4.get('phone_number');
  }
}

