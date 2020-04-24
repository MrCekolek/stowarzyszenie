import { Component, OnInit } from '@angular/core';
import { Track } from 'src/app/shared/models/track.model';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ActivatedRoute } from '@angular/router';
import { MatDialogRef, MatDialog, MatDialogConfig } from '@angular/material';
import { AssignUserComponent } from '../assign-user/assign-user.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import {AlertModel} from "../../../shared/models/alert.model";
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-track-members',
  templateUrl: './track-members.component.html',
  styleUrls: ['./track-members.component.scss']
})
export class TrackMembersComponent implements OnInit {

  private track: Track;
  private trackID;

  private loading;
  private alert: AlertModel;
  private lang;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private route: ActivatedRoute,
    private dialog: MatDialog,
    private languageService: LanguageService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.trackID = this.route.snapshot.paramMap.get('id');

    const obj = {
      id: this.trackID
    };

    this.manageConferenceApi.getTrack(obj).subscribe(
        (res) => {
          this.track = res.track;
        },
        () => {},
        () => {
          this.loading = false;
        }
      );

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  assignReviewer() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      role: 8,
      track: this.trackID
    };

    const dialogRef = this.dialog.open(AssignUserComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.track.track_reviewers.push(...data.trackReviewers);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  assignChair() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      role: 6,
      track: this.trackID
    };

    const dialogRef = this.dialog.open(AssignUserComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.track.track_chairs.push(...data.trackChairs);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  deleteReviewerFromTrack(reviewer) {
    let obj = {
      ['name_' + this.lang]: reviewer.first_name + ' ' + reviewer.last_name,
      track_id: this.trackID,
      user_id: reviewer.id
    };

    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_REVIEWER.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_REVIEWER.TEXT',
      element: obj,
      apiToDelete: `conference/track/reviewer/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.track.track_reviewers.findIndex(item => item.id === reviewer.id);
            this.track.track_reviewers.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  deleteChairFromTrack(chair) {
    let obj = {
      ['name_' + this.lang]: chair.first_name + ' ' + chair.last_name,
      track_id: this.trackID,
      user_id: chair.id
    };

    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_CHAIR.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_CHAIR.TEXT',
      element: obj,
      apiToDelete: `conference/track/chair/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.track.track_chairs.findIndex(item => item.id === chair.id);
            this.track.track_chairs.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
