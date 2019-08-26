import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { BeforeResetComponent } from './reset-password/before-reset/before-reset.component';
import { RegisterComponent } from './register/register.component';
import { AfterResetComponent } from './reset-password/after-reset/after-reset.component';

const routes: Routes = [
    {
        path: '',

        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'login'
            },
            {
                path: 'login',
                component: LoginComponent
            },
            {
                path: 'reset',
                component: BeforeResetComponent
            },
            {
                path: 'onreset',
                component: AfterResetComponent
            },
            {
                path: 'register',
                component: RegisterComponent
            }
        ]
    }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule { }
