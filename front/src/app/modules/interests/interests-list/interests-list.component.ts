import { Component, OnInit, ViewChild } from '@angular/core';
import { InterestsService } from 'src/app/core/services/interests.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { Interest } from 'src/app/shared/models/interest.model';
import { AlertModel } from 'src/app/shared/models/alert.model';
import { MatDialog, MatDialogConfig, MatDialogRef } from '@angular/material';
import { InterestModalComponent } from '../interest-modal/interest-modal.component';
import { ConfirmationDialogComponent } from '../../../shared/components/confirmation-dialog/confirmation-dialog.component';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-interests-list',
  templateUrl: './interests-list.component.html',
  styleUrls: ['./interests-list.component.scss']
})
export class InterestsListComponent implements OnInit {

  @ViewChild('newInterest', {static: false}) newInterest: any;

  allInterests: Array<Interest> = [];
  lang: any;

  private alert: AlertModel

  private loading: boolean = false;

  private alertMessage: string = '';
  private alertClass: string = '';

  constructor(
    private interestsService: InterestsService,
    private languageService: LanguageService,
    private dialog: MatDialog,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.interestsService.getInterests().subscribe( value => {
      for(const key in value.interests) {
        if (value.interests.hasOwnProperty(key)) {
          this.allInterests.push(new Interest(value.interests[key]));
        }
      };

      this.loading = false;
    });

    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });
  }

  ngOnDestroy() {
  }

  enableEditing(interest) {
    interest.editing = true;
  }

  openNewInterestModal(type: string, interest?) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: type,
      interest: interest
    };

    const dialogRef = this.dialog.open(InterestModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            if (type === 'new') {
              this.interestsService.addNewInterest(data.interest);
              this.allInterests.push(data.interest);
              this.alert = new AlertModel('success', data.message);
            } else if (type === 'edit') {
              const index = this.allInterests.findIndex(item => item.id === data.interest.id);
              this.allInterests[index] = data.interest;
              this.alert = new AlertModel('success', data.message);
            }
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }

  openDeleteDialog(interest) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.INTERESTS.TEXT',
      element: interest,
      apiToDelete: `interest/${interest.id}/destroy`
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);
    
    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          if (data.success) {
            const index = this.allInterests.indexOf(interest);
            this.allInterests.splice(index, 1);
            this.alert = new AlertModel('success', data.message);
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
