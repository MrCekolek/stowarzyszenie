import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { InterestsRoutingModule } from './interests-routing.module';
import { InterestsListComponent } from './interests-list/interests-list.component';
import { InterestTileComponent } from './interest-tile/interest-tile.component';
import { SharedModule } from '../../shared/shared.module';
import { InterestModalComponent } from './interest-modal/interest-modal.component';
import { FormsModule } from '@angular/forms';
import { ConfirmationDialogComponent } from '../../shared/components/confirmation-dialog/confirmation-dialog.component';

@NgModule({
  declarations: [InterestsListComponent, InterestTileComponent, InterestModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    InterestsRoutingModule,
    FormsModule
  ],
  entryComponents: [InterestModalComponent, ConfirmationDialogComponent],
  providers: []
})
export class InterestsModule { }
