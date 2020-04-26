import { Component, OnInit } from '@angular/core';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';

@Component({
  selector: 'app-register-to-conference',
  templateUrl: './register-to-conference.component.html',
  styleUrls: ['./register-to-conference.component.scss']
})
export class RegisterToConferenceComponent implements OnInit {

  private loading;
  private userID;
  private lang;
  private isRegistered;
  private conference;

  constructor(
    private languageService: LanguageService,
    private userProvider: UserProviderService,
    private conferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
    this.userID = this.userProvider.getUser().id;
    this.conferenceApi.getConference().subscribe(
      (res) => {
        console.log(res);
        if (res.success) {
          this.conference = res.conference;
          this.conferenceApi.getRegisteredUsers().subscribe(resp => {
            this.isRegistered = resp.conferenceUsers.some(item => item.id === this.userID);
          });
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
