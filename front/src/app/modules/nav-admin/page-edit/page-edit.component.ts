import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';
import {NavigationService} from "../../../core/services/navigation.service";

@Component({
  selector: 'app-page-edit',
  templateUrl: './page-edit.component.html',
  styleUrls: ['./page-edit.component.scss']
})
export class PageEditComponent implements OnInit {

  editorConfig: AngularEditorConfig = {
      editable: true,
      spellcheck: true,
      height: 'auto',
      minHeight: '0',
      maxHeight: 'auto',
      width: 'auto',
      minWidth: '0',
      translate: 'yes',
      enableToolbar: true,
      showToolbar: true,
      placeholder: 'Enter text here...',
      defaultParagraphSeparator: '',
      defaultFontName: '',
      defaultFontSize: '',
      fonts: [
        {class: 'arial', name: 'Arial'},
        {class: 'times-new-roman', name: 'Times New Roman'},
        {class: 'calibri', name: 'Calibri'},
        {class: 'comic-sans-ms', name: 'Comic Sans MS'}
      ],
      customClasses: [
      {
        name: 'quote',
        class: 'quote',
      },
      {
        name: 'redText',
        class: 'redText'
      },
      {
        name: 'titleText',
        class: 'titleText',
        tag: 'h1',
      },
    ],
    uploadUrl: 'http://stowarzyszenie.test/api/image/upload',
    uploadWithCredentials: false,
    sanitize: false,
    toolbarPosition: 'top',
    toolbarHiddenButtons: [
      ['bold', 'italic'],
      ['fontSize']
    ]
  };

  pageId: number;

  private page;
  private pageLoading;
  private saving;
  private savingDraft;

  constructor(
    private route: ActivatedRoute,
    private navigationApi: NavigationApiService,
    private router: Router,
    private navigationService: NavigationService
  ) {}

  ngOnInit() {
    this.pageLoading = true;
    this.pageId = Number.parseInt(this.route.snapshot.paramMap.get('id'));

    const link = {
      id: this.pageId
    };

    this.navigationApi.getHomeLink(link).subscribe(
        (res) => {
          this.page = res.homeNavigation;
        },
        () => {},
        () => {
            this.pageLoading = false;
        }
    );
  }

  saveAsDraft() {
    this.savingDraft = true;
    this.page.status = 'in progress';

    this.navigationApi.updateHomeLink(this.page).subscribe(
        (res) => {
          if (res.success) {
            const index = this.navigationService.homepagesList.findIndex(item => item.id === res.homeNavigation.id);

            if (index < 0) {
                this.navigationService.homepagesList.push(res.homeNavigation);
            } else {
                this.navigationService.homepagesList[index] = res.homeNavigation;
            }

            this.router.navigate(['pages/homepages']);
          }
        },
        () => {},
        () => {
            this.savingDraft = false;
        }
    );
  }

  publishPage() {
    this.saving = true;
    this.page.status = 'published';

    this.navigationApi.updateHomeLink(this.page).subscribe(
        (res) => {
          if (res.success) {
              const index = this.navigationService.homepagesList.findIndex(item => item.id === res.homeNavigation.id);

              if (index < 0) {
                  this.navigationService.homepagesList.push(res.homeNavigation);
              } else {
                  this.navigationService.homepagesList[index] = res.homeNavigation;
              }

              this.router.navigate(['pages/homepages']);
          }
        },
        () => {},
        () => {
            this.saving = false;
        }
    );
  }
}
