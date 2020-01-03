import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from '../../../shared/services/user/language.service';
import { Interest } from '../../../shared/models/interest.model';
import { InterestsService } from '../../../core/services/interests.service';
import { ApiService } from '../../../core/http/api.service';

@Component({
  selector: 'app-interest-modal',
  templateUrl: './interest-modal.component.html',
  styleUrls: ['./interest-modal.component.scss']
})
export class InterestModalComponent implements OnInit {

  modal_type: string;
  interestName: string;

  private interest: Interest = {
    id: 0,
    name_pl: '',
    name_en: '',
    name_ru: '',
    is_selected: null,
    deleteLoading: false
  };
  
  private addLoading = false;
  private isSaving: boolean = false;

  private translations = [];

  private lang;
  private response;

  constructor(
    private dialogRef: MatDialogRef<InterestModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private interestsService: InterestsService,
    private apiService: ApiService
  ) {
    this.modal_type = data.modal_type;

    if (data.interest) {
      this.interest = data.interest;

      this.translations.push(data.interest.name_pl);
      this.translations.push(data.interest.name_en);
      this.translations.push(data.interest.name_ru);
    }
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });
  }

  dismiss() {
    this.translations = [];
    this.interestName = '';
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

      this.interest.name_pl = response.translation.name_pl;
      this.interest.name_en = response.translation.name_en;
      this.interest.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  addInterest() {
    this.interestsService.addNewInterest(this.interest).subscribe(response => {
      console.log(response);
    });

    // this.dialogRef.close(this.response);
  }

  updateInterest() {
    this.isSaving = true;
    this.interest.name_pl = this.translations[0];
    this.interest.name_en = this.translations[1];
    this.interest.name_ru = this.translations[2];
    this.interestsService.updateInterest(this.interest).subscribe(data => {
      this.isSaving = false;
      this.dialogRef.close(data);
    });
  }

  trackByFn(index: any, item: any) {
    return index;
  }
}
