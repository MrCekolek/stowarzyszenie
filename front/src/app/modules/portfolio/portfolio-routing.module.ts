import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WholePortfolioComponent } from './whole-portfolio/whole-portfolio.component';

const routes: Routes = [
    {
        path: '',
    
        children: [
            {
                path: '',
                pathMatch: 'full',
                redirectTo: 'portfolio/:id'
            },
            {
                path: 'portfolio/:id',
                component: WholePortfolioComponent
            },
            {
                path: 'portfolio/:id/profile',
                component: WholePortfolioComponent
            }
        ]
    }
];
@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
  })
  export class PortfolioRoutingModule { }
  