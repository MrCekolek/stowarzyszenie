import { Component, OnInit } from '@angular/core';
import { PortfolioService } from 'src/app/core/services/portfolio.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-whole-portfolio',
  templateUrl: './whole-portfolio.component.html',
  styleUrls: ['./whole-portfolio.component.scss']
})
export class WholePortfolioComponent implements OnInit {

  allTabs: any = [];
  lang: string = '';

  constructor(
    private portfolioService: PortfolioService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.portfolioService.getAllTabs().subscribe(value => {
      this.allTabs = value.portfolioTabs;
    });

    this.languageService.currentLang.subscribe( lg => {
      this.lang = lg;
    });
  }

  sortTabsByPosition() {
    
  }
}
