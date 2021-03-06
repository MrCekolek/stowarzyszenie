import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { ConferenceRoleModalComponent } from '../conference-role-modal/conference-role-modal.component';
import { LanguageService } from "../../../shared/services/user/language.service";
import { AlertModel } from "../../../shared/models/alert.model";
import { ConfirmationDialogComponent } from "../../../shared/components/confirmation-dialog/confirmation-dialog.component";
import * as _ from 'lodash';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-payments',
  templateUrl: './payments.component.html',
  styleUrls: ['./payments.component.scss']
})
export class PaymentsComponent implements OnInit {

  private lang;
  private users = [];
  private loadingConference;
  private loadingUsers;
  private alert: AlertModel;
  private conference_id;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private languageService: LanguageService,
    private conferenceApi: ManageConferenceApiService,
    private dialog: MatDialog,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loadingConference = true;
    this.loadingUsers = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.conferenceApi.getConference().subscribe(
        (res) => {
          this.conference_id = res.conference.id;
        },
        () => {},
        () => {
          this.loadingConference = false;

          if (this.conference_id) {
            this.manageConferenceApi.getRegisteredUsers().subscribe(
                (res) => {
                  this.users = res.conferenceUsers;
                },
                () => {},
                () => {
                  this.loadingUsers = false;
                }
            );
          }
        }
    );
  }

  roleModal(user) {
    const dialogConfig = new MatDialogConfig();

    var originalRoles =  _.cloneDeep(user.roles);

    console.log(user);

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      user: user
    };

    const dialogRef = this.dialog.open(ConferenceRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.alert = new AlertModel('success', data.message);
          } else {
            user.roles = originalRoles;
            this.alert = new AlertModel('danger', data.message);
          }
        } else {
          user.roles = originalRoles;
        }
      }
    );
  }

  paymentsModal() {
    
  }

  deleteModal(user) {
    var obj = {
      ['name_' + this.lang]: user.first_name + ' ' + user.last_name,
      user_id: user.id
    };

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PARTICIPANTS.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PARTICIPANTS.TEXT',
      element: obj,
      apiToDelete: 'conference/user/destroy'
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        (data) => {
          if (data) {
            if (data.success) {
              const index = this.users.findIndex(item => item.user_id === user.id);
              this.users.splice(index, 1);
              this.alert = new AlertModel('success', data.message);
            } else {
              this.alert = new AlertModel('danger', data.message);
            }
          }
        }
    );
  }
}
