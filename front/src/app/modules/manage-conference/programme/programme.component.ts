import { Component, OnInit } from '@angular/core';
import { EventInput } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

@Component({
  selector: 'app-programme',
  templateUrl: './programme.component.html',
  styleUrls: ['./programme.component.scss']
})
export class ProgrammeComponent implements OnInit {

  calendarPlugins = [dayGridPlugin, timeGrigPlugin, interactionPlugin];
  calendarEvents: EventInput[] = [
    { title: 'Event Now', start: new Date() }
  ];

  handleDateClick(calDate) {
    // console.log(calDate);
  }

  eventClicked(calDate) {
    // console.log(calDate);
  }

  constructor() { }

  ngOnInit() {
  }

}
