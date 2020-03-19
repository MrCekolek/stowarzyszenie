import { Component, OnInit, Input } from '@angular/core';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { ConferencePagesComponent } from '../conference-pages/conference-pages.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';

@Component({
  selector: 'app-conference-pages-list',
  templateUrl: './conference-pages-list.component.html',
  styleUrls: ['./conference-pages-list.component.scss']
})
export class ConferencePagesListComponent implements OnInit {

  @Input() links = [];
  lang;
  @Input() loading: boolean;

  constructor(
    private languageService: LanguageService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(lg => {
      this.lang = lg;
    });
  }

  addPage() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;
    const dialogRef = this.dialog.open(ConferencePagesComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.links.push(data.page);
          }
        }
      }
    );
  }

  deletePage(page) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      // title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TITLE',
      // text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TEXT',
      // element: page,
      // apiToDelete: 'home_navigation/destroy'
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.links.indexOf(data.page);
            this.links.splice(index, 1);
          }
        }
      }
    );
  }
}
