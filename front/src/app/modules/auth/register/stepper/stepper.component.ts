import { Component, OnInit, ChangeDetectorRef, Input } from '@angular/core';
import { CdkStepper } from '@angular/cdk/stepper';
import { Directionality } from '@angular/cdk/bidi';

@Component({
  selector: 'auth-stepper',
  templateUrl: './stepper.component.html',
  styleUrls: ['./stepper.component.scss'],
  providers: [{ provide: CdkStepper, useExisting: StepperComponent }],
})
export class StepperComponent extends CdkStepper implements OnInit {

  @Input() registrationCompleted;
  private registeredEmail;

  private icons = {
    0: 'fas fa-lock',
    1: 'fas fa-user',
    2: 'fas fa-university',
    3: 'fas fa-phone'
  };

  constructor(dir: Directionality, changeDetectorRef: ChangeDetectorRef) {
    super(dir, changeDetectorRef);
    this.registrationCompleted = false;
  }

  ngOnInit() {
  }

  onClick(index: number): void {
    this.selectedIndex = index;
  }

  completeRegistration() {
    this.registrationCompleted = true;
  }
}
