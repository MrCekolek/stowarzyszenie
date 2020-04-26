import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-conference-page',
  templateUrl: './conference-page.component.html',
  styleUrls: ['./conference-page.component.scss']
})
export class ConferencePageComponent implements OnInit {

  private loading;
  private conference;
  private lang;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
    });
    this.conferenceApi.getConference().subscribe(
      (res) => {
        console.log(res);
        if (res.success) {
          this.conference = res.conference;
        }
      },
      () => {
      },
      () => {
          this.loading = false;
      }
    );
  }
}
