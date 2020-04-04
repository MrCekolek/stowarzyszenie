import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActualConferenceComponent } from './actual-conference/actual-conference.component';
import { ManageConferenceRoutingModule } from './manage-conference-routing.module';
import { SharedModule } from 'src/app/shared/shared.module';
import { AddConferenceComponent } from './add-conference/add-conference.component';
import { GeneralSettingsComponent } from './general-settings/general-settings.component';
import { FormsModule } from '@angular/forms';
import { CommitteeComponent } from './committee/committee.component';



@NgModule({
  declarations: [ActualConferenceComponent, AddConferenceComponent, GeneralSettingsComponent, CommitteeComponent],
  imports: [
    CommonModule,
    ManageConferenceRoutingModule,
    SharedModule,
    FormsModule
  ]
})
export class ManageConferenceModule { }
