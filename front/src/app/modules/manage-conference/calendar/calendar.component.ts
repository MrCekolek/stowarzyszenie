import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { MatDialog, MatDialogRef, MatDialogConfig } from '@angular/material';
import { EventModalComponent } from '../event-modal/event-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.scss']
})
export class CalendarComponent implements OnInit {

  private events = [];
  private loading;
  private conference_id;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.loading = true;

    this.conferenceApi.getConference().subscribe(res => {
      this.events = res.conference.conference_events;
      this.conference_id = res.conference.id;
      
      this.loading = false;
    });
  }

  addEvent() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new',
      event: null,
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(EventModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          console.log(data);
          if (data.success) {
            this.events.push(data.event);
          }
        }
      }
    );
  }

  updateEvent(event) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new',
      track: event,
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(EventModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          console.log(data);
          if (data.success) {
            const index = this.events.indexOf(data.event);
          }
        }
      }
    );
  }

  deleteEvent(event) {
    const dialogConfig = new MatDialogConfig();
  
    dialogConfig.autoFocus = true;
  
    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.EVENT.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.EVENT.TEXT',
      element: event,
      apiToDelete: `conference/event/destroy`
    };
  
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.events.indexOf(event);
            this.events.splice(index, 1);
          } else {
          }
        }
      }
    );
  }
}
