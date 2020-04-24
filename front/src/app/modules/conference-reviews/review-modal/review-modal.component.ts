import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-review-modal',
  templateUrl: './review-modal.component.html',
  styleUrls: ['./review-modal.component.scss']
})
export class ReviewModalComponent implements OnInit {

  private review;
  private lang;
  private choosingReviewer;

  constructor(
      private dialogRef: MatDialogRef<ReviewModalComponent>,
      @Inject(MAT_DIALOG_DATA) data
  ) {
    if (data.review) {
      this.review = data.review;
    }

    if (data.lang) {
      this.lang = data.lang;
    }
  }

  ngOnInit() {

  }

  dismiss() {
    this.dialogRef.close();
  }

}
