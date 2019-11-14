import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { RolesListComponent } from './roles-list/roles-list.component';

const routes: Routes = [
  {
      path: '',
      children: [
          {
              path: '',
              pathMatch: 'full',
              redirectTo: 'roles-list'
          },
          {
              path: 'roles-list',
              component: RolesListComponent,
              data: {
                breadcrumb: 'STOWARZYSZENIE.MODULES.NAVIGATION.SIDENAV.USERS.ROLES_PREFERENCES'
              }
          },
      ],
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class RolesRoutingModule { }
