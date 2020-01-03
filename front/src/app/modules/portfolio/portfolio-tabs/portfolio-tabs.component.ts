import { Component, OnInit, Input } from '@angular/core';
import { PortfolioTab } from 'src/app/shared/models/portfolio-tab.model';
import { PortfolioService } from 'src/app/core/services/portfolio.service';
import { PortfolioCard } from 'src/app/shared/models/portfollio-card.model';

@Component({
  selector: 'app-portfolio-tabs',
  templateUrl: './portfolio-tabs.component.html',
  styleUrls: ['./portfolio-tabs.component.scss']
})
export class PortfolioTabsComponent implements OnInit {

  @Input() lang: any;
  @Input() tabs;

  private activeTab: PortfolioTab;
  private activeTabsCards: any = [];

  constructor(
    private portfolioService: PortfolioService
  ) { }

  ngOnInit() {
  }

  ngAfterViewInit() {
    this.selectActiveTab(this.tabs[0]);
  }

  addTab(tab: PortfolioTab) {
    this.tabs.push(tab);
  }

  selectActiveTab(tab) {
    this.activeTab = tab;
    console.log(this.portfolioService.getTabCards(tab.id).subscribe(cards => {
      console.log(cards);
      this.activeTabsCards = cards.tiles;
    }));
  }

  addCard(name: string) {
    this.portfolioService.addCardToTab(name, this.activeTab.id).subscribe(response => {
      console.log(response);
      if (response.success) {
        this.activeTabsCards.push(new PortfolioCard(
          response.tile
        ));
      } else {
        console.log("nie udalo sie dodac");
      }
    });
  }
}
