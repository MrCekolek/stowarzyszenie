import { Component, OnInit, Input, Inject } from '@angular/core';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from 'src/app/core/http/api.service';
import {LanguageService} from "../../../shared/services/user/language.service";
import {PortfolioService} from "../../../core/services/portfolio.service";

@Component({
  selector: 'app-content-fill',
  templateUrl: './content-fill.component.html',
  styleUrls: ['./content-fill.component.scss']
})
export class ContentFillComponent implements OnInit {

  lang;
  content;
  type;
  translations = [];
  translating: boolean;
  isSaving: boolean = false;

  constructor(
    private portfolioApiService: PortfolioApiService,
    private dialogRef: MatDialogRef<ContentFillComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private apiService: ApiService,
    private languageService: LanguageService,
    private portfolioService: PortfolioService
  ) { 
    if (data.content) {
      console.log(data.content);

      this.content = data.content;
      this.type = data.type;

      if (data.content.contents[0].filled_pl != '' &&
          data.content.contents[0].filled_en != '' &&
          data.content.contents[0].filled_ru != '') {
        this.translations[0] = data.content.contents[0].filled_pl;
        this.translations[1] = data.content.contents[0].filled_en;
        this.translations[2] = data.content.contents[0].filled_ru;
      }
    }
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });
  }

  dismiss() {
    this.dialogRef.close();
  }

  updateContent() {
    this.isSaving = true;

    this.content.contents[0].filled_pl = this.translations[0];
    this.content.contents[0].filled_en = this.translations[1];
    this.content.contents[0].filled_ru = this.translations[2];

    this.portfolioService.updateContentInContent(this.content.contents[0]).subscribe(
        (data) => {
          if (data) {
            if (data.success) {
              this.dialogRef.close(this.content);
            }
          }
        },
        () => {},
        () => {
          this.isSaving = false;
        }
    );
  }

  translate() {
    this.translating = true;

    const obj = {
      name: this.content.contents[0]['filled_' + this.lang]
    };

    this.apiService.post('translation/get', obj).subscribe(
      (response) => {
        this.translations[0] = response.translation.name_pl;
        this.translations[1] = response.translation.name_en;
        this.translations[2] = response.translation.name_ru;
      },
      () => {},
      () => {
        this.translating = false;
      }
    );
  }
}
