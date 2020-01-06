import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { InterestsRoutingModule } from './interests-routing.module';
import { InterestsListComponent } from './interests-list/interests-list.component';
import { InterestTileComponent } from './interest-tile/interest-tile.component';
import { SharedModule } from '../../shared/shared.module';
import { InterestModalComponent } from './interest-modal/interest-modal.component';
import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [InterestsListComponent, InterestTileComponent, InterestModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    InterestsRoutingModule,
    FormsModule
  ],
  entryComponents: [InterestModalComponent],
  providers: []
})
export class InterestsModule { }
