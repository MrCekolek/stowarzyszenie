import { Component, OnInit, ChangeDetectorRef, Input } from '@angular/core';
import { CdkStepper } from '@angular/cdk/stepper';
import { Directionality } from '@angular/cdk/bidi';
import { RegisterComponent } from "../register.component";

@Component({
  selector: 'auth-stepper',
  templateUrl: './stepper.component.html',
  styleUrls: ['./stepper.component.scss'],
  providers: [{ provide: CdkStepper, useExisting: StepperComponent }],
})
export class StepperComponent extends CdkStepper implements OnInit {

  @Input() registerCompleted;
  private registeredEmail;

  private icons = {
    0: 'fas fa-lock',
    1: 'fas fa-user',
    2: 'fas fa-university',
    3: 'fas fa-phone'
  };

  private stepTitles = {
    0: 'STOWARZYSZENIE.MODULES.AUTH.REGISTER.STEP1_TITLE',
    1: 'STOWARZYSZENIE.MODULES.AUTH.REGISTER.STEP2_TITLE',
    2: 'STOWARZYSZENIE.MODULES.AUTH.REGISTER.STEP3_TITLE',
    3: 'STOWARZYSZENIE.MODULES.AUTH.REGISTER.STEP4_TITLE'
  };

  constructor(
    private dir: Directionality,
    private changeDetectorRef: ChangeDetectorRef,
    private registerComponent: RegisterComponent
  ) {
      super(dir, changeDetectorRef);
      this.registerCompleted = false;
    }

  ngOnInit() {
  }

  onClick(index: number): void {
    if (!this.registerComponent.isLoading) {
      this.selectedIndex = index;
    }
  }

  completeRegistration() {
    this.registerCompleted = true;
    this.registerComponent.registerAccount(this.getRegisterModel());
  }

  isLoading() {
    return this.registerComponent.isLoading;
  }

  resendEmailActivation() {
    this.registerComponent.resendEmailActivation(this.getRegisterModel());
  }

  getRegisterModel() {
    return {
      'login_email': this.registerComponent.login_email.value,
      'password': this.registerComponent.password.value,
      'first_name': this.registerComponent.first_name.value,
      'last_name': this.registerComponent.last_name.value,
      'birthdate': this.registerComponent.birthdate.value,
      'gender': this.registerComponent.gender.value,
      'title': this.registerComponent.title.value,
      'institution': this.registerComponent.institution.value,
      'department': this.registerComponent.department.value,
      'street': this.registerComponent.street.value,
      'city': this.registerComponent.city.value,
      'country': this.registerComponent.country.value,
      'contact_email': this.registerComponent.contact_email.value,
      'phone_number': this.registerComponent.phone_number.value,
    };
  }
}
