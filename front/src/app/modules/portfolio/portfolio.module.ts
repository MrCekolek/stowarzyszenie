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
import { InputComponent } from './contents/input/input.component';
import { TextareaComponent } from './contents/textarea/textarea.component';
import { CheckboxComponent } from './contents/checkbox/checkbox.component';
import { RadioComponent } from './contents/radio/radio.component';
import { SelectComponent } from './contents/select/select.component';

@NgModule({
  declarations: [WholePortfolioComponent, PortfolioTabsComponent, OneTabComponent, UserPortfolioComponent, AddTabModalComponent, CardContentModalComponent, PortfolioCardComponent, EditCardModalComponent, ContentOptionsComponent, InputComponent, TextareaComponent, CheckboxComponent, RadioComponent, SelectComponent],
  imports: [
    CommonModule,
    SharedModule,
    MatTabsModule,
    DragDropModule,
    MatTooltipModule,
    FormsModule
  ],
  entryComponents: [AddTabModalComponent, CardContentModalComponent, EditCardModalComponent]
})
export class PortfolioModule { }
