import { Component, OnInit, Output, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from "@angular/material";
import { ApiService } from 'src/app/core/http/api.service';
import { Role } from 'src/app/shared/models/role.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { PermissionRoleApiService } from 'src/app/core/http/permission-role-api.service';

@Component({
  selector: 'app-new-role-modal',
  templateUrl: './new-role-modal.component.html',
  styleUrls: ['./new-role-modal.component.scss']
})
export class NewRoleModalComponent implements OnInit {

  modal_type: string;
  roleName: string;

  addLoading = false;
  translations = [];

  role: Role = {
    id: 0,
    name_pl: '',
    name_en: '',
    name_ru: '',
    permissions: [],
    isSelected: false,
    isClosed: false
  };

  lang;
  saving = false;

  constructor(
    private dialogRef: MatDialogRef<NewRoleModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private apService: ApiService,
    private languageService: LanguageService,
    private roleApiService: PermissionRoleApiService
    ) {
    this.modal_type = data.modal_type;

    if (data.role) {
      console.log(data.role);
      this.role = data.role;

      this.translations[0] = data.role.name_pl;
      this.translations[1] = data.role.name_en;
      this.translations[2] = data.role.name_ru;
    }
    
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });
  }

  addRole() {
    this.saving = true;
    this.roleApiService.addNewRole(this.role).subscribe(response => {
      this.dialogRef.close(response);
      this.saving = false;
    });
  }

  updateRole() {
    this.role.name_pl = this.translations[0];
    this.role.name_en = this.translations[1];
    this.role.name_ru = this.translations[2];
    this.saving = true;
    console.log(this.role);
    this.roleApiService.updateRoleName(this.role).subscribe(response => {
      console.log(response);
      this.dialogRef.close(response);
      this.saving = false;
    });
  }

  dismiss() {
    this.dialogRef.close();
  }

  getRoleTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.role.name_pl = response.translation.name_pl;
      this.role.name_en = response.translation.name_en;
      this.role.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }
}
