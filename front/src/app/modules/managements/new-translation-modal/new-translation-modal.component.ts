import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from "@angular/material";
import { ApiService } from "../../../core/http/api.service";
import { LanguageService } from "../../../shared/services/user/language.service";
import { TranslationsApiService } from "../../../core/http/translations-api.service";

@Component({
  selector: 'app-new-translation-modal',
  templateUrl: './new-translation-modal.component.html',
  styleUrls: ['./new-translation-modal.component.scss']
})
export class NewTranslationModalComponent implements OnInit {

  modal_type: string;
  roleName: string;

  addLoading = false;
  translations = [];

  translation = {
    translation_key: '',
    translation_pl: '',
    translation_en: '',
    translation_ru: ''
  };

  lang;
  saving = false;

  constructor(
      private dialogRef: MatDialogRef<NewTranslationModalComponent>,
      @Inject(MAT_DIALOG_DATA) data,
      private apService: ApiService,
      private languageService: LanguageService,
      private translationApiService: TranslationsApiService
  ) {
    this.modal_type = data.modal_type;

    if (data.translation) {
      this.translation.translation_pl = data.translation.translation_pl;
      this.translation.translation_en = data.translation.translation_en;
      this.translation.translation_ru = data.translation.translation_ru;

      this.translation.translation_key = data.translation.translation_key;

      if (data.translation.translation_pl && data.translation.translation_en && data.translation.translation_ru) {
        this.translations[0] = data.translation.translation_pl;
        this.translations[1] = data.translation.translation_en;
        this.translations[2] = data.translation.translation_ru;
      }
    }
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });
  }

  addTranslation() {
    this.saving = true;
    this.translation.translation_pl = this.translations[0];
    this.translation.translation_en = this.translations[1];
    this.translation.translation_ru = this.translations[2];

    this.translationApiService.addTranslation(this.translation).subscribe(response => {
      this.dialogRef.close(response);
      this.saving = false;
    });
  }

  updateTranslation() {
    this.saving = true;
    this.translation.translation_pl = this.translations[0];
    this.translation.translation_en = this.translations[1];
    this.translation.translation_ru = this.translations[2];

    this.translationApiService.updateTranslations(this.translation).subscribe(response => {
      this.dialogRef.close(response);
      this.saving = false;
    });
  }

  dismiss() {
    this.dialogRef.close();
  }

  getTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apService.post('translation/get', obj).subscribe(response => {
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.translation.translation_pl = response.translation.name_pl;
      this.translation.translation_en = response.translation.name_en;
      this.translation.translation_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }
}
