import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UsersListComponent } from "./users-list/users-list.component";
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';

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
              ]            }
        ]
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule { }
