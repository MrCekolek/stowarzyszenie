import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { ActualConferenceComponent } from './actual-conference/actual-conference.component';
import { AddConferenceComponent } from './add-conference/add-conference.component';
import { GeneralSettingsComponent } from './general-settings/general-settings.component';
import { ManageTracksComponent } from './manage-tracks/manage-tracks.component';
import { TrackMembersComponent } from './track-members/track-members.component';
import { PaymentsComponent } from './payments/payments.component';
import { ConferenceCfpComponent } from './conference-cfp/conference-cfp.component';
import { ConferencePageComponent } from './conference-page/conference-page.component';
import { CalendarComponent } from './calendar/calendar.component';
import { CommitteeComponent } from './committee/committee.component';
import { GalleryComponent } from './gallery/gallery.component';
import { ProgrammeComponent } from './programme/programme.component';
import { ConfpageEditComponent } from './confpage-edit/confpage-edit.component';
import {GalleryAddComponent} from "./gallery/gallery-add/gallery-add.component";

const routes: Routes = [{
    path: '',

    children: [
        {
            path: '',
            pathMatch: 'full',
            redirectTo: 'actual',
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'actual',
            component: ActualConferenceComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'general',
            component: GeneralSettingsComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'create',
            component: AddConferenceComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'tracks',
            component: ManageTracksComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'tracks/members/:id',
            component: TrackMembersComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'participants',
            component: PaymentsComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'cfp',
            component: ConferenceCfpComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'confpage-edit/:id',
            component: ConfpageEditComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'conference-page',
            component: ConferencePageComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'calendar',
            component: CalendarComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'committee',
            component: CommitteeComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'gallery',
            component: GalleryComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'gallery-add',
            component: GalleryAddComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'programme',
            component: ProgrammeComponent,
            canActivateChild: [
                LoggedGuard
            ]
        }
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class ManageConferenceRoutingModule { }
