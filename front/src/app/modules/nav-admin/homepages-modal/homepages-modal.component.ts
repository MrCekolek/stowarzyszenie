import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ApiService } from 'src/app/core/http/api.service';
import { HomeNavigation } from 'src/app/shared/models/home-navigation';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

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

  private page: HomeNavigation = {
    name_pl: '',
    name_en: '',
    name_ru: '',
    link: '',
    content_pl: '',
    content_en: '',
    content_ru: '',
    status: 'in progress',
    user_id: this.userService.getUser().id
  };

  constructor(
    private dialogRef: MatDialogRef<HomepagesModalComponent>,
    private languageService: LanguageService,
    private apiService: ApiService,
    private navigationApi: NavigationApiService,
    private userService: UserProviderService
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

  getTranslations(input) {
    const obj = {
      name: input
    };

    this.addLoading = true;
    this.apiService.post('translation/get', obj).subscribe(response => {
      console.log(response);
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
    this.page.link = this.page.name_en;
    console.log(this.page);

    this.navigationApi.addHomeLink(this.page).subscribe(res => {
      this.dialogRef.close(res);
    });
  }
}
