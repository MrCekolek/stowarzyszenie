import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeNavManageComponent } from './home-nav-manage/home-nav-manage.component';
import { ConferencePagesComponent } from './conference-pages/conference-pages.component';

const routes: Routes = [
    {
        path: '',
    
        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'homepages'
            },
            {
                path: 'conference',
                component: ConferencePagesComponent
            },
            {
                path: 'homepages',
                component: HomeNavManageComponent
            },
            {
                path: 'page-edit/:id',
                component: HomeNavManageComponent
            }
        ]
    }
];
@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
  })
  export class NavAdminRouting { }
  