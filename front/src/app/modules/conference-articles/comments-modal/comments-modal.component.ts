import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from "../../../shared/services/user/language.service";

@Component({
  selector: 'app-comments-modal',
  templateUrl: './comments-modal.component.html',
  styleUrls: ['./comments-modal.component.scss']
})
export class CommentsModalComponent implements OnInit {

  private comments = [];
  private lang;

  constructor(    
    private dialogRef: MatDialogRef<CommentsModalComponent>,
    private languageService: LanguageService,
    @Inject(MAT_DIALOG_DATA) data,
  ) {
    if (data.comments) {
      this.comments = data.comments;
    }
   }

  ngOnInit() {
    this.languageService.currentLang.subscribe(res => {
      this.lang = res;
    });
  }

  dismiss() {
    this.dialogRef.close();
  }
}
