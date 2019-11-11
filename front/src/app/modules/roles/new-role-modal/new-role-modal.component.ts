import { Component, OnInit, Output, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from "@angular/material";

@Component({
  selector: 'app-new-role-modal',
  templateUrl: './new-role-modal.component.html',
  styleUrls: ['./new-role-modal.component.scss']
})
export class NewRoleModalComponent implements OnInit {

  modal_type: string;

  constructor(
    private dialogRef: MatDialogRef<NewRoleModalComponent>,
    @Inject(MAT_DIALOG_DATA) data
  ) {
    this.modal_type = data.modal_type;
  }

  ngOnInit() {
  }

  sendRoleName(roleName) {
    const role = {
      'name': roleName
    };

    this.dialogRef.close(role);
  }

  dismiss() {
    this.dialogRef.close();
  }
}
