import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WholePortfolioComponent } from './whole-portfolio/whole-portfolio.component';
import { PortfolioTabsComponent } from './portfolio-tabs/portfolio-tabs.component';
import { OneTabComponent } from './one-tab/one-tab.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { MatTabsModule } from '@angular/material/tabs';

@NgModule({
  declarations: [WholePortfolioComponent, PortfolioTabsComponent, OneTabComponent],
  imports: [
    CommonModule,
    SharedModule,
    MatTabsModule
  ]
})
export class PortfolioModule { }
