import { Component, OnInit, ViewChild } from '@angular/core';
import { InterestsService } from 'src/app/core/services/interests.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { Interest } from 'src/app/shared/models/interest.model';
import { AlertModel } from 'src/app/shared/models/alert.model';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { InterestModalComponent } from '../interest-modal/interest-modal.component';

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

  private loading: boolean;

  private alertMessage: string = '';
  private alertClass: string = '';

  constructor(
    private interestsService: InterestsService,
    private languageService: LanguageService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.loading = true;
    this.interestsService.getInterests().subscribe( value => {
      for(const key in value.interests) {
        if (value.interests.hasOwnProperty(key)) {
          this.allInterests.push(new Interest(value.interests[key]));
        }
      };

      console.log(this.allInterests);
      this.loading = false;
    });

    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });
  }

  ngOnDestroy() {
  }

  deleteInterest(id: number) {
    console.log(id);
    this.allInterests.find(i => i.id === id).deleteLoading = true;
    this.interestsService.deleteInterest(id).subscribe(response => {
      if (response.success) {
        this.alert = new AlertModel('success', response.message);
        this.allInterests.find(i => i.id === id).deleteLoading = false;
        this.allInterests.splice(this.allInterests.findIndex(item => item.id === id), 1);
      } else {
        this.alert = new AlertModel('danger', response.message);
      }
    });
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
            }
          } else {
            this.alert = new AlertModel('danger', data.message);
          }
        }
      }
    );
  }
}
