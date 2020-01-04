import { Component, OnInit, Input } from '@angular/core';
import { PortfolioTab } from 'src/app/shared/models/portfolio-tab.model';
import { PortfolioService } from 'src/app/core/services/portfolio.service';
import { PortfolioCard } from 'src/app/shared/models/portfollio-card.model';
import { ApiService } from '../../../core/http/api.service';
import { PortfolioApiService } from '../../../core/http/portfolio-api.service';

@Component({
  selector: 'app-portfolio-tabs',
  templateUrl: './portfolio-tabs.component.html',
  styleUrls: ['./portfolio-tabs.component.scss']
})
export class PortfolioTabsComponent implements OnInit {

  @Input() lang: any;
  @Input() tabs: any;
  editMode = false;
  private load = false;

  private activeTab: PortfolioTab;
  private activeTabsCards: any = [];

  constructor(
    private portfolioService: PortfolioService,
    private apiService: ApiService,
    private portfolioApiService: PortfolioApiService
  ) { }

  ngOnInit() {
  }

  ngAfterViewInit() {
    this.selectActiveTab(this.tabs[0]);
  }

  appendTile(edit_input) {
    this.editMode = true;
  }

  addTab(name: string) {
    if (!name) {
      return;
    }

    this.load = true;
    const obj = {
      name: name
    };
    let tab = {};

    this.apiService.post('translation/get', obj).subscribe(response => {
      if (response.success) {
        tab = {
          name_pl: response.translation.name_pl,
          name_en: response.translation.name_en,
          name_ru: response.translation.name_ru,
        };

        this.portfolioApiService.addTab(tab).subscribe(response => {
          if (response.success) {
            this.tabs.push(response.portfolioTab);
            this.load = false;
            this.editMode = false;
          }
        });
      }
    });

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

  editTab(tab) {
    tab.editing = true;
  }

  cancelEditing(tab) {
    tab.editing = false;
  }

  updateTab(tab, name) {
    console.log(tab);
    tab.loading = true;
    const obj = {
      name: name
    };

    this.apiService.post('translation/get', obj).subscribe(response => {
      if (response.success) {
        tab.name_pl = response.translation.name_pl;
        tab.name_en = response.translation.name_en;
        tab.name_ru = response.translation.name_ru;

        this.portfolioApiService.updateTab(tab).subscribe(response => {
          console.log(response);
          tab.loading = false;
          tab.editing = false;
        });
      }
    });
  }

  deleteTab(tab) {
    tab.deleting = true;

    this.portfolioApiService.deleteTab(tab).subscribe(response => {
      tab.deleting = false;
      console.log(response);
    });
  }
}
