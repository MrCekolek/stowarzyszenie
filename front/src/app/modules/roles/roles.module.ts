import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RolesRoutingModule } from './roles-routing.module';
import { FormsModule } from '@angular/forms';
import { RolesListComponent } from './roles-list/roles-list.component';
import { PermissionGroupComponent } from './permission-group/permission-group.component';
import { SharedModule } from '../../shared/shared.module';
import { NewRoleModalComponent } from './new-role-modal/new-role-modal.component';
import { MatFormFieldModule, MatInputModule, MatDialogModule } from '@angular/material';
import { DeleteAlertComponent } from 'src/app/shared/components/delete-alert/delete-alert.component';

@NgModule({
  declarations: [RolesListComponent, PermissionGroupComponent, NewRoleModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    RolesRoutingModule,
    FormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule
  ],
  entryComponents: [NewRoleModalComponent, DeleteAlertComponent],
  providers: []
})
export class RolesModule { }
