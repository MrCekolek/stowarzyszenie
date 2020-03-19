import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { AfterResetApiService } from "../../../../core/http/after-reset-api.service";

@Component({
  selector: 'app-after-reset',
  templateUrl: './after-reset.component.html',
  styleUrls: ['./after-reset.component.scss']
})
export class AfterResetComponent implements OnInit {
  afterResetForm: FormGroup;
  passwordIsHidden: boolean;
  private reseted: boolean;
  private resetingError;
  private resettingLoader: boolean = false;
  private routeParams = {
    login_email: null,
    token: null
  }

  constructor(
    private formBuilder: FormBuilder,
    private activatedRoute: ActivatedRoute,
    private afterResetApiService: AfterResetApiService
  ) {
    this.passwordIsHidden = true;
    this.activatedRoute.queryParams.subscribe(
      params => {
        this.routeParams.login_email = params['login_email'],
        this.routeParams.token = params['token']
      })
   }

  ngOnInit() {
    this.reseted = false;
    this.resetingError = '';

    this.createForm();
  }

  createForm() {
    this.afterResetForm = this.formBuilder.group({
      'login_email': [this.routeParams.login_email, [
        Validators.required
      ]],
      'token': [this.routeParams.token, [
        Validators.required
      ]],
      'password': ['', [
        Validators.required,
        Validators.minLength(8)
      ]]
    });
  }

  changePassword(afterResetForm: Object) {
    this.resettingLoader = true;
    this.afterResetApiService.changePassword(afterResetForm).subscribe(
      (data) => {
        if (data.success) {
          this.reseted = true;
        } else {
          this.resetingError = data.error.token[0];
          this.reseted = false;
        }
      },
      () => {},
      () => {
        this.resettingLoader = false;
      }
    );
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }

  get password() {
    return this.afterResetForm.get('password');
  }
}
