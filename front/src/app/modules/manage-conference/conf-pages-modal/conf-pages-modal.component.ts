import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Conflink } from 'src/app/shared/models/conflink.model';

@Component({
  selector: 'app-conf-pages-modal',
  templateUrl: './conf-pages-modal.component.html',
  styleUrls: ['./conf-pages-modal.component.scss']
})
export class ConfPagesModalComponent implements OnInit {

  pageName: string;

  private addLoading = false;
  private isSaving: boolean = false;

  private translations = [];

  private lang;

  private page: Conflink = {
    name_pl: '',
    name_en: '',
    name_ru: '',
    link: '',
    content_pl: ' ',
    content_en: ' ',
    content_ru: ' ',
    status: 'in progress',
    conference_id: ''
  };

  constructor(
    private dialogRef: MatDialogRef<ConfPagesModalComponent>,
    private languageService: LanguageService,
    private apiService: ApiService,
    private conferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(value => {
      this.lang = value;
    });

    this.conferenceApi.getConference().subscribe(res => {
      console.log(res);
      this.page.conference_id = res.conference.id;
    });
  }

  dismiss() {
    this.translations = [];
    this.pageName = '';
    this.dialogRef.close();
  }

  getTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      this.translations[0] = response.translation.name_pl;
      this.translations[1] = response.translation.name_en;
      this.translations[2] = response.translation.name_ru;

      this.page.name_pl = response.translation.name_pl;
      this.page.name_en = response.translation.name_en;
      this.page.name_ru = response.translation.name_ru;

      this.addLoading = false;
    });
  }

  addPage() {
    this.isSaving = true;
    this.page.link = this.page.name_en;

    this.conferenceApi.addConfpage(this.page).subscribe(
      (res) => {
        console.log(res);
        this.dialogRef.close(res);
      }
    );
  }

}
