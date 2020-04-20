import { Component, OnInit } from '@angular/core';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Cfp } from 'src/app/shared/models/cfp.model';
import { AlertModel } from "../../../shared/models/alert.model";

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
    id: '',
    file_name: '',
    file: '',
    content_pl: '',
    content_en: '',
    content_ru: '',
    conference_id: ''
  };
  
  private conference;
  private loading;
  private updating;
  private alert;

  constructor(
    private manageConferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.manageConferenceApi.getConference().subscribe(
        (res) => {
          this.conference = res.conference;
        },
        () => {},
        () => {
          this.loading = false;
        }
      );
  }

  addCFP() {
    this.loading = true;

    this.cfp.conference_id = this.conference.id;

    this.manageConferenceApi.addCFP(this.cfp).subscribe(res => {
      if (res.success) {
        this.conference.conference_cfp = res.conferenceCfp;
      }

      this.loading = false;
    });
  }

  updateCfp() {
    this.updating = true;

    this.manageConferenceApi.updateCFP(this.conference.conference_cfp).subscribe(
      (res) => {
        if (res.success) {
          this.conference.conference_cfp = res.conferenceCfp;

          this.alert = new AlertModel('success', res.message);
        } else {
          this.alert = new AlertModel('danger', res.message);
        }
      },
      () => {},
      () => {
        this.updating = false;
      }
    );
  }
}
