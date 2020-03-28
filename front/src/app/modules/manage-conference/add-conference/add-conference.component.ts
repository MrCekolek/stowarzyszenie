import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Conference } from 'src/app/shared/models/conference.model';
import { ApiService } from 'src/app/core/http/api.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-conference',
  templateUrl: './add-conference.component.html',
  styleUrls: ['./add-conference.component.scss']
})
export class AddConferenceComponent implements OnInit {

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

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private apiService: ApiService,
    private router: Router
  ) { }

  ngOnInit() {
    this.loading = true;

    this.manageConferenceApi.getConference().subscribe(res => {
      console.log(res);
      this.conference = res.conference;
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

  addConference() {
    this.addLoading = true;

    const conf: Conference = {
      name_pl: this.nameTranslations[0],
      name_en: this.nameTranslations[1],
      name_ru: this.nameTranslations[2],
      content_pl: {},
      content_en: {},
      content_ru: {},
      place_pl: this.placeTranslations[0],
      place_en: this.placeTranslations[1],
      place_ru: this.placeTranslations[2],
      status: '',
      conference_id: 0
    }

    this.manageConferenceApi.addConference(conf).subscribe(res => {
      console.log(res);
      if (res.success) {
        this.router.navigateByUrl('../actual');
      }
      this.addLoading = false;
    });
  }

}
