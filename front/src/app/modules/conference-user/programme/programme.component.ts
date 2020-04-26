import { Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { FullCalendarComponent } from '@fullcalendar/angular';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import plLocale from '@fullcalendar/core/locales/pl';
import ruLocale from '@fullcalendar/core/locales/ru';

@Component({
  selector: 'app-programme',
  templateUrl: './programme.component.html',
  styleUrls: ['./programme.component.scss']
})
export class ProgrammeComponent implements OnInit {

  @ViewChild('fullcalendar', {static: false}) fullcalendar: FullCalendarComponent;
  @ViewChild('draggable', {static: false}) draggable: ElementRef;

  options: any;
  eventsModel: any = [];
  eventsModelTmp: any;
  private loading;
  private conference;
  private events = [];
  private lang;
  private dropped = false;
  private alert;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private languageService: LanguageService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
    this.conferenceApi.getConference().subscribe(
      (res) => {
        console.log(res);
        if (res.success) {
          this.conference = res.conference;

          if (this.conference && this.conference.id) {
            this.events = res.conference.conference_events.filter(function (event) {
                return event.datetime === null && event.calendar == "0";
            });

            this.eventsModelTmp = res.conference.conference_events.filter(function (event) {
                return event.datetime !== null && event.calendar == "0";
            });

            for (let i = 0; i < this.eventsModelTmp.length; i++) {
               this.eventsModel.push({
                  id: this.eventsModelTmp[i]['id'],
                  title: this.eventsModelTmp[i]['name_' + this.lang],
                  description: this.eventsModelTmp[i]['description_' + this.lang],
                  color: this.eventsModelTmp[i]['colour'],
                  start: this.eventsModelTmp[i]['datetime'],
                  end: this.eventsModelTmp[i]['end']
               });
            }
        }
      }
    },
      () => {
      },
      () => {
          this.loading = false;
          this.options = {
            editable: true,
            theme: 'standard',
            defaultView: 'dayGridMonth',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locales: [plLocale, ruLocale],
            plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin]
        };
      }
    );
  }

}
