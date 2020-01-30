import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { PortfolioApiService } from '../../../core/http/portfolio-api.service';
import { CardContent } from '../../../shared/models/card-content';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { CardContentModalComponent } from '../card-content-modal/card-content-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { PortfolioCard } from 'src/app/shared/models/portfollio-card.model';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { AlertModel } from 'src/app/shared/models/alert.model';

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
  lang: string;
  private isLoading: boolean = true;
  private alert: AlertModel;

  constructor(
    private portfolioApiService: PortfolioApiService,
    private dialog: MatDialog,
    private languageService: LanguageService
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

    console.log(this.card);
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
          if (data.success) {
            this.contents.push(data);
          }
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
            const index = this.contents.indexOf(data.content);
            this.contents.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
