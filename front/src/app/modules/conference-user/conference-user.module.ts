import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RegisterToConferenceComponent } from './register-to-conference/register-to-conference.component';
import { ConferenceInformationsComponent } from './conference-informations/conference-informations.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { ConferenceUserRoutingModule } from './conference-user-routing.module';
import { ConferenceOverviewComponent } from './conference-overview/conference-overview.component';
import { CarouselModule } from 'ngx-owl-carousel-o';
import { CfpComponent } from './cfp/cfp.component';
import { ProgrammeComponent } from './programme/programme.component';
import { FullCalendarModule } from '@fullcalendar/angular';

@NgModule({
  declarations: [RegisterToConferenceComponent, ConferenceInformationsComponent, ConferenceOverviewComponent, CfpComponent, ProgrammeComponent],
  imports: [
    CommonModule,
    SharedModule,
    ConferenceUserRoutingModule,
    CarouselModule,
    FullCalendarModule
  ]
})
export class ConferenceUserModule { }
