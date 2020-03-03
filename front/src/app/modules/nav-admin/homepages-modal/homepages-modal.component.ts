import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';

@Component({
  selector: 'app-homepages-modal',
  templateUrl: './homepages-modal.component.html',
  styleUrls: ['./homepages-modal.component.scss']
})
export class HomepagesModalComponent implements OnInit {

  pageName: string;

  private addLoading = false;
  private isSaving: boolean = false;

  private translations = [];

  private lang;

  constructor(
    private dialogRef: MatDialogRef<HomepagesModalComponent>,
    private languageService: LanguageService,
    private apiService: ApiService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  dismiss() {
    this.translations = [];
    this.pageName = '';
    this.dialogRef.close();
  }

  getInterestTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.addLoading = false;
    });
  }
}
