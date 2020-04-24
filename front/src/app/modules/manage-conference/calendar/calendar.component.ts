import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { MatDialog, MatDialogRef, MatDialogConfig } from '@angular/material';
import { EventModalComponent } from '../event-modal/event-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { LanguageService } from "../../../shared/services/user/language.service";
import * as _ from 'lodash';
import {AlertModel} from "../../../shared/models/alert.model";
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.scss']
})
export class CalendarComponent implements OnInit {

  private events = [];
  private loading;
  private conference_id;
  private lang;
  private alert;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private languageService: LanguageService,
    private dialog: MatDialog,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.conferenceApi.getConference().subscribe(
        (res) => {
          if (res.conference && res.conference.id) {
            this.events = res.conference.conference_events.filter(function (event) {
              return event.calendar == "1";
            });

            this.conference_id = res.conference.id;
          }
        },
        () => {},
        () => {
          this.loading = false;
        }
      );
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
          if (data.success) {
            this.events.push(data.conferenceEvent);

            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  updateEvent(event) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit',
      event: _.cloneDeep(event),
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(EventModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.events.findIndex(item => item.id === data.conferenceEvent.id);

            this.events[index] = data.conferenceEvent;

            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
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
            const index = this.events.findIndex(item => item.id === event.id);

            this.events.splice(index, 1);

            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
