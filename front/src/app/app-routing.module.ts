import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from "./shared/guards/logged.guard.guard";
import { NotLoggedGuard } from "./shared/guards/not-logged.guard.guard";
import { HomePageComponent } from './modules/navigation/home-page/home-page.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'auth',
    pathMatch: 'full'
  },
  {
    path: 'homepage/:id',
    component: HomePageComponent
  },
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
    path: 'portfolio',
    loadChildren: './modules/portfolio/portfolio.module#PortfolioModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'pages',
    loadChildren: './modules/nav-admin/nav-admin.module#NavAdminModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'managements',
    loadChildren: './modules/managements/managements.module#ManagementsModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'role',
    loadChildren: './modules/role-user/role-user.module#RoleUserModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'manage-conference',
    loadChildren: './modules/manage-conference/manage-conference.module#ManageConferenceModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'conference-articles',
    loadChildren: './modules/conference-articles/conference-articles.module#ConferenceArticlesModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: 'conference-reviews',
    loadChildren: './modules/conference-reviews/conference-reviews.module#ConferenceReviewsModule',
    canActivateChild: [
      LoggedGuard
    ]
  },
  {
    path: '**',
    redirectTo: ''
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
