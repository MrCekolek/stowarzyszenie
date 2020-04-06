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


  private loading: boolean = true;
  private conference;

  translateNameLoading;
  translatePlaceLoading;
  addLoading;

  // adding conf fields
  private confname;
  private confacronym;
  private confweb;
  private confplace;
  private confstatus;

  //translations arrays
  private nameTranslations = [];
  private placeTranslations = [];

  private lang;

  private statuses = [
    {
      name: 'waiting',
      translation_key: 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.WAITING'
    },
    {
      name: 'during',
      translation_key: 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.DURING'
    },
    {
      name: 'finished',
      translation_key: 'STOWARZYSZENIE.MODULES.CONFERENCE.STATUS.FINISHED'
    }
  ];

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
      this.confacronym = res.conference.acronym;
      this.confweb = res.conference.website;
      this.loading = false;
    });

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
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
    this.conference.acronym = this.confacronym;
    this.conference.website = this.confweb;
    this.conference.place_pl = this.placeTranslations[0];
    this.conference.place_en = this.placeTranslations[1];
    this.conference.place_ru = this.placeTranslations[2];
    this.conference.status = this.confstatus;

    this.manageConferenceApi.updateConference(this.conference);
  }

}
