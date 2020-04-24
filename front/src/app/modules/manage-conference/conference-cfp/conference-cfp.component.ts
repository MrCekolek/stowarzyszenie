import { Component, OnInit } from '@angular/core';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { Cfp } from 'src/app/shared/models/cfp.model';
import { AlertModel } from "../../../shared/models/alert.model";
import { UserProviderService } from 'src/app/core/services/user-provider.service';

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
  fileToUpload: File = null;
  private fileChanged;

  constructor(
    private manageConferenceApi: ManageConferenceApiService,
    private userProvider: UserProviderService
  ) { }

  ngOnInit() {
    this.loading = true;

    this.fileChanged = false;

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
    const formData: FormData = new FormData();

    if (this.fileChanged) {
      formData.append('new_file', this.fileToUpload, this.fileToUpload.name);
    }

    for (var key in this.conference.conference_cfp) {
      formData.append(key, this.conference.conference_cfp[key]);
    }

    formData.append('token', localStorage.getItem('token'));

    this.manageConferenceApi.updateCFP(formData).subscribe(
      (res) => {
        if (res.success) {
          this.conference.conference_cfp = res.conferenceCfp;

          this.fileChanged = false;

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

  handleFileInput(files: FileList) {
    this.fileChanged = true;
    this.fileToUpload = files.item(0);
    this.conference.conference_cfp.file_name = this.fileToUpload.name;
  }
}
