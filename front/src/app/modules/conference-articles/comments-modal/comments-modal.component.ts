import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-comments-modal',
  templateUrl: './comments-modal.component.html',
  styleUrls: ['./comments-modal.component.scss']
})
export class CommentsModalComponent implements OnInit {

  private comments = [];

  constructor(    
    private dialogRef: MatDialogRef<CommentsModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
  ) {
    if (data.comments) {
      this.comments = data.comments;
    }
   }

  ngOnInit() {

  }

  dismiss() {
    this.dialogRef.close();
  }

}
