import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { UsersListComponent } from "./users-list/users-list.component";

const routes: Routes = [{
    path: '',

    children: [
        {
            path: '',
            pathMatch: 'full',
            redirectTo: 'role/1/users',
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: ':roleId/users',
            component: UsersListComponent,
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
export class RoleUserRoutingModule { }
