import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RolesRoutingModule } from './roles-routing.module';
import { FormsModule } from '@angular/forms';
import { RolesListComponent } from './roles-list/roles-list.component';
import { PermissionGroupComponent } from './permission-group/permission-group.component';
import { SharedModule } from '../../shared/shared.module';

@NgModule({
  declarations: [RolesListComponent, PermissionGroupComponent],
  imports: [
    CommonModule,
    SharedModule,
    RolesRoutingModule,
    FormsModule
  ]
})
export class RolesModule { }
