import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WholePortfolioComponent } from './whole-portfolio/whole-portfolio.component';
import { PortfolioTabsComponent } from './portfolio-tabs/portfolio-tabs.component';
import { OneTabComponent } from './one-tab/one-tab.component';
import { SharedModule } from '../../shared/shared.module';
import { MatTabsModule } from '@angular/material/tabs';
import { UserPortfolioComponent } from './user-portfolio/user-portfolio.component';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { AddTabModalComponent } from './add-tab-modal/add-tab-modal.component';

import { MatTooltipModule } from '@angular/material/tooltip';
import { CardContentModalComponent } from './card-content-modal/card-content-modal.component';
import { PortfolioCardComponent } from './portfolio-card/portfolio-card.component';
import { FormsModule } from '@angular/forms';
import { EditCardModalComponent } from './edit-card-modal/edit-card-modal.component';
import { ContentOptionsComponent } from './content-options/content-options.component';
import { OptionsListComponent } from './options-list/options-list.component';
import { InterestsComponent } from './interests/interests.component';
import { ContentFillComponent } from './content-fill/content-fill.component';
import { MatSnackBarModule } from '@angular/material/snack-bar';

@NgModule({
  declarations: [WholePortfolioComponent, PortfolioTabsComponent, OneTabComponent, UserPortfolioComponent, AddTabModalComponent, CardContentModalComponent, PortfolioCardComponent, EditCardModalComponent, ContentOptionsComponent, OptionsListComponent, InterestsComponent, ContentFillComponent],
  imports: [
    CommonModule,
    SharedModule,
    MatTabsModule,
    DragDropModule,
    MatTooltipModule,
    FormsModule,
    MatSnackBarModule
  ],
  entryComponents: [AddTabModalComponent, CardContentModalComponent, EditCardModalComponent, ContentFillComponent]
})
export class PortfolioModule { }
