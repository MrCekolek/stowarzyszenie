import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute } from "@angular/router";
import { AfterResetService } from "../../../../core/http/after-reset.service";

@Component({
  selector: 'app-after-reset',
  templateUrl: './after-reset.component.html',
  styleUrls: ['./after-reset.component.scss']
})
export class AfterResetComponent implements OnInit {
  afterResetForm: FormGroup;
  passwordIsHidden: boolean;
  private reseted: boolean;
  private routeParams = {
    login_email: null,
    token: null
  }

  constructor(
    private formBuilder: FormBuilder,
    private activatedRoute: ActivatedRoute,
    private afterResetService: AfterResetService
  ) {
    this.reseted = false;
    this.passwordIsHidden = true;
    this.activatedRoute.queryParams.subscribe(
      params => {
        this.routeParams.login_email = params['login_email'],
        this.routeParams.token = params['token']
      })
   }

  ngOnInit() {
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
    this.reseted = true;

    this.afterResetService.changePassword(afterResetForm).subscribe()
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }

  get password() {
    return this.afterResetForm.get('password');
  }
}
