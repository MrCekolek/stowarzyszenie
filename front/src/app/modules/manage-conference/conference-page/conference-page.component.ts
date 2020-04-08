import { Component, OnInit } from '@angular/core';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { MatDialogConfig, MatDialog } from '@angular/material';
import { ConfPagesModalComponent } from '../conf-pages-modal/conf-pages-modal.component';
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-conference-page',
  templateUrl: './conference-page.component.html',
  styleUrls: ['./conference-page.component.scss']
})
export class ConferencePageComponent implements OnInit {

  conflinks = [];
  loading: boolean;
  private lang;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private dialog: MatDialog,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.conferenceApi.getConference().subscribe(res => {
      this.conflinks = res.conference.conference_pages;
      console.log(this.conflinks);
      this.loading = false;
    });
  }

  addConfpage() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;
    const dialogRef = this.dialog.open(ConfPagesModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            this.conflinks.push(data.conferencePage);
          }
        }
      }
    );
  }

  deletePage(page) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.CONFPAGE.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.CONFPAGE.TEXT',
      element: page,
      apiToDelete: 'conference/page/destroy'
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.conflinks.indexOf(page);
            this.conflinks.splice(index, 1);
          }
        }
      }
    );
  }
}