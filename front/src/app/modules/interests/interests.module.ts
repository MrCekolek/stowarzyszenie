import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { InterestsRoutingModule } from './interests-routing.module';
import { InterestsListComponent } from './interests-list/interests-list.component';
import { InterestTileComponent } from './interest-tile/interest-tile.component';


@NgModule({
  declarations: [InterestsListComponent, InterestTileComponent],
  imports: [
    CommonModule,
    InterestsRoutingModule
  ]
})
export class InterestsModule { }
