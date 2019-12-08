import {Component, OnInit} from '@angular/core';
import {PermissionRoleApiService} from "../../../core/http/permission-role-api.service";
import {NewRoleModalComponent} from '../new-role-modal/new-role-modal.component';
import {MatDialog, MatDialogConfig} from "@angular/material";
import { DeleteAlertComponent } from 'src/app/shared/components/delete-alert/delete-alert.component';

@Component({
  selector: 'app-roles-list',
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent implements OnInit {

  private rolesNames: any = [];
  private roles: any = {};
  private selectedRole: any = {};
  private rolesAreLoading;
  private alertMessage: string = '';
  private alertClass: string = '';
  private isSaving: boolean = false;

  private newRoleSuccessMess = 'STOWARZYSZENIE.MODALS.NEW_ROLE.DIALOG_MESSAGE_SUCCESS';

  constructor(
    private permissionRoleApiService: PermissionRoleApiService,
    private dialog: MatDialog
  ) {
  }

  ngOnInit() {
    this.getRoles();
  }

  getRoles() {
    this.rolesAreLoading = true;
    this.permissionRoleApiService.getRoles().subscribe(
      roles => {
        this.rolesNames = roles.roles;
        
        if (this.rolesNames.length > 0) {
          this.rolesAreLoading = false;
        }
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
  expandCollapseAll(obj) {
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
      data => {
        this.permissionRoleApiService.addNewRole(data);
        this.alertClass = 'success';
        this.alertMessage = 'STOWARZYSZENIE.MODALS.NEW_ROLE.ALERTS.NEW_ROLE_SUCCESS';
        this.getRoles();
      }
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
      data => { 
        this.selectedRole.role = data.name;
        this.getRoles();
      }
    );
  }

  saveRole(roleId) {
    this.isSaving = true;
    this.permissionRoleApiService.updateRole(roleId, this.selectedRole).subscribe(data => {
      if (data.success) {
        this.isSaving = false;
        this.getRoles();
        this.alertMessage= 'STOWARZYSZENIE.MODULES.ROLES.UPDATED_MESSAGE';
        this.alertClass = 'success';
      }
    });
  }

  deleteRole(RoleId) {
    const dialogConfig = new MatDialogConfig();

    const dialogRef = this.dialog.open(DeleteAlertComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      data => { 
        if (data) {
          this.isSaving = true;
          this.permissionRoleApiService.deleteRole(RoleId).subscribe(message => {
            console.log(message);
            this.getRoles();
            this.alertMessage= 'STOWARZYSZENIE.MODALS.DELETE_ALERT.DELETED_MESSAGE';
            this.alertClass = 'success';
            this.isSaving = false;
            this.selectedRole = {};
          });
        }
      }
    );
  }
}
