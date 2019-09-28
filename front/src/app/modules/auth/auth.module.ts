import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthRoutingModule } from './auth-routing.module';
import { LoginComponent } from './login/login.component';
import { SharedModule } from '../../shared/shared.module';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatIconModule } from '@angular/material/icon';
import { BeforeResetComponent } from './reset-password/before-reset/before-reset.component';
import { AfterResetComponent } from './reset-password/after-reset/after-reset.component';
import { RegisterComponent } from './register/register.component';
import { CdkStepperModule } from '@angular/cdk/stepper';
import { StepperComponent } from './register/stepper/stepper.component';
import { MatRadioModule } from '@angular/material/radio';
import { MatSelectModule } from '@angular/material/select';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    LoginComponent,
    BeforeResetComponent,
    AfterResetComponent,
    RegisterComponent,
    StepperComponent
  ],
  imports: [
    CommonModule,
    AuthRoutingModule,
    SharedModule,
    MatFormFieldModule,
    MatInputModule,
    MatCheckboxModule,
    MatIconModule,
    CdkStepperModule,
    MatRadioModule,
    MatSelectModule,
    FormsModule,
    ReactiveFormsModule
  ]
})
export class AuthModule { }
