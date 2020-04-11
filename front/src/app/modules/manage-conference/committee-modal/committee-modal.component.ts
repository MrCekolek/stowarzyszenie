import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { PermissionRoleApiService } from 'src/app/core/http/permission-role-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { UserRoleApiService } from "../../../core/http/user-role-api.service";
import { ManageConferenceApiService } from "../../../core/http/manage-conference-api.service";

@Component({
  selector: 'app-committee-modal',
  templateUrl: './committee-modal.component.html',
  styleUrls: ['./committee-modal.component.scss']
})
export class CommitteeModalComponent implements OnInit {

  private allUsers = [];
  private selectedUsers = [];

  private lang;
  private users;
  private saving;
  private isLoading;
  private conferenceId;

  constructor(
      private dialog: MatDialogRef<CommitteeModalComponent>,
      private languageService: LanguageService,
      private userRoleApiService: UserRoleApiService,
      private manageConferenceApiService: ManageConferenceApiService,
      @Inject(MAT_DIALOG_DATA) data
  ) {
    if (data.user) {
      this.users = data.user;

      for (let i = 0; i < this.users.length; i++) {
        this.selectedUsers.push(this.users[i].user);
      }
    }

    if (data.conference_id) {
      this.conferenceId = data.conference_id;
    }
  }

  ngOnInit() {
    this.isLoading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.userRoleApiService.getUsers(5).subscribe(
        (res) => {
          this.allUsers = res.users;
        },
        () => {},
        () => {
          this.isLoading = false;
        }
    );
  }

  saveRoles() {
    this.saving = true;

    this.manageConferenceApiService.createPC(this.conferenceId, this.selectedUsers).subscribe(
        (res) => {
          this.dialog.close(res);
        },
        () => {},
        () => {
          this.saving = false;
        }
    );
  }

  userExists(user) {
    return this.selectedUsers.findIndex(item => item.id === user.id) === -1;
  }

  dismiss() {
    this.dialog.close();
  }

  assignUser(user) {
    this.selectedUsers.push(user);
  }

  deassignUser(user) {
    const index = this.selectedUsers.findIndex(item => item.id === user.id);

    this.selectedUsers.splice(index, 1);
  }
}

