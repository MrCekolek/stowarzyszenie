import { Component, OnInit, Input, Inject } from '@angular/core';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from 'src/app/core/http/api.service';

@Component({
  selector: 'app-content-fill',
  templateUrl: './content-fill.component.html',
  styleUrls: ['./content-fill.component.scss']
})
export class ContentFillComponent implements OnInit {

  content;
  translations = [];
  translating: boolean;

  constructor(
    private portfolioApiService: PortfolioApiService,
    private dialogRef: MatDialogRef<ContentFillComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private apiService: ApiService
  ) { 
    if (data.content) {
      this.content = data.content;
    }
  }

  ngOnInit() {
    console.log(this.content);
  }

  dismiss() {
    this.dialogRef.close();
  }

  updateContent() {
    this.content.contents[0].value_pl = this.translations[0];
    this.content.contents[0].value_en = this.translations[1];
    this.content.contents[0].value_ru = this.translations[2];

    console.log();

    this.dialogRef.close(this.content);
  }

  translate(input) {
    this.translating = true;

    const obj = {
      name: input
    };

    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
  
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.translating = false;
    });
  }
}
