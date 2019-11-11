import { Component, OnInit } from '@angular/core';
import { PermissionRoleApiService } from "../../../core/http/permission-role-api.service";
import { NewRoleModalComponent } from '../new-role-modal/new-role-modal.component';
import { MatDialog, MatDialogConfig } from "@angular/material";

@Component({
  selector: 'app-roles-list',
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent implements OnInit {

  private rolesNames: any = [];
  private roles: any = {};
  private selectedRole: any = {};

  constructor(
    private permissionRoleApiService: PermissionRoleApiService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.permissionRoleApiService.getRoleWithPermissions(1).subscribe(item => console.log(item));
    this.permissionRoleApiService.getRoles().subscribe(
      roles => {
        this.rolesNames = roles.roles;
        console.log(this.rolesNames);
      }
    );
  }

  // click event on check/uncheck all
  selectUnselectAll(obj) {
    obj.isAllSelected = !obj.isAllSelected;
    for (let i = 0; i < obj.parentChildChecklist.length; i++) {
      obj.parentChildChecklist[i].isSelected = obj.isAllSelected;
      for (let j = 0; j < obj.parentChildChecklist[i].permissions.length; j++) {
        obj.parentChildChecklist[i].permissions[j].selected = obj.isAllSelected;
      }
    }
  }

  // collapse all event
  expandCollapseAll(obj){
    for (let i = 0; i < obj.parentChildChecklist.length; i++) {
      obj.parentChildChecklist[i].isClosed = !obj.isAllCollapsed;
    }
    obj.isAllCollapsed = !obj.isAllCollapsed;
  }

  // show updated JSON
  stringify(obj) {
    return JSON.stringify(obj);
  }

  selectRole(id) {
    this.permissionRoleApiService.getRoleWithPermissions(id).subscribe(role => {
      console.log(role);
      this.selectedRole = role;
      this.selectedRole.isSelected = false;
      this.selectedRole.isClosed = false;
      this.roles.parentChildChecklist = this.selectedRole.permissions;
      this.roles.isAllSelected = false;
      this.roles.isAllCollapsed = false;
    });
  }

  openNewRoleModal() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new_role'
    };

    const dialogRef = this.dialog.open(NewRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => console.log("Dialog output:", data)
    ); 
  }

  openEditRoleModal(roleName) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit_role',
      role_name: roleName
    };

    const dialogRef = this.dialog.open(NewRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => console.log("Dialog output:", data)
    ); 
  }
}
