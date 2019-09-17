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

  constructor(
    private dir: Directionality,
    private changeDetectorRef: ChangeDetectorRef,
    private registerComponent: RegisterComponent) {
      super(dir, changeDetectorRef);
      this.registerCompleted = false;
    }

  ngOnInit() {
  }

  onClick(index: number): void {
    this.selectedIndex = index;
  }

  completeRegistration() {
    this.registerCompleted = true;
    this.registerComponent.createNewUser(this.registerComponent.registerForm.getRawValue());
  }

  resendEmailActivation() {
    this.registerComponent.resendEmailActivation(this.registerComponent.registerForm.getRawValue());
  }
}
