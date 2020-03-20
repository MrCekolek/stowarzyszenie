import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from "@angular/forms";
import { BeforeResetApiService } from "../../../../core/http/before-reset-api.service";
import { RegisterApiService } from "../../../../core/http/register-api.service";
import { debounceTime, distinctUntilChanged, map, switchMap } from "rxjs/operators";

@Component({
  selector: 'app-before-reset',
  templateUrl: './before-reset.component.html',
  styleUrls: ['./before-reset.component.scss']
})

export class BeforeResetComponent implements OnInit {
  private beforeResetForm: FormGroup;
  private resetSend: boolean = false;
  private isLoading: boolean = false;
  private emailExist: boolean = false;
  private valueChangesSubscription;
  private resetLoading: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private beforeResetApiService: BeforeResetApiService,
    private registerApiService: RegisterApiService
  ) {
    this.createForm();
    this.registerFormValuesChanged();
  }

  createForm() {
    this.beforeResetForm = this.formBuilder.group({
      'login_email': ['', [
        Validators.required,
        Validators.email,
        this.emailExistValidator.bind(this)
      ]]
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
      return null;
    }

    return {
      'emailNotExist': true
    }
  }

  ngOnInit() {
  }

  sendReset(loginEmail) {
    this.resetLoading = true;
    this.resetSend = !this.resetSend;
    const obj = {
      login_email: loginEmail
    };

    this.beforeResetApiService.sendReset(obj).subscribe(data => {
      if (data.success) {
        this.resetLoading = false;
      }
    });
  }

  get login_email() {
    return this.beforeResetForm.get('login_email');
  }
}
