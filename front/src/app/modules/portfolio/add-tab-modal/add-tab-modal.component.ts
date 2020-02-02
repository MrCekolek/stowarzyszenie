import { Component, OnInit, Inject, ViewChild, ElementRef } from '@angular/core';
import { PortfolioTab } from '../../../shared/models/portfolio-tab.model';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from '../../../shared/services/user/language.service';
import { ApiService } from '../../../core/http/api.service';
import { PortfolioApiService } from '../../../core/http/portfolio-api.service';

@Component({
  selector: 'app-add-tab-modal',
  templateUrl: './add-tab-modal.component.html',
  styleUrls: ['./add-tab-modal.component.scss']
})
export class AddTabModalComponent implements OnInit {

  modal_type: string;
  tabName: string;

  private tab: PortfolioTab = {
    id: 1,
    shared_id: 1,
    name_en: '',
    name_pl: '',
    name_ru: '',
    position: 0,
    admin_visibility: 1,
    user_visibility: 1,
    portfolio_id: 0
  };

  private addLoading = false;
  private isSaving: boolean = false;

  private translations = [];

  private lang;
  private user;
  private buttonTitle;

  constructor(
    private dialogRef: MatDialogRef<AddTabModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private apiService: ApiService,
    private portfolioService: PortfolioApiService
  ) {
    this.modal_type = data.modal_type;

    if (data.tab) {
      this.tab = data.tab;

      this.translations.push(data.tab.name_pl);
      this.translations.push(data.tab.name_en);
      this.translations.push(data.tab.name_ru);
    }
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.user = this.languageService.getUser();
  }

  ngAfterViewInit() {
  }

  dismiss() {
    this.translations = [];
    this.tabName = '';
    this.dialogRef.close();
  }

  getTabTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.tab.name_pl = response.translation.name_pl;
      this.tab.name_en = response.translation.name_en;
      this.tab.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  addTab() {
    this.isSaving = true;
    this.tab.portfolio_id = this.user.id;
    this.portfolioService.addTab(this.tab).subscribe(response => {
      this.isSaving = false;
      console.log('response z modala');
      console.log(response);
      this.dialogRef.close(response);
    });
  }

  updateTab() {
    this.isSaving = true;
    this.tab.name_pl = this.translations[0];
    this.tab.name_en = this.translations[1];
    this.tab.name_ru = this.translations[2];
    console.log(this.tab);
    this.portfolioService.updateTab(this.tab).subscribe(data => {
      this.isSaving = false;
      this.dialogRef.close(data);
    });
  }

}
