import { Component, OnInit } from '@angular/core';
import { Track } from 'src/app/shared/models/track.model';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ActivatedRoute } from '@angular/router';
import { MatDialogRef, MatDialog, MatDialogConfig } from '@angular/material';
import { AssignUserComponent } from '../assign-user/assign-user.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-track-members',
  templateUrl: './track-members.component.html',
  styleUrls: ['./track-members.component.scss']
})
export class TrackMembersComponent implements OnInit {

  private track_chairs = [];
  private track_reviewers = [];
  private track: Track;
  private track_interest;
  private trackID;

  private loading;

  private lang;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private route: ActivatedRoute,
    private dialog: MatDialog,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.trackID = this.route.snapshot.paramMap.get('id');

    const obj = {
      id: this.trackID
    };
    this.manageConferenceApi.getTrack(obj).subscribe(res => {
      this.track = res.track;
    });

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    // this.loading = true;

    // TODO: pobranie chairs
    this.manageConferenceApi.getTrackChair(obj).subscribe(res => {
      this.track_chairs = res.chair;
    });

    //TODO: pobranie recenzentow
    this.manageConferenceApi.getTrackReviewers(obj).subscribe(res => {
      this.track_reviewers = res.reviewers;
    });
  }

  assignReviewer() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      role: 8,
      track: this.trackID,
      users: this.track_reviewers
    };

    const dialogRef = this.dialog.open(AssignUserComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.track_reviewers = data.users;
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
      track: this.trackID,
      users: this.track_chairs
    };

    const dialogRef = this.dialog.open(AssignUserComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.track_chairs = data.users;
          }
        }
      }
    );
  }

  deleteReviewerFromTrack(reviewer) {
    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_REVIEWER.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_REVIEWER.TEXT',
      element: reviewer,
      apiToDelete: `conference/track/reviewer/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.track_reviewers.indexOf(reviewer);
            this.track_reviewers.splice(index, 1);
          } else {
          }
        }
      }
    );
  }

  deleteChairFromTrack(chair) {
    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_CHAIR.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK_CHAIR.TEXT',
      element: chair,
      apiToDelete: `conference/track/chair/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.track_chairs.indexOf(chair);
            this.track_chairs.splice(index, 1);
          } else {
          }
        }
      }
    );
  }
}
