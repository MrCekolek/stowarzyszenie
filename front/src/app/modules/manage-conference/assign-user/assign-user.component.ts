import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ApiService } from 'src/app/core/http/api.service';
import { PermissionRoleApiService } from 'src/app/core/http/permission-role-api.service';

@Component({
  selector: 'app-assign-user',
  templateUrl: './assign-user.component.html',
  styleUrls: ['./assign-user.component.scss']
})
export class AssignUserComponent implements OnInit {

  private role;
  private trackID;
  private lang;

  private users = [];
  private selectedusers = [];

  private isSaving;

  constructor(
    private dialogRef: MatDialogRef<AssignUserComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private manageConferenceApi: ManageConferenceApiService,
    private apiService: ApiService,
    private permissionRoleApi: PermissionRoleApiService
  ) {
    if (data.role) {
      this.role = data.role;
    }

    if (data.track) {
      this.trackID = data.track;
    }

    if (data.users) {
      this.selectedusers = data.users;
    }
   }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    const obj = {
      role_id: this.role
    };

    this.permissionRoleApi.getUsersWithRole(obj).subscribe(res => {
      this.users = res.users;
    });
  }

  // TODO: zrobic zeby dalo sie zapisywac kilka na raz osob po checkboxach
  save() {
    this.isSaving = true;
    if (this.role == 6) {
      // TODO: zrobic zeby mozna bylo dodawac po kilka
      // const obj = 
      // this.manageConferenceApi.addChairToTrack();
      this.dialogRef.close(this.selectedusers);
    } else if (this.role === 8) {
      // this.manageConferenceApi.addReviewerToTrack();
    }

    this.isSaving = false;
  }

  dismiss() {
    this.dialogRef.close();
  }

  addToList(user) {
    this.selectedusers.push(user);
  }
}
