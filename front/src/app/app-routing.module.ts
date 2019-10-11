import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from "./shared/guards/logged.guard.guard";
import { NotLoggedGuard } from "./shared/guards/not-logged.guard.guard";

const routes: Routes = [
  {
    path: 'auth',
    loadChildren: './modules/auth/auth.module#AuthModule',
    canActivateChild: [
      NotLoggedGuard
    ]
  },
  {
    path: 'dashboard',
    loadChildren: './modules/dashboard/dashboard.module#DashboardModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'users',
    loadChildren: './modules/users/users.module#UsersModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: '',
    redirectTo: 'auth',
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
