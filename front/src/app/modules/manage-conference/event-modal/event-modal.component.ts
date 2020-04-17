import { Component, OnInit, Inject } from '@angular/core';
import { ApiService } from 'src/app/core/http/api.service';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Event } from 'src/app/shared/models/event.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import * as _ from 'lodash';

@Component({
  selector: 'app-event-modal',
  templateUrl: './event-modal.component.html',
  styleUrls: ['./event-modal.component.scss']
})
export class EventModalComponent implements OnInit {

  private translations = [];
  private descTranslations = [];
  private event: Event = {
    name_pl: '',
    name_en: '',
    name_ru: '',
    datetime: '',
    hour: '',
    end: '',
    end_hour: '',
    colour: '#000000',
    description_pl: '',
    description_en: '',
    description_ru: '',
    conference_id: '',
    date_changed: false,
    date_changed_end: false
  };
  private addLoading;
  private loading;
  private descLoading;
  private modal_type: string;
  private conference_id;
  private lang;
  private originalDate;
  private originalDateEnd;
  private destroying;
  private calendar;

  constructor(
    private dialogRef: MatDialogRef<EventModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private conferenceApi: ManageConferenceApiService,
    private apiService: ApiService
  ) {
    if (data.event) {
      this.event = data.event;
      this.event.datetime = this.event.datetime === null ? null : new Date(this.event.datetime);
      this.originalDate = _.cloneDeep(this.event.datetime);

      this.event.end = this.event.end === null ? null : new Date(this.event.end);
      this.originalDateEnd = _.cloneDeep(this.event.end);

      this.translations[0] = data.event.name_pl;
      this.translations[1] = data.event.name_en;
      this.translations[2] = data.event.name_ru;

      this.descTranslations[0] = data.event.description_pl;
      this.descTranslations[1] = data.event.description_en;
      this.descTranslations[2] = data.event.description_ru;
    }

    if (data.conference_id) {
      this.conference_id = data.conference_id;
    }

    if (data.calendar) {
      this.calendar = data.calendar;
    }

    this.modal_type = data.modal_type;
   }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

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

  getDescTranslations(input) {
    const obj = {
      name: input
    };

    this.descLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      this.descTranslations[0] = response.translation.name_pl;
      this.descTranslations[1] = response.translation.name_en;
      this.descTranslations[2] = response.translation.name_ru;

      this.event.description_pl = response.translation.name_pl;
      this.event.description_en = response.translation.name_en;
      this.event.description_ru = response.translation.name_ru;

      this.descLoading = false;
    });
  }

  addEvent() {
    this.loading = true;

    this.conferenceApi.addEvent(this.event).subscribe(
        (res) => {
          this.dialogRef.close(res);
        },
        () => {},
        () => {
          this.loading = false;
        }
      );
  }
  
  dismiss() {
    this.dialogRef.close();
  }

  delete() {
    this.destroying = true;

    this.conferenceApi.deleteEvent(this.event).subscribe(
        (res) => {
          this.dialogRef.close(res);
        },
        () => {},
        () => {
          this.destroying = false;
        }
    )
  }

  updateEvent () {
    this.loading = true;

    this.event.name_pl = this.translations[0];
    this.event.name_en = this.translations[1];
    this.event.name_ru = this.translations[2];

    this.event.description_pl = this.descTranslations[0];
    this.event.description_en = this.descTranslations[1];
    this.event.description_ru = this.descTranslations[2];

    this.dateChanged(this.event);
    this.dateChangedEnd(this.event);

    this.conferenceApi.updateEvent(this.event).subscribe(
        (res) => {
          this.dialogRef.close(res);
        },
        () => {},
        () => {
          this.loading = false;
        }
      );
  }

  dateChanged(event) {
    event.date_changed = this.event.datetime === null ? false : ((this.originalDate ? this.originalDate.getTime() : null) != this.event.datetime.getTime());
  }

  dateChangedEnd(event) {
    event.date_changed_end = this.event.end === null ? false : ((this.originalDateEnd ? this.originalDateEnd.getTime() : null) != this.event.end.getTime());
  }
}
