import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { PermissionRoleApiService } from 'src/app/core/http/permission-role-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-conference-role-modal',
  templateUrl: './conference-role-modal.component.html',
  styleUrls: ['./conference-role-modal.component.scss']
})
export class ConferenceRoleModalComponent implements OnInit {

  private allRoles = [];
  private selectedRoles = [];

  private lang;
  private user;
  private saving;
  private isLoading;

  constructor(
    private dialog: MatDialogRef<ConferenceRoleModalComponent>,
    private rolesApi: PermissionRoleApiService,
    private languageService: LanguageService,
    @Inject(MAT_DIALOG_DATA) data
  ) {
    if (data.user) {
      this.user = data.user;
    }
   }

  ngOnInit() {
    this.isLoading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.rolesApi.getRoles().subscribe(
        (res) => {
          this.allRoles = res.roles;
        },
        () => {},
        () => {
          this.isLoading = false;
        }
      );
  }

  saveRoles() {
    this.saving = true;

    this.rolesApi.assignRoles(this.user, this.user.roles).subscribe(
      (res) => {
        this.dialog.close(res);
      },
      () => {},
      () => {
        this.saving = false;
      }
    );
  }

  roleAssigned(role) {
    return this.user.roles.findIndex(item => item.id === role.id) === -1;
  }

  dismiss() {
    this.dialog.close();
  }

  assignRole(role) {
    this.user.roles.push(role);
  }

  deassignRole(role) {
    const index = this.user.roles.findIndex(item => item.id === role.id);

    this.user.roles.splice(index, 1);
  }
}
