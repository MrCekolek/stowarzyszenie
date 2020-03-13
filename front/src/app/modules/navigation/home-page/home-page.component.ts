import { Component, OnInit } from '@angular/core';
import { NavigationService } from 'src/app/core/services/navigation.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ActivatedRoute } from '@angular/router';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss']
})
export class HomePageComponent implements OnInit {

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

    if (!this.navigationService.selectedPage) {
      this.navigationService.selectedPage = this.navigationService.getPage(this.route.snapshot.paramMap.get('id'));
    }
  }

}
