import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { OwlOptions } from 'ngx-owl-carousel-o';

@Component({
  selector: 'app-conference-overview',
  templateUrl: './conference-overview.component.html',
  styleUrls: ['./conference-overview.component.scss']
})
export class ConferenceOverviewComponent implements OnInit {

  private loading;
  private loadingUsers;
  private conference;
  private lang;
  private registerLoading;

  private isRegistered;
  private userID;

  customOptions: OwlOptions = {
    loop: true,
    mouseDrag: true,
    touchDrag: false,
    pullDrag: false,
    dots: false,
    navSpeed: 700,
    navText: ['<', '>'],
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      740: {
        items: 3
      },
      940: {
        items: 4
      }
    },
    nav: true
  };

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private languageService: LanguageService,
    private userProvider: UserProviderService 
  ) { }

  ngOnInit() {
    this.loading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.userID = this.userProvider.getUser().id;

    this.conferenceApi.getConference().subscribe(
      (res) => {
        if (res.success) {
          this.conference = res.conference;

          if (this.conference && this.conference.id) {
            this.loadingUsers = true;

            this.conferenceApi.getRegisteredUsers().subscribe(
                (resp) => {
                  this.isRegistered = resp.conferenceUsers.some(item => item.id === this.userID);
                },
                () => {},
                () => {
                  this.loadingUsers = false;
                }
              );
          }
        }
      },
      () => {},
      () => {
          this.loading = false;
      }
    );
  }

  registerToConference() {
    this.registerLoading = true;
    const obj = {
      user_id: this.userID,
      conference_id: this.conference.id
    };

    this.conferenceApi.registerUserToConference(obj).subscribe(      
      (res) => {
        if (res.success) {
          this.isRegistered = true;
        }
      },
      () => {
      },
      () => {
        this.registerLoading = false;
    });
  }
}
