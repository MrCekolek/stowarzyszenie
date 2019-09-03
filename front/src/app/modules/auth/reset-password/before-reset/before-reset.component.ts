import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from "@angular/forms";
import { BeforeResetService } from "./service/before-reset.service";
import { RegisterService } from "../../register/service/register.service";
import { delay, distinctUntilChanged } from "rxjs/operators";

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

  constructor(
    private formBuilder: FormBuilder,
    private beforeResetService: BeforeResetService,
    private registerService: RegisterService
  ) { }

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
    this.isLoading = true;

    this.login_email.valueChanges.subscribe(
      data => {
        if (!this.login_email.hasError('email')) {
          this.registerService.verifyEmail(data)
            .pipe(
              delay(500),
              distinctUntilChanged()
            )
            .subscribe(
              dataRegister => {
                if (dataRegister['success']) {
                  this.emailExist = false;
                } else {
                  this.emailExist = true;
                }

                this.login_email.updateValueAndValidity({ emitEvent: false });
              }
            )
        }
      }
    );

    this.isLoading = false;
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
    this.createForm();
    this.registerFormValuesChanged();
  }

  sendReset(beforeResendForm) {
    this.resetSend = !this.resetSend;

    this.beforeResetService.sendReset(beforeResendForm).subscribe()
  }

  get login_email() {
    return this.beforeResetForm.get('login_email');
  }
}
