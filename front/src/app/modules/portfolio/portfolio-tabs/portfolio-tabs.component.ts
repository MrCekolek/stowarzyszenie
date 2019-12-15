import { Component, OnInit, Input } from '@angular/core';
import { PortfolioTab } from 'src/app/shared/models/portfolio-tab.model';

@Component({
  selector: 'app-portfolio-tabs',
  templateUrl: './portfolio-tabs.component.html',
  styleUrls: ['./portfolio-tabs.component.scss']
})
export class PortfolioTabsComponent implements OnInit {

  @Input() lang: any;
  @Input() tabs;

  activeTab: number;

  constructor() { }

  ngOnInit() {
    this.activeTab = 1;
  }

  addTab(tab: PortfolioTab) {
    this.tabs.push(tab);
  }

  selectActiveTab(id: number) {
    this.activeTab = id;
  }
}
