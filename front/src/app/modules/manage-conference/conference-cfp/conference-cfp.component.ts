import { Component, OnInit } from '@angular/core';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Cfp } from 'src/app/shared/models/cfp.model';

@Component({
  selector: 'app-conference-cfp',
  templateUrl: './conference-cfp.component.html',
  styleUrls: ['./conference-cfp.component.scss']
})
export class ConferenceCfpComponent implements OnInit {

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
    
  private cfp: Cfp = {
    file: '',
    content_pl: '',
    content_en: '',
    content_ru: '',
    conference_id: '',
  };
  
  private conference;
  private loading;
  private added;

  constructor(
    private manageConferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.manageConferenceApi.getConference().subscribe(res => {
      this.conference = res.conference;
      this.cfp.conference_id = res.conference.id;

      const conf = {
        id: res.conference.id
      };
      this.manageConferenceApi.getCFP(conf).subscribe(res => {
        console.log(res);
        this.cfp = res.conferences.conference_cfp;
        if (this.cfp) {
          this.added = true;
        }
      });
    });
  }

  addCFP() {
    this.loading = true;
    this.manageConferenceApi.addCFP(this.cfp).subscribe(res => {
      console.log(res);
      if (res.success) {
        this.added = true;
      }
      this.loading = false;
    });
  }
}
