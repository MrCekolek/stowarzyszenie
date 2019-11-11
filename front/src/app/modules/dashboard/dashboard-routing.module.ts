import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MainDashboardComponent } from './main-dashboard/main-dashboard.component';
import { FullscreenOverlayContainer } from '@angular/cdk/overlay';

const routes: Routes = [
    {
        path: '',
        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'main'
            },
            {
                path: 'main',
                component: MainDashboardComponent,
                data: {
                    breadcrumb: 'STOWARZYSZENIE.MODULES.NAVIGATION.SIDENAV.DASHBOARD'
                }
            }
        ]
    }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardRoutingModule { }
