import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { InterestsRoutingModule } from './interests-routing.module';
import { InterestsListComponent } from './interests-list/interests-list.component';
import { InterestTileComponent } from './interest-tile/interest-tile.component';
import { SharedModule } from 'src/app/shared/shared.module';


@NgModule({
  declarations: [InterestsListComponent, InterestTileComponent],
  imports: [
    CommonModule,
    SharedModule,
    InterestsRoutingModule
  ]
})
export class InterestsModule { }
