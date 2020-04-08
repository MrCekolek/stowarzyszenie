import { Component, OnInit } from '@angular/core';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { ActivatedRoute, Router } from '@angular/router';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';

@Component({
  selector: 'app-confpage-edit',
  templateUrl: './confpage-edit.component.html',
  styleUrls: ['./confpage-edit.component.scss']
})
export class ConfpageEditComponent implements OnInit {

  private subpage;
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

subpageID: number;

private page;
private pageLoading;

htmlContentPl;
htmlContentEn;
htmlContentRu;

constructor(
  private route: ActivatedRoute,
  private conferenceApi: ManageConferenceApiService,
  private router: Router
) {}


//TODO: czy podstrony konferencji nie maja statusow???
ngOnInit() {
  this.pageLoading = true;
  this.subpageID = Number.parseInt(this.route.snapshot.paramMap.get('id'));
  const link = {
    id: this.subpageID
  };

  this.conferenceApi.getSubpage(link).subscribe(res => {
    console.log(res);
    this.subpage = res.conferencePage;
    this.pageLoading = false;
  });
}

saveAsDraft() {
  this.subpage.status = 'in progress';

  // this.navigationApi.updateHomeLink(this.page).subscribe(res => {
  //   if (res.success) {
  //     const index = this.navigationService.homepagesList.findIndex(item => item.id === res.homeNavigation.id);

  //     this.navigationService.homepagesList[index] = res.homeNavigation;

  //     this.router.navigate(['pages/homepages']);
  //   }
  // });
}

  publishPage() {
    this.subpage.status = 'published';
    
    // this.navigationApi.updateHomeLink(this.page).subscribe(res => {
    //   if (res.success) {
    //       const index = this.navigationService.homepagesList.findIndex(item => item.id === res.homeNavigation.id);
    
    //       this.navigationService.homepagesList[index] = res.homeNavigation;
    
    //       this.router.navigate(['pages/homepages']);
    //     }
    //   });
    // }
  }
}