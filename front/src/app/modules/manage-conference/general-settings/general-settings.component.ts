import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { ApiService } from 'src/app/core/http/api.service';
import { Router } from '@angular/router';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import {AlertModel} from "../../../shared/models/alert.model";
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-general-settings',
  templateUrl: './general-settings.component.html',
  styleUrls: ['./general-settings.component.scss']
})
export class GeneralSettingsComponent implements OnInit {

  private finished: boolean = false;
  private loading: boolean = true;
  private conference;

  translateNameLoading;
  translatePlaceLoading;
  addLoading;

  //translations arrays
  private nameTranslations = [];
  private placeTranslations = [];

  private alert: AlertModel;

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
    private languageService: LanguageService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.manageConferenceApi.getConference().subscribe(res => {
      this.conference = res.conference;

      if (this.conference && this.conference.id) {
        if (this.conference.status === 'finished') {
          this.finished = true;
        }

        this.nameTranslations[0] = this.conference.name_pl;
        this.nameTranslations[1] = this.conference.name_en;
        this.nameTranslations[2] = this.conference.name_ru;

        this.placeTranslations[0] = this.conference.conference_preference['place_pl'];
        this.placeTranslations[1] = this.conference.conference_preference['place_en'];
        this.placeTranslations[2] = this.conference.conference_preference['place_ru'];
      }

      this.loading = false;
    });

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  getNameTranslations() {
    const obj: any = {
      name: this.conference['name_' + this.lang]
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
      name: this.conference.conference_preference['place_' + this.lang]
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
    this.addLoading = true;
    this.conference.name_pl = this.nameTranslations[0];
    this.conference.name_en = this.nameTranslations[1];
    this.conference.name_ru = this.nameTranslations[2];
    this.conference.place_pl = this.placeTranslations[0];
    this.conference.place_en = this.placeTranslations[1];
    this.conference.place_ru = this.placeTranslations[2];
    this.conference.website = this.conference.conference_preference.website;

    this.manageConferenceApi.updateConference(this.conference).subscribe(
        (res) => {
          if (res.success) {
            this.conference = res.conference;

            this.alert = new AlertModel('success', res.message);

            if (this.conference.status == 'finished') {
              this.finished = true;
            }
          } else {
            this.alert = new AlertModel('danger', res.message);
          }
        },
        () => {},
        () => {
          this.addLoading = false;
        }
      );
  }

  changeStatus(event) {
    this.conference.status = event.target.value;
  }
}
