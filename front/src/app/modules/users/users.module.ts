import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '../../shared/shared.module';
import { UsersRoutingModule } from './users-routing.module';
import { UserTileComponent } from './user-tile/user-tile.component';
import { UsersListComponent } from './users-list/users-list.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatInputModule } from "@angular/material";
import { PortfolioModule } from '../portfolio/portfolio.module';
import { InterestsModule } from '../interests/interests.module';

@NgModule({
  declarations: [UserTileComponent, UsersListComponent],
  imports: [
    CommonModule,
    SharedModule,
    UsersRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule,
    PortfolioModule,
    InterestsModule
  ],
  providers: []
})
export class UsersModule { }
