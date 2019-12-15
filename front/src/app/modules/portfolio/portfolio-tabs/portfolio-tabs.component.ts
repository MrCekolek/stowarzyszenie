import { Component, OnInit, Input } from '@angular/core';
import { PortfolioTab } from 'src/app/shared/models/portfolio-tab.model';
import { PortfolioService } from 'src/app/core/services/portfolio.service';

@Component({
  selector: 'app-portfolio-tabs',
  templateUrl: './portfolio-tabs.component.html',
  styleUrls: ['./portfolio-tabs.component.scss']
})
export class PortfolioTabsComponent implements OnInit {

  @Input() lang: any;
  @Input() tabs;

  activeTab: PortfolioTab;

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
    }));
  }
}
