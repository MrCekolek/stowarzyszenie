import { Component, OnInit, Input } from '@angular/core';
import { ApiService } from 'src/app/core/http/api.service';
import { throwMatDialogContentAlreadyAttachedError } from '@angular/material';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-content-options',
  templateUrl: './content-options.component.html',
  styleUrls: ['./content-options.component.scss']
})
export class ContentOptionsComponent implements OnInit {

  @Input() selectedContent: string;
  @Input() card;
  translations = [];
  private translateLoading: boolean = false;
  lang: string;

  private newContent = {
    id: 0,
    shared_id: 0,
    name_pl: '',
    name_en: '',
    name_ru: '',
    type: '',
    tile_id: 0,  
    tile_shared_id: 0
  };

  constructor(
    private apiService: ApiService,
    private portfolioApi: PortfolioApiService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  getTitleTranslations(input) {
    const obj = {
      name: input
    };

    this.translateLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      // this.card.name_pl = response.translation.name_pl;
      // this.card.name_en = response.translation.name_en;
      // this.card.name_ru = response.translation.name_ru;

      this.translateLoading = false;
    });
  }

  addNewContent() {
    this.newContent = {
      id: 0,
      shared_id: 0,
      name_pl: this.translations[0],
      name_en: this.translations[1],
      name_ru:  this.translations[2],
      type: this.selectedContent,
      tile_id: this.card.id,  
      tile_shared_id: this.card.shared_id
    };

    this.portfolioApi.addNewContentToCard(this.newContent).subscribe(response => {
      console.log(response);
    });
  }
}
