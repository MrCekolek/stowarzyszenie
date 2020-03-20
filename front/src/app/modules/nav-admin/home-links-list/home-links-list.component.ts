import { Component, OnInit, Input } from '@angular/core';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { HomepagesModalComponent } from '../homepages-modal/homepages-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { HomeNavigation } from 'src/app/shared/models/home-navigation';

@Component({
  selector: 'app-home-links-list',
  templateUrl: './home-links-list.component.html',
  styleUrls: ['./home-links-list.component.scss']
})
export class HomeLinksListComponent implements OnInit {

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

  addHomepage() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;
    const dialogRef = this.dialog.open(HomepagesModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.links.push(data.homeNavigation);
          }
        }
      }
    );
  }

  deletePage(page) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TEXT',
      element: page,
      apiToDelete: 'home_navigation/destroy'
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
