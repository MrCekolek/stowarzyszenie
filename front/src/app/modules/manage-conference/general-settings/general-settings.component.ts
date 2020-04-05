import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ApiService } from 'src/app/core/http/api.service';
import { Router } from '@angular/router';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-general-settings',
  templateUrl: './general-settings.component.html',
  styleUrls: ['./general-settings.component.scss']
})
export class GeneralSettingsComponent implements OnInit {


  private loading: boolean;
  private conference;

  translateNameLoading;
  translatePlaceLoading;
  addLoading;

  // adding conf fields
  private confname;
  private confacronym;
  private confweb;
  private confplace;

  //translations arrays
  private nameTranslations = [];
  private placeTranslations = [];

  private lang;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private apiService: ApiService,
    private router: Router,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.manageConferenceApi.getConference().subscribe(res => {
      this.conference = res.conference;
    });

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;

      this.loading = false;
    });
  }

  getNameTranslations() {
    const obj: any = {
      name: this.confname
    };
    this.translateNameLoading = true;
    this.apiService.post('translation/get', obj).subscribe(res => {
      this.nameTranslations[0] = res.translation.name_pl;
      this.nameTranslations[1] = res.translation.name_en;
      this.nameTranslations[2] = res.translation.name_ru;
      this.translateNameLoading = false;
    });
  }

  getPlaceTranslations() {
    const obj: any = {
      name: this.confplace
    };
    this.translatePlaceLoading = true;
    this.apiService.post('translation/get', obj).subscribe(res => {
      this.placeTranslations[0] = res.translation.name_pl;
      this.placeTranslations[1] = res.translation.name_en;
      this.placeTranslations[2] = res.translation.name_ru;
      this.translatePlaceLoading = false;
    });
  }

  updateConference() {
    this.conference.name_pl = this.nameTranslations[0];
    this.conference.name_pl = this.nameTranslations[1];
    this.conference.name_pl = this.nameTranslations[2];

    this.manageConferenceApi.updateConference(this.conference);
  }

}
