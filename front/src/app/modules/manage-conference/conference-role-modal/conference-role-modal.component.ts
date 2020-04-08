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
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
    this.rolesApi.getRoles().subscribe(res => {
      console.log(res);
      this.allRoles = res.roles;
    });
  }

  saveRoles() {
    this.saving = true;
    // TODO: przypisz userowi wszystkie role
    // this.rolesApi.
    this.dialog.close(this.selectedRoles);
  }

  dismiss() {
    this.dialog.close();
  }

  assignRole(role) {
    this.selectedRoles.push(role);
  }
}
