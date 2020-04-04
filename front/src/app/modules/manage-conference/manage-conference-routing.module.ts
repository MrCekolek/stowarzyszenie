import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { ActualConferenceComponent } from './actual-conference/actual-conference.component';
import { AddConferenceComponent } from './add-conference/add-conference.component';
import { GeneralSettingsComponent } from './general-settings/general-settings.component';

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
        }
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class ManageConferenceRoutingModule { }
