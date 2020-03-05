import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UsersListComponent } from './users-list/users-list.component';
import { SharedModule } from "../../shared/shared.module";
import { RoleUserRoutingModule } from "./role-user-routing.module";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { MatInputModule } from "@angular/material";
import { NewRoleUserModalComponent } from './new-role-user-modal/new-role-user-modal.component';

@NgModule({
  declarations: [UsersListComponent, NewRoleUserModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    RoleUserRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule
  ],
  entryComponents: [NewRoleUserModalComponent]
})
export class RoleUserModule { }
