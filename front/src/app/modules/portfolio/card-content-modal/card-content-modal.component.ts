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
    type: '',
    tile_id: 0,  
    tile_shared_id: 0
  };

  translateLoading = false;
  addLoading = false;
  translations = [];

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

  ngOnInit() {

  }

  dismiss() {
    this.translations = [];
    this.selectedType = '';
    this.dialogRef.close();
  }

  addNewContent() {
    this.isSaving = true;

    this.newContent = {
      id: 0,
      shared_id: 0,
      name_pl: this.translations[0],
      name_en: this.translations[1],
      name_ru: this.translations[2],
      type: this.selectedType,
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

  translate(input) {
    const obj = {
      name: input
    };

    this.translateLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.translateLoading = false;
    });
  }

}
