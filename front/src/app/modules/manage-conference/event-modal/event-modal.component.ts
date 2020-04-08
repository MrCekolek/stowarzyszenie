import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/core/http/api.service';
import { MatDialogRef } from '@angular/material';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Event } from 'src/app/shared/models/event.model';

@Component({
  selector: 'app-event-modal',
  templateUrl: './event-modal.component.html',
  styleUrls: ['./event-modal.component.scss']
})
export class EventModalComponent implements OnInit {

  private translations = [];
  private event: Event = {
    name_pl: '',
    name_en: '',
    name_ru: '',
    date: '',
    colour: '',
    description_pl: '',
    description_en: '',
    description_ru: '',
    conference_id: ''
  };
  private addLoading;
  private loading;

  constructor(
    private apiService: ApiService,
    private dialogRef: MatDialogRef<EventModalComponent>,
    private conferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.conferenceApi.getConference().subscribe(res => {
      this.event.conference_id = res.conference.id;
    });
  }

  getTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.event.name_pl = response.translation.name_pl;
      this.event.name_en = response.translation.name_en;
      this.event.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  addEvent() {
    this.loading = true;

    this.conferenceApi.addEvent(this.event).subscribe(res => {
      console.log(res);
      this.dialogRef.close(res);
    });
  }
  
  dismiss() {
    this.dialogRef.close();
  }

  updateEvent () {
    this.loading = true;

    this.conferenceApi.updateEvent(this.event).subscribe(res => {
      console.log(res);
      this.dialogRef.close(res);
    });
  }
}
