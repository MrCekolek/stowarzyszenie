import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RegisterToConferenceComponent } from './register-to-conference/register-to-conference.component';
import { ConferenceInformationsComponent } from './conference-informations/conference-informations.component';



@NgModule({
  declarations: [RegisterToConferenceComponent, ConferenceInformationsComponent],
  imports: [
    CommonModule
  ]
})
export class ConferenceUserModule { }
