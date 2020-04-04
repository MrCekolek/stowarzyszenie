import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-actual-conference',
  templateUrl: './actual-conference.component.html',
  styleUrls: ['./actual-conference.component.scss']
})
export class ActualConferenceComponent implements OnInit {

  private loading: boolean;
  private conference;
  private lang;
  private message;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;
    
    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });

    this.manageConferenceApi.getConference().subscribe(res => {
      console.log(res);
      if (res.success) {
        this.conference = res.conference;
      } else {
        this.message = res.message;
      }

      this.loading = false;
    });
  }

}
