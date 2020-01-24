import {Component, OnInit} from '@angular/core';
import {PermissionRoleApiService} from "../../../core/http/permission-role-api.service";
import {NewRoleModalComponent} from '../new-role-modal/new-role-modal.component';
import {MatDialog, MatDialogConfig} from "@angular/material";
import { DeleteAlertComponent } from 'src/app/shared/components/delete-alert/delete-alert.component';
import { AlertModel } from 'src/app/shared/models/alert.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { Role } from 'src/app/shared/models/role.model';

@Component({
  selector: 'app-roles-list',
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent implements OnInit {

  private selectedChooseRoles: boolean;
  private rolesNames: any = [];
  private roles: any = [];
  private selectedRole: any = {};
  private rolesAreLoading;
  private isSaving: boolean = false;

  private alert: AlertModel;
  lang;

  constructor(
    private permissionRoleApiService: PermissionRoleApiService,
    private dialog: MatDialog,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.selectedChooseRoles = true;
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });
    this.getRoles();
  }

  getRoles() {
    this.rolesAreLoading = true;
    this.permissionRoleApiService.getRoles().subscribe(
      roles => {
        this.roles = roles.roles;
        this.rolesAreLoading = false;
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
    if (id != 0) {
      this.selectedChooseRoles = false;

      this.permissionRoleApiService.getRoleWithPermissions(id).subscribe(role => {
        console.log(role);
        this.selectedRole = role;
        this.selectedRole.isSelected = false;
        this.selectedRole.isClosed = false;
        this.roles.parentChildChecklist = this.selectedRole.permissions;
        this.roles.isAllSelected = false;
        this.roles.isAllCollapsed = false;
      });
    } else {
      this.selectedChooseRoles = true;
    }
  }

  openNewRoleModal() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new'
    };

    const dialogRef = this.dialog.open(NewRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      data => {
        if (data) {
          if (data.success) {
            this.roles.push(data.role);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  openEditRoleModal(role) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit',
      role: role
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
    this.permissionRoleApiService.updateRoleName(roleId).subscribe(data => {
      if (data.success) {
        this.isSaving = false;
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
            this.isSaving = false;
            this.selectedRole = {};
          });
        }
      }
    );
  }
}
