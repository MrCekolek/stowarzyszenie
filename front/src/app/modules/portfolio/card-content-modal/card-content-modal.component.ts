import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from '../../../core/http/api.service';
import { ContentTypes } from '../../../shared/models/content-types';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';

@Component({
  selector: 'app-card-content-modal',
  templateUrl: './card-content-modal.component.html',
  styleUrls: ['./card-content-modal.component.scss']
})
export class CardContentModalComponent implements OnInit {

  private modal_type;
  private card;
  private selectedType;
  isSaving = false;
  private types = [
    {
      label: 'input',
      key: 'STOWARZYSZENIE.MODULES.PORTFOLIO.CONTENT.TYPE_DESC.INPUT'
    },
    {
      label: 'textarea',
      key: 'STOWARZYSZENIE.MODULES.PORTFOLIO.CONTENT.TYPE_DESC.TEXTAREA'
    },
    {
      label: 'checkbox',
      key: 'STOWARZYSZENIE.MODULES.PORTFOLIO.CONTENT.TYPE_DESC.CHECKBOX'
    }
    // 'select',
    // 'radio'
  ];

  private newContent = {
    id: 0,
    shared_id: 0,
    name_pl: '',
    name_en: '',
    name_ru: '',
    admin_visibility: 1,
    user_visibility: 1,
    type: '',
    options: [],
    tile_id: 0,  
    tile_shared_id: 0
  };

  titleLoading = false;
  translateLoading = false;
  addLoading = false;
  titleTranslations = [];
  newOptionTranslations = [];
  contents = [];

  constructor(
    private dialogRef: MatDialogRef<CardContentModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private apiService: ApiService,
    private portfolioApiService: PortfolioApiService
  ) {
    this.modal_type = data.modal_type;

    if (data.card) {
      this.card = data.card;
    }
  }

  ngOnInit() { }

  dismiss() {
    this.titleTranslations = [];
    this.newOptionTranslations = [];
    this.selectedType = '';
    this.dialogRef.close();
  }

  addNewContent() {
    this.isSaving = true;

    this.newContent = {
      id: 0,
      shared_id: 0,
      name_pl: this.titleTranslations[0],
      name_en: this.titleTranslations[1],
      name_ru: this.titleTranslations[2],
      admin_visibility: 1,
      user_visibility: 1,
      type: this.selectedType,
      options: this.contents,
      tile_id: this.card.id,  
      tile_shared_id: this.card.shared_id
    };

    this.portfolioApiService.addNewContentToCard(this.newContent).subscribe(response => {
      if (response.success) {
        this.isSaving = false;
        this.dialogRef.close(response.tileContent);
      }
    });
  }

  getNewOption(option) {
    this.contents.push(option);
  }

  translate(input, type) {
    const obj = {
      name: input
    };

    if (type === 'title') {
      this.titleLoading = true;
    } else if (type === 'option') {
      this.translateLoading = true;
    }

    this.apiService.post('translation/get', obj).subscribe(response => {
      if (type === 'title') {
        this.titleTranslations[0] = response.translation.name_pl;
        this.titleTranslations[1] = response.translation.name_en;
        this.titleTranslations[2] = response.translation.name_ru;

        this.titleLoading = false;
      } else if (type === 'option') {
        this.newOptionTranslations[0] = response.translation.name_pl;
        this.newOptionTranslations[1] = response.translation.name_en;
        this.newOptionTranslations[2] = response.translation.name_ru;

        const obj = {
          id: 0,
          shared_id: 0,
          value_pl: this.newOptionTranslations[0],
          value_en: this.newOptionTranslations[1],
          value_ru: this.newOptionTranslations[2],
          selected: false,
          position: 0,
          admin_visibility: true,
          user_visibility: true,
          tile_content_id: 0,
          tile_content_shared_id: 0
        };

        this.contents.push();

        this.translateLoading = false;
      }
    });
  }
}
