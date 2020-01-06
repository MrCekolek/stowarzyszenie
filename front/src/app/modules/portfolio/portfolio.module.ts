import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WholePortfolioComponent } from './whole-portfolio/whole-portfolio.component';
import { PortfolioTabsComponent } from './portfolio-tabs/portfolio-tabs.component';
import { OneTabComponent } from './one-tab/one-tab.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { MatTabsModule } from '@angular/material/tabs';
import { UserPortfolioComponent } from './user-portfolio/user-portfolio.component';
import { AddTabTemplateComponent } from './add-tab-template/add-tab-template.component';
import { AddCardTemplateComponent } from './add-card-template/add-card-template.component';
import { DragDropModule } from '@angular/cdk/drag-drop';

@NgModule({
  declarations: [WholePortfolioComponent, PortfolioTabsComponent, OneTabComponent, UserPortfolioComponent, AddTabTemplateComponent, AddCardTemplateComponent],
  imports: [
    CommonModule,
    SharedModule,
    MatTabsModule,
    DragDropModule
  ]
})
export class PortfolioModule { }
