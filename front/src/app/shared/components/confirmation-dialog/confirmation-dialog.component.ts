import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from '../../../core/http/api.service';
import { Input } from '@angular/core';
import { LanguageService } from '../../services/user/language.service';

@Component({
  selector: 'app-confirmation-dialog',
  templateUrl: './confirmation-dialog.component.html',
  styleUrls: ['./confirmation-dialog.component.scss']
})
export class ConfirmationDialogComponent implements OnInit {

  @Input() title: string;
  @Input() text: string;
  @Input() elToDelete: any;
  @Input() apiToDelete: string;

  lang: string;
  loading = false;

  constructor(
    public dialogRef: MatDialogRef<ConfirmationDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private apiService: ApiService,
    private languageService: LanguageService
  ) { 
      if (data) {
        if (data.title) {
          this.title = data.title;
        }

        if (data.text) {
          this.text = data.text;
        }

        if(data.element) {
          this.elToDelete = data.element;
        }

        if(data.apiToDelete) {
          this.apiToDelete = data.apiToDelete;
        }
      }
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  accept() {
    this.loading = true;
    this.apiService.post(this.apiToDelete, this.elToDelete).subscribe(response => {
      console.log(response);
      this.dialogRef.close(response);
    });
  }

  dismiss() {
    this.dialogRef.close();
  }

}
