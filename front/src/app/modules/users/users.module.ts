import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '../../shared/shared.module';
import { UsersRoutingModule } from './users-routing.module';
import { UserTileComponent } from './user-tile/user-tile.component';
import { UsersListComponent } from './users-list/users-list.component';


@NgModule({
  declarations: [UserTileComponent, UsersListComponent],
  imports: [
    CommonModule,
    SharedModule,
    UsersRoutingModule
  ]
})
export class UsersModule { }
