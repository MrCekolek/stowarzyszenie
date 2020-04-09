import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ApiService } from 'src/app/core/http/api.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { TrackModalComponent } from '../track-modal/track-modal.component';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';

@Component({
  selector: 'app-manage-tracks',
  templateUrl: './manage-tracks.component.html',
  styleUrls: ['./manage-tracks.component.scss']
})
export class ManageTracksComponent implements OnInit {

  private tracks = [];
  private loading;
  private conference_id;
  private lang;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private apiService: ApiService,
    private dialog: MatDialog,
    private languageService: LanguageService
  ) { }

  ngOnInit() {  
    this.loading = true;
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
    this.manageConferenceApi.getConference().subscribe(value => {
      const obj = {
        conference_id: value.conference.id
      };
      this.conference_id = value.conference.id;

      this.manageConferenceApi.getTracks(obj).subscribe(res => {
        this.tracks = res.tracks;
        this.loading = false;
      });
    });
  }

  addTrackModal() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new',
      track: null,
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(TrackModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.tracks.push(data.track);
          }
        }
      }
    );
  }

  updateTrack(track) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit',
      track: track,
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(TrackModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.tracks.indexOf(track);
            this.tracks[index] = data.track;
          }
        }
      }
    );
  }

  deleteTrack(track) {
    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRACK.TEXT',
      element: track,
      apiToDelete: `conference/track/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.tracks.indexOf(track);
            this.tracks.splice(index, 1);
          } else {
          }
        }
      }
    );
  }
}
