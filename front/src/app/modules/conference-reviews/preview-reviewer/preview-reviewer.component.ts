import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-preview-reviewer',
  templateUrl: './preview-reviewer.component.html',
  styleUrls: ['./preview-reviewer.component.scss']
})
export class PreviewReviewerComponent implements OnInit {

  private article;
  private lang;

  constructor(
    private dialogRef: MatDialogRef<PreviewReviewerComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService
  ) {
    if (data.article) {
      this.article = data.article;
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
