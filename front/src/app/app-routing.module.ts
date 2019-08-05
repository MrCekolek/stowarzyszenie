import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from "./components/auth/login/login.component";
import { SignupComponent } from "./components/auth/signup/signup.component";
import { RequestResetComponent } from "./components/auth/password/request-reset/request-reset.component";
import { ResponseResetComponent } from "./components/auth/password/response-reset/response-reset.component";
import { ProfileComponent } from "./components/app/profile/profile.component";
import { BeforeLoginService } from "./services/can-activate/login/before-login.service";
import { AfterLoginService } from "./services/can-activate/login/after-login.service";

const routes: Routes = [
  {
    path: 'login',
    component: LoginComponent,
    canActivate: [
      BeforeLoginService
    ]
  },
  {
    path: 'signup',
    component: SignupComponent,
    canActivate: [
      BeforeLoginService
    ],
  },
  {
    path: 'profile',
    component: ProfileComponent,
    canActivate: [
      AfterLoginService
    ],
  },
  {
    path: 'request-password-reset',
    component: RequestResetComponent,
    canActivate: [
      BeforeLoginService
    ],
  },
  {
    path: 'response-password-reset',
    component: ResponseResetComponent,
    canActivate: [
      BeforeLoginService
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
