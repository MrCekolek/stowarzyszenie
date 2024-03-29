import { Component, OnInit } from '@angular/core';
import { PermissionRoleApiService } from "../../../core/http/permission-role-api.service";
import { NewRoleModalComponent } from '../new-role-modal/new-role-modal.component';
import { MatDialog, MatDialogConfig } from "@angular/material";
import { AlertModel } from 'src/app/shared/models/alert.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-roles-list',
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent implements OnInit {

  private selectedChooseRoles: boolean;
  private rolesNames: any = [];
  private roles: any = [];
  private selectedRole: any;
  private selectRoleOption: any;
  private rolesAreLoading;
  private isSaving: boolean = false;
  private isLoading: boolean = false;

  private alert: AlertModel;
  lang;
  permissionsLoading = false;

  constructor(
    private permissionRoleApiService: PermissionRoleApiService,
    private dialog: MatDialog,
    private languageService: LanguageService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.selectRoleOption = 0;
    this.selectedChooseRoles = true;
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });
    this.getRoles();
    this.permissionsLoading = false;
  }

  getRoles() {
    this.isLoading = true;

    this.rolesAreLoading = true;
    this.permissionRoleApiService.getRoles().subscribe(
        (roles) => {
          this.roles = roles.roles;
          this.rolesAreLoading = false;
        },
        () => {},
        () => {
          this.isLoading = false;
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
    this.permissionsLoading = true;
    this.selectedChooseRoles = false;

    this.permissionRoleApiService.getRoleWithPermissions(id).subscribe(role => {
      this.selectedRole = role;
      this.selectedRole.isSelected = false;
      this.selectedRole.isClosed = false;
      this.roles.parentChildChecklist = role.permissions;
      this.selectedRole.permissions = role.permissions;
      this.roles.isAllSelected = false;
      this.roles.isAllCollapsed = false;
      this.permissionsLoading = false;
    });
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
    var roleNamePl = role.name_pl;
    var roleNameEn = role.name_en;
    var roleNameRu = role.name_ru;

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit',
      role: role
    };

    const dialogRef = this.dialog.open(NewRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      data => { 
        if (data) {
          if (data.success) {
            this.selectedRole = data;
            this.selectRole(data.role.id);
            this.selectRoleOption = data.role.id;
            this.getRoles();
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        } else {
          role.name_pl = roleNamePl;
          role.name_en = roleNameEn;
          role.name_ru = roleNameRu;
        }
      }
    );
  }

  saveRole(roleId) {
    this.isLoading = true;
    this.isSaving = true;
    this.permissionRoleApiService.updateRolePermissions(roleId, this.selectedRole.permissions).subscribe(
        (data) => {
          if (data.success) {
            this.isSaving = false;
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        },
        () => {},
        () => {
          this.isLoading = false;
        }
      );
  }

  deleteRole() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.ROLE.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.ROLE.TEXT',
      element: this.selectedRole.role,
      apiToDelete: `role/delete`
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.selectRoleOption = 0;

            const index = this.roles.findIndex(item => item.id === data.elToDelete.id);
            this.roles.splice(index, 1);

            this.alert = new AlertModel('success', data.message);
            this.selectedRole = null;
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
