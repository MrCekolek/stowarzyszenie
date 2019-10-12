import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UsersListComponent } from "./users-list/users-list.component";


const routes: Routes = [{
  path: '',

        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'users-list'
            },
            {
                path: 'users-list',
                component: UsersListComponent
            },
        ]
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule { }
