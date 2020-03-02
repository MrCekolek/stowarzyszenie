import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';

@Component({
  selector: 'app-options-list',
  templateUrl: './options-list.component.html',
  styleUrls: ['./options-list.component.scss']
})
export class OptionsListComponent implements OnInit {

  @Input() options = [];
  @Input() type: 'new' | 'edit';
  lang;
  optionAddLoading = false;

  deleteLoading;
  @Output() newOptionEv = new EventEmitter<Object>();

  constructor(
    private languageService: LanguageService,
    private apiService: ApiService,
    private portfolioApiService: PortfolioApiService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });
  }

  addOption(optionName) {
    this.optionAddLoading = true;

    //get translations
    const obj = {
      name: optionName
    };

    let newOption = {
      id: 0,
      value_pl: '',
      value_en: '',
      value_ru: ''
    };

    this.apiService.post('translation/get', obj).subscribe(response => {
      newOption.value_pl = response.translation.name_pl;
      newOption.value_en = response.translation.name_en;
      newOption.value_ru = response.translation.name_ru;

      // this.options.push(newOption);
      this.newOptionEv.emit(newOption);
      this.optionAddLoading = false;
    });

  }

  deleteOptionFromView(option) {
    this.deleteLoading = true;
    const index = this.options.indexOf(option);
    if (index > -1) {
      this.options.splice(index, 1);
    }
    this.deleteLoading = false;
  }

  deleteOptionFromServer(option) {
    this.portfolioApiService.deleteContentFromCardContent(option).subscribe(response => {
      console.log(response);
    });
  }
}
