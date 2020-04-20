import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActualConferenceComponent } from './actual-conference/actual-conference.component';
import { ManageConferenceRoutingModule } from './manage-conference-routing.module';
import { SharedModule } from 'src/app/shared/shared.module';
import { AddConferenceComponent } from './add-conference/add-conference.component';
import { GeneralSettingsComponent } from './general-settings/general-settings.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { CommitteeComponent } from './committee/committee.component';
import { ManageTracksComponent } from './manage-tracks/manage-tracks.component';
import { TrackModalComponent } from './track-modal/track-modal.component';
import { TrackMembersComponent } from './track-members/track-members.component';
import { AssignUserComponent } from './assign-user/assign-user.component';
import { PaymentsComponent } from './payments/payments.component';
import { ConferenceCfpComponent } from './conference-cfp/conference-cfp.component';
import { ConferencePageComponent } from './conference-page/conference-page.component';
import { CalendarComponent } from './calendar/calendar.component';
import { GalleryComponent } from './gallery/gallery.component';
import { ProgrammeComponent } from './programme/programme.component';
import { ConferenceRoleModalComponent } from './conference-role-modal/conference-role-modal.component';
import { AngularEditorModule } from '@kolkov/angular-editor';
import { ConfPagesModalComponent } from './conf-pages-modal/conf-pages-modal.component';
import { ConfpageEditComponent } from './confpage-edit/confpage-edit.component';
import { EventModalComponent } from './event-modal/event-modal.component';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { DateAdapter, MatNativeDateModule } from '@angular/material';
import { CarouselModule } from 'ngx-owl-carousel-o';
import { CommitteeModalComponent } from './committee-modal/committee-modal.component';
import { FullCalendarModule } from '@fullcalendar/angular';
import { NgxMaterialTimepickerModule } from 'ngx-material-timepicker';
import { ColorPickerModule } from "ngx-color-picker";
import { NgxUploaderModule } from "ngx-uploader";
import { GalleryAddComponent } from './gallery/gallery-add/gallery-add.component';
import { NgxGalleryModule } from "ngx-gallery";
import 'hammerjs';

@NgModule({
  declarations: [ActualConferenceComponent, AddConferenceComponent, GeneralSettingsComponent, CommitteeComponent, ManageTracksComponent, ConfPagesModalComponent, TrackModalComponent, TrackMembersComponent, AssignUserComponent, PaymentsComponent, ConferenceCfpComponent, CalendarComponent, GalleryComponent, ProgrammeComponent, ConferenceRoleModalComponent, ConferencePageComponent, ConfpageEditComponent, EventModalComponent, CommitteeModalComponent, GalleryAddComponent],
    imports: [
        CommonModule,
        ManageConferenceRoutingModule,
        SharedModule,
        FormsModule,
        AngularEditorModule,
        MatDatepickerModule,
        MatNativeDateModule,
        CarouselModule,
        FullCalendarModule,
        NgxMaterialTimepickerModule,
        ColorPickerModule,
        NgxUploaderModule,
        NgxGalleryModule,
        ReactiveFormsModule
    ],
  entryComponents: [TrackModalComponent, AssignUserComponent, ConferenceRoleModalComponent, ConfPagesModalComponent, EventModalComponent, CommitteeModalComponent],
  providers: []
})
export class ManageConferenceModule { }
