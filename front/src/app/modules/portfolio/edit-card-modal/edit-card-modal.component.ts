import { Component, OnInit, Inject } from '@angular/core';
import { PortfolioCard } from 'src/app/shared/models/portfollio-card.model';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';
import { UserService } from 'src/app/shared/services/user/user.service';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';

@Component({
  selector: 'app-edit-card-modal',
  templateUrl: './edit-card-modal.component.html',
  styleUrls: ['./edit-card-modal.component.scss']
})
export class EditCardModalComponent implements OnInit {

  card: PortfolioCard = {
    id: 0,
    shared_id: 0,
    name_en: '',
    name_pl: '',
    name_ru: '',
    position: 0,
    admin_visibility: 1,
    user_visibility: 1,
    portfolio_tab_id: 0,
    portfolio_tab_shared_id: 0
  };
  
  private addLoading = false;
  private isSaving: boolean = false;

  private translations = [];

  private lang;

  constructor(
    private dialogRef: MatDialogRef<EditCardModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private apiService: ApiService,
    private portfolioService: PortfolioApiService
  ) {
    if (data.card) {
      this.card = data.card;

      this.translations.push(data.card.name_pl);
      this.translations.push(data.card.name_en);
      this.translations.push(data.card.name_ru);
    }
   }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  dismiss() {
    this.translations = [];
    this.card = null;
    this.dialogRef.close();
  }

  getCardTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.card.name_pl = response.translation.name_pl;
      this.card.name_en = response.translation.name_en;
      this.card.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  updateCard() {
    this.isSaving = true;
    this.card.name_pl = this.translations[0];
    this.card.name_en = this.translations[1];
    this.card.name_ru = this.translations[2];
    console.log(this.card);
    this.portfolioService.updateCard(this.card).subscribe(data => {
      this.isSaving = false;
      this.dialogRef.close(data);
    });
  }

}
