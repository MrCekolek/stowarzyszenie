import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { InterestsListComponent } from './interests-list/interests-list.component';
import { SharedModule } from '../../shared/shared.module';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        redirectTo: 'interests'
      },
      {
        path: 'interests',
        component: InterestsListComponent
      }
    ]
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
    SharedModule
  ],
  exports: [RouterModule]
})
export class InterestsRoutingModule { }
