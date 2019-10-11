import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';


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
                component: LoginComponent
            },
        ]
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule { }
