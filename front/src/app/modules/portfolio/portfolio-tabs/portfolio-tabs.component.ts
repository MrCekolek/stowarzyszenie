import { Component, OnInit, Input } from '@angular/core';
import { PortfolioTab } from '../../../shared/models/portfolio-tab.model';
import { PortfolioService } from '../../../core/services/portfolio.service';
import { PortfolioCard } from '../../../shared/models/portfollio-card.model';
import { ApiService } from '../../../core/http/api.service';
import { PortfolioApiService } from '../../../core/http/portfolio-api.service';
import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { AddTabModalComponent } from '../add-tab-modal/add-tab-modal.component';
import { AlertModel } from '../../../shared/models/alert.model';
import { ConfirmationDialogComponent } from '../../../shared/components/confirmation-dialog/confirmation-dialog.component';
import { LanguageService } from '../../../shared/services/user/language.service';
import { EditCardModalComponent } from '../edit-card-modal/edit-card-modal.component';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-portfolio-tabs',
  templateUrl: './portfolio-tabs.component.html',
  styleUrls: ['./portfolio-tabs.component.scss']
})
export class PortfolioTabsComponent implements OnInit {

  @Input() lang: any;
  @Input() tabs: any;
  @Input() preview: boolean = false;

  editMode = false;
  private load = false;
  private cardAddingLoad = false;

  private activeTab: PortfolioTab = {
    id: 1,
    shared_id: 0,
    name_en: '',
    name_pl: '',
    name_ru: '',
    position: 0,
    admin_visibility: 1,
    user_visibility: 1,
    portfolio_id: 0
  };
  private activeTabsCards: any = [];

  private alert: AlertModel;
  private role;
  private owner?;
  private userID;

  tabLoading;

  constructor(
    private portfolioService: PortfolioService,
    private apiService: ApiService,
    private portfolioApiService: PortfolioApiService,
    private dialog: MatDialog,
    private languageService: LanguageService,
    private userProvider: UserProviderService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    if (this.router.url.includes('portfolio-settings')) {
      this.role = 'admin';
      this.owner = true;
      this.userID = this.userProvider.getUser().id;
    } else if (this.router.url.includes('users/profile')) {
      this.role = 'user';
      this.owner = Number.parseInt(this.route.snapshot.paramMap.get('id')) === this.userProvider.getUser().id;
      this.userID = this.route.snapshot.params['id'];
    }
  }

  ngAfterViewInit() {
    // this.selectActiveTab(this.tabs[0]);
  }

  selectActiveTab(tab) {
    this.tabLoading = true;
    this.activeTab = tab;

    this.portfolioService.getTabCards(tab.id).subscribe(
        (cards) => {
          this.activeTabsCards = cards.tiles;
        },
        () => {},
        () => {
          this.tabLoading = false;
        }
      );
  }

  addCard(name: string) {
    this.cardAddingLoad = true;
    const newCard = {
      id: 1,
      shared_id: 0,
      name_en: 'Card header',
      name_pl: 'Nagłówek karty',
      name_ru: 'заголовок карты',
      position: 0,
      admin_visibility: 1,
      user_visibility: 1,
      portfolio_tab_id: this.activeTab.id,
      portfolio_tab_shared_id: this.activeTab.shared_id
    };

    this.portfolioService.addCardToTab(newCard).subscribe(response => {
      if (response.success) {
        this.activeTabsCards.push(new PortfolioCard(
          response.tile
        ));
      } else {
        // console.log("nie udalo sie dodac");
      }
      this.cardAddingLoad = false;
    });
  }

  openTabModal(type: string, tab?: any) {
    if (type === 'edit') {
      var tabNamePl = tab.name_pl;
      var tabNameEn = tab.name_en;
      var tabNameRu = tab.name_ru;
    }

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: type,
      tab: tab
    };

    const dialogRef = this.dialog.open(AddTabModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            if (type === 'new') {
              this.tabs.push(data.portfolioTab);
              this.alert = new AlertModel('success', data.message);
            } else if (type === 'edit') {
              const index = this.tabs.findIndex(item => item.id === data.portfolioTab.id);
              this.tabs[index] = data.tab;
              this.alert = new AlertModel('success', data.message);
            }
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        } else {
          if (type === 'edit') {
            tab.name_pl = tabNamePl;
            tab.name_en = tabNameEn;
            tab.name_ru = tabNameRu;
          }
        }
      }
    );
  }

  openDeleteDialog(tab) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PORTFOLIO_TAB.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PORTFOLIO_TAB.TEXT',
      element: tab,
      apiToDelete: 'portfolio/tabs/destroy'
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.tabs.indexOf(tab);
            this.tabs.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  deleteCard(card) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PORTFOLIO.CARD_TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.PORTFOLIO.CARD',
      element: card,
      apiToDelete: `portfolio/tile/destroy`
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.activeTabsCards.indexOf(card);
            this.activeTabsCards.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  editCard(card) {
    var cardNamePl = card.name_pl;
    var cardNameEn = card.name_en;
    var cardNameRu = card.name_ru;

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      card: card
    };

    const dialogRef = this.dialog.open(EditCardModalComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.activeTabsCards.indexOf(card);
            this.activeTabsCards[index] = data.tile;

            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        } else {
          card.name_pl = cardNamePl;
          card.name_en = cardNameEn;
          card.name_ru = cardNameRu;
        }
      }
    );
  }

  hideOrShowTab(tab) {
    let obj = {
      id: 0,
      shared_id: 0,
      field: '',
      visibility: true
    };

    tab.hiddingLoader = true;

    if (this.role === 'admin') {
      obj = {
        id: tab.id,
        shared_id: tab.shared_id,
        field: 'admin',
        visibility: !tab.admin_visibility
      };
    } else if (this.role === 'user') {
      obj = {
        id: tab.id,
        shared_id: tab.shared_id,
        field: 'user',
        visibility: !tab.user_visibility
      };
    }

    this.portfolioApiService.hideOrShowTab(obj).subscribe(res => {
      if (res.success) {
        if (this.role === 'admin') {
          tab.admin_visibility = !tab.admin_visibility;
        } else if (this.role === 'user' && this.owner) {
          tab.user_visibility = !tab.user_visibility;
        }

        this.alert = new AlertModel('success', res.message);
      } else {
        this.alert = new AlertModel('danger', res.message);
      }
    });
  }

  drop(event: CdkDragDrop<string[]>) {
    moveItemInArray(this.tabs, event.previousIndex, event.currentIndex);
  }
}
