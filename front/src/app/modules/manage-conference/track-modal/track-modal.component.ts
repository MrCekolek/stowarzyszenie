import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from 'src/app/core/http/api.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { Track } from 'src/app/shared/models/track.model';
import { InterestsApiService } from 'src/app/core/http/interests-api.service';

@Component({
  selector: 'app-track-modal',
  templateUrl: './track-modal.component.html',
  styleUrls: ['./track-modal.component.scss']
})
export class TrackModalComponent implements OnInit {

  private modal_type;
  private translations = [];
  private addLoading;
  private isSaving;
  private track: Track = {
    id: '',
    name_pl: '',
    name_en: '',
    name_ru: '',
    colour: '',
    conference_id: '',
    interest_id: ''
  };

  private interests = [];
  private selectedInterest;

  private lang;
  private interestsLoading;

  constructor(
    private dialogRef: MatDialogRef<TrackModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private manageConferenceApi: ManageConferenceApiService,
    private apiService: ApiService,
    private interestsApi: InterestsApiService
  ) {
    this.modal_type = data.modal_type;

    if (data.track) {
      this.track = data.track;

      this.translations[0] = data.track.name_pl;
      this.translations[1] = data.track.name_en;
      this.translations[2] = data.track.name_ru;

      this.selectedInterest = data.track.interest_id;
    }

    if (data.conference_id) {
      this.track.conference_id = data.conference_id;
    }
   }

  ngOnInit() {
    this.interestsLoading = true;
    this.interestsApi.getAllInterests().subscribe(res => {
      this.interests = res.interests;
      this.interestsLoading = false;
    });

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  dismiss() {
    this.dialogRef.close();
  }

  getTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.track.name_pl = response.translation.name_pl;
      this.track.name_en = response.translation.name_en;
      this.track.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  addTrack() {
    console.log(this.selectedInterest);
    this.isSaving = true;
    this.track.name_pl = this.translations[0];
    this.track.name_en = this.translations[1];
    this.track.name_ru = this.translations[2];
    this.track.interest_id = this.selectedInterest;

    console.log(this.track);
    this.manageConferenceApi.addTrack(this.track).subscribe(response => {
      this.isSaving = false;
      this.dialogRef.close(response);
    });
  }

  updateTrack() {
    this.isSaving = true;
    this.track.name_pl = this.translations[0];
    this.track.name_en = this.translations[1];
    this.track.name_ru = this.translations[2];
    this.track.interest_id = this.selectedInterest;

    this.manageConferenceApi.addTrack(this.track).subscribe(response => {
      this.isSaving = false;
      this.dialogRef.close(response);
    });
  }
}
