import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { PortfolioApiService } from '../../../core/http/portfolio-api.service';
import { CardContent } from '../../../shared/models/card-content';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { CardContentModalComponent } from '../card-content-modal/card-content-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { PortfolioCard } from 'src/app/shared/models/portfollio-card.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { AlertModel } from 'src/app/shared/models/alert.model';
import { Route } from '@angular/compiler/src/core';
import { ActivatedRoute, Router, ActivatedRouteSnapshot } from '@angular/router';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { ContentFillComponent } from '../content-fill/content-fill.component';

@Component({
  selector: 'app-portfolio-card',
  templateUrl: './portfolio-card.component.html',
  styleUrls: ['./portfolio-card.component.scss']
})
export class PortfolioCardComponent implements OnInit {

  @Input() card;
  contents = [];
  @Output() delCardEv = new EventEmitter<any>();
  @Output() editCardEv = new EventEmitter<any>();
  @Input() portfolioRole: string;
  @Input() owner: boolean;
  lang: string;
  private isLoading: boolean = true;
  private alert: AlertModel;

  private role;

  constructor(
    private portfolioApiService: PortfolioApiService,
    private dialog: MatDialog,
    private languageService: LanguageService,
    private router: Router,
    private route: ActivatedRoute,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.isLoading = true;
    this.portfolioApiService.getCardContent(this.card.id).subscribe(response => {
      this.contents = response.tileContents;
      this.isLoading = false;
    });

    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });

    if (this.router.url.includes('portfolio-settings')) {
      this.role = 'admin';
    } else if (this.router.url.includes('users/profile')) {
      this.role = 'user';
      this.owner = Number.parseInt(this.route.snapshot.paramMap.get('id')) === this.userProvider.getUser().id;
    }
  }

  openNewContentModal(modal_type) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: modal_type,
      card: this.card
    };

    const dialogRef = this.dialog.open(CardContentModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
            this.contents.push(data[0]);
        }
      }
    );
  }

  deleteCard() {
    this.delCardEv.emit(this.card);
  }

  emitEditEvent() {
    this.editCardEv.emit(this.card);
  }

  deleteContent(content) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.CARD_CONTENT.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.CARD_CONTENT.TEXT',
      element: content,
      apiToDelete: 'portfolio/tile/content/destroy'
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.contents.findIndex(item => item.id === data.elToDelete.id);
            this.contents.splice(index, 1);

            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  hideCard() {
    let obj = {};

    if (this.userProvider.getUser().roles.find( x => x.name_en === 'Admin')) {
      obj = {
        id: this.card.id,
        shared_id: this.card.shared_id,
        field: 'admin',
        visibility: !this.card.admin_visibility
      };
    } else {
      obj = {
        id: this.card.id,
        shared_id: this.card.shared_id,
        field: 'user',
        visibility: !this.card.user_visibility
      };
    }

    this.portfolioApiService.hideOrShowCard(obj).subscribe(res => {
      if (res.success) {
        this.card.admin_visibility = !this.card.admin_visibility;
        this.alert = new AlertModel('success', res.message);
      } else {
        this.alert = new AlertModel('danger', res.message);
      }
    });
  }

  saveContent(content) {
    content.saveLoading = true;
    this.portfolioApiService.updateContentInCard(content).subscribe(res => {
      content.saveLoading = false;
    });
  }

  hideContent(content) {
    if (this.role === 'admin') {
      content.admin_visibility = !content.admin_visibility;
    } else if (this.role === 'user') {
      content.user_visibility = !content.user_visibility;
    }
  }

  openFillContentModal(content: any) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      content: content
    };

    const dialogRef = this.dialog.open(ContentFillComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
        }
      }
    );
  }
}
