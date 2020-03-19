import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { NavigationService } from 'src/app/core/services/navigation.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ActivatedRoute } from '@angular/router';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class HomePageComponent implements OnInit {

  pageID;
  lang;

  constructor(
    private navigationService: NavigationService,
    private languageService: LanguageService,
    private route: ActivatedRoute,
    private navigationApi: NavigationApiService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.route.params.subscribe(params => {
      this.pageID = params.id;

      const obj = {
        id: this.pageID
      };
  
      this.navigationApi.getHomeLink(obj).subscribe(res => {
        this.navigationService.selectedPage = res.homeNavigation;
      });
    });

    // if (!this.navigationService.homepagesList && this.pageID) {
    //   console.log('jestem');
    //   this.navigationApi.getHomeLink(this.pageID).subscribe(res => {
    //     console.log(res);
    //     this.navigationService.selectedPage = res.homeLink;
    //   });
    // } else {
    //   this.navigationService.selectedPage = this.navigationService.getPage(this.pageID);
    // }
  }
}
