import { Component, OnInit } from '@angular/core';
import { PortfolioService } from 'src/app/core/services/portfolio.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { UserProviderService } from 'src/app/shared/services/user/user-provider.service';

@Component({
  selector: 'app-whole-portfolio',
  templateUrl: './whole-portfolio.component.html',
  styleUrls: ['./whole-portfolio.component.scss']
})
export class WholePortfolioComponent implements OnInit {

  allTabs: any = [];
  lang: string = '';

  private loading = true;

  constructor(
    private portfolioService: PortfolioService,
    private languageService: LanguageService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.portfolioService.getAllTabs().subscribe(value => {
      this.allTabs = value.portfolioTabs;
      this.loading = false;
    });

    this.languageService.currentLang.subscribe( lg => {
      this.lang = lg;
    });

    console.log(this.userProvider.checkPermission('USERS.ADD'));
  }

  sortTabsByPosition() {
    
  }
}
