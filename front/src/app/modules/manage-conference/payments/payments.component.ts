import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { ConferenceRoleModalComponent } from '../conference-role-modal/conference-role-modal.component';

@Component({
  selector: 'app-payments',
  templateUrl: './payments.component.html',
  styleUrls: ['./payments.component.scss']
})
export class PaymentsComponent implements OnInit {

  private users = [];
  private loading;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    // this.loading;
    // TODO: pobranie wszystkich zarejestrowanych do konferencji userów
    // this.manageConferenceApi.getRegisteredUsers().subscribe(res => {
    //   this.users = res.users;
    // this.loading = false;
    // });
  }

  roleModal(user) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      user: user
    };

    const dialogRef = this.dialog.open(ConferenceRoleModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
      (data) => {
        if (data) {
          console.log(data);
          if (data.success) {
            
          }
        }
      }
    );
  }

  paymentsModal() {
    
  }

  deleteModal() {
    
  }
}
