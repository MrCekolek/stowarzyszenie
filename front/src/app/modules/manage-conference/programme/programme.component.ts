import { Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';
import { FullCalendarComponent } from '@fullcalendar/angular';
import timeGridPlugin from '@fullcalendar/timegrid';
import plLocale from '@fullcalendar/core/locales/pl';
import ruLocale from '@fullcalendar/core/locales/ru';
import { ManageConferenceApiService } from '../../../core/http/manage-conference-api.service';
import {MatDialog, MatDialogConfig} from '@angular/material';
import { LanguageService } from '../../../shared/services/user/language.service';
import { TranslateService } from "@ngx-translate/core";
import { EventModalComponent } from "../event-modal/event-modal.component";
import { AlertModel } from "../../../shared/models/alert.model";
import * as _ from 'lodash';
import * as moment from 'moment';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

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
        private dialog: MatDialog,
        private languageService: LanguageService,
        private translationService: TranslateService,
        private userProvider: UserProviderService
    ) { }

    ngOnInit() {
        this.loading = true;

        this.languageService.currentLang.subscribe(value => {
            this.lang = value;
        });

        this.conferenceApi.getConference().subscribe(
            (res) => {
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
            },
            () => {},
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

                new Draggable(this.draggable.nativeElement, {
                    itemSelector: '.fc-event',
                    eventData: function(eventEl) {
                        return {
                            title: eventEl.innerText
                        };
                    }
                });
            }
        );
    }

    eventClick(model) {
        const index = this.conference.conference_events.findIndex(item => item.id == model.event.id);
        const indexEventModel = this.eventsModel.findIndex(item => item.id == model.event.id);

        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            modal_type: 'edit',
            event: _.cloneDeep(this.conference.conference_events[index]),
            conference_id: this.conference.id,
            calendar: false
        };

        const dialogRef = this.dialog.open(EventModalComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(
            (data) => {
                if (data) {
                    if (data.success) {
                        if (data.destroyed) {
                            this.conference.conference_events.splice(index, 1);
                            this.eventsModel.splice(indexEventModel, 1);
                        } else {
                            this.conference.conference_events[index] = data.conferenceEvent;

                            this.eventsModel[indexEventModel] = {
                                'id': this.conference.conference_events[index]['id'],
                                'title': this.conference.conference_events[index]['title'],
                                'description': this.conference.conference_events[index]['description_' + this.lang],
                                'color': this.conference.conference_events[index]['colour'],
                                'start': this.conference.conference_events[index]['datetime'],
                                'end': this.conference.conference_events[index]['end'],
                            };
                        }

                        this.alert = new AlertModel('success', data.message);
                    } else {
                        this.alert = new AlertModel('danger', data.message);
                    }
                }
            }
        );
    }

    drop(model) {
        const index = this.events.findIndex(item => item.id == model.draggedEl.id);
        const indexEvents = this.conference.conference_events.findIndex(item => item.id == model.draggedEl.id);

        this.eventsModel.push({
            id: model.draggedEl.id,
            title: this.events[index]['name_' + this.lang],
            color: this.events[index]['colour'],
            start: model.date,
            end: null
        });

        this.conference.conference_events[indexEvents]['datetime'] = moment(model.date).format('YYYY-MM-DD HH:mm:ss');
        this.conference.conference_events[indexEvents]['hour'] = moment(model.date).format('HH:mm');
        this.conference.conference_events[indexEvents]['date_changed'] = false;
        this.conference.conference_events[indexEvents]['calendar'] = false;
        this.conference.conference_events[indexEvents]['programme_event'] = true;

        this.conferenceApi.updateEvent(this.conference.conference_events[indexEvents]).subscribe(
            (res) => {
                this.conference.conference_events[indexEvents] = res.conferenceEvent;
            }
        );

        this.events.splice(index, 1);

        this.dropped = !this.dropped;
    }

    eventDrop(model) {
        this.changeDates(model);
    }

    eventResize(model) {
        this.changeDates(model);
    }

    eventRender(model) {
        model.el.setAttribute('title', model.event.extendedProps.description);
    }

    changeDates(model) {
        const index = this.eventsModel.findIndex(item => item.id == model.event.id);
        const indexEvents = this.conference.conference_events.findIndex(item => item.id == model.event.id);

        this.eventsModel[index]['start'] = moment(model.event.start).format('YYYY-MM-DD HH:mm:ss');
        this.eventsModel[index]['end'] = moment(model.event.end).format('YYYY-MM-DD HH:mm:ss');

        this.conference.conference_events[indexEvents]['datetime'] = moment(model.event.start).format('YYYY-MM-DD HH:mm:ss');
        this.conference.conference_events[indexEvents]['hour'] = moment(model.event.start).format('HH:mm');

        if (model.event.end) {
            this.conference.conference_events[indexEvents]['end'] = moment(model.event.end).format('YYYY-MM-DD HH:mm:ss');
            this.conference.conference_events[indexEvents]['end_hour'] = moment(model.event.end).format('HH:mm');
        }

        this.conference.conference_events[indexEvents]['date_changed'] = false;
        this.conference.conference_events[indexEvents]['calendar'] = false;
        this.conference.conference_events[indexEvents]['programme_event'] = true;

        this.conferenceApi.updateEvent(this.conference.conference_events[indexEvents]).subscribe(
            (res) => {
                this.conference.conference_events[indexEvents] = res.conferenceEvent;
            }
        );
    }

    addEvent() {
        const dialogConfig = new MatDialogConfig();

        dialogConfig.autoFocus = true;

        dialogConfig.data = {
            modal_type: 'new',
            event: null,
            conference_id: this.conference.id,
            calendar: false
        };

        const dialogRef = this.dialog.open(EventModalComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(
            (data) => {
                if (data) {
                    if (data.success) {
                        this.conference.conference_events.push(data.conferenceEvent);

                        if (data.conferenceEvent.datetime === null) {
                            this.events.push(data.conferenceEvent);
                        } else {
                            this.eventsModel.push({
                                id: data.conferenceEvent['id'],
                                title: data.conferenceEvent['name_' + this.lang],
                                description: data.conferenceEvent['description_' + this.lang],
                                color: data.conferenceEvent['colour'],
                                start: data.conferenceEvent['datetime'],
                                end: data.conferenceEvent['end']
                            });
                        }

                        this.alert = new AlertModel('success', data.message);
                    } else {
                        this.alert = new AlertModel('danger', data.message);
                    }
                }
            }
        );
    }
}
