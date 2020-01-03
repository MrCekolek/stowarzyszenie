import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UsersListComponent } from "./users-list/users-list.component";
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { WholePortfolioComponent } from '../portfolio/whole-portfolio/whole-portfolio.component';
import { InterestsListComponent } from '../interests/interests-list/interests-list.component';
import { UserPortfolioComponent } from '../portfolio/user-portfolio/user-portfolio.component';

const routes: Routes = [{
  path: '',

        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'users-list',
                canActivateChild: [
                  LoggedGuard
                ]
            },
            {
                path: 'users-list',
                component: UsersListComponent,
                canActivateChild: [
                  LoggedGuard
                ],
                data: {
                  breadcrumb: 'STOWARZYSZENIE.MODULES.NAVIGATION.SIDENAV.USERS.USERS_LIST'
                }
            },
            {
              path: 'roles',
              loadChildren: '../roles/roles.module#RolesModule',
              canActivateChild: [
                LoggedGuard
              ]            
            },
            {
              path: 'portfolio-settings',
              component: WholePortfolioComponent,
              canActivateChild: [
                LoggedGuard
              ]   
            },
            {
              path: 'interests',
              component: InterestsListComponent,
              canActivateChild: [
                LoggedGuard
              ]  
            },
            {
              path: 'profile/:id',
              component: UserPortfolioComponent,
              canActivateChild: [
                LoggedGuard
              ]  
            }
        ]
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule { }
