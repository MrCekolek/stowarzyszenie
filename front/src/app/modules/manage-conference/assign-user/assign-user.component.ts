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
  private loading;

  private users;
  private selectedusers = [];

  private isSaving = false;

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
   }

  ngOnInit() {
    this.loading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    const obj = {
      role_id: this.role,
      track_id: this.trackID,
      track_type: this.role == 6 ? 'chair' : 'reviewer'
    };

    this.permissionRoleApi.getUsersWithRoleNotInTrack(obj).subscribe(
        (res) => {
          this.users = res.users;
        },
        () => {},
        () => {
          this.loading = false;
        }
      );
  }

  save() {
    this.isSaving = true;

    if (this.role == 6) {
      this.manageConferenceApi.addChairsToTrack(this.selectedusers, this.trackID).subscribe(
          (res) => {
            if (res.success) {
              this.dialogRef.close(res);
            }
          },
          () => {},
          () => {
            this.isSaving = false;
          }
        );
    } else if (this.role === 8) {
      this.manageConferenceApi.addReviewersToTrack(this.selectedusers, this.trackID).subscribe(res => {
        if (res.success) {
          this.dialogRef.close(res);
        }
      });
    }
  }

  dismiss() {
    this.dialogRef.close();
  }

  addToList(user) {
    this.selectedusers.push(user);
  }
}
