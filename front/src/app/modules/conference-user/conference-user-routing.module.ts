import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { RegisterToConferenceComponent } from './register-to-conference/register-to-conference.component';
import { ConferenceOverviewComponent } from './conference-overview/conference-overview.component';
import { CfpComponent } from './cfp/cfp.component';
import { ProgrammeComponent } from './programme/programme.component';

const routes: Routes = [{
    path: '',

    children: [
        {
            path: '',
            pathMatch: 'full',
            redirectTo: 'overview',
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'overview',
            component: ConferenceOverviewComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'register',
            component: RegisterToConferenceComponent,
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'cfp',
            component: CfpComponent,
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
        },
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class ConferenceUserRoutingModule { }
