import {Component, OnInit} from '@angular/core';
import {AngularEditorConfig} from '@kolkov/angular-editor';
import {ActivatedRoute, Router} from '@angular/router';
import {ManageConferenceApiService} from 'src/app/core/http/manage-conference-api.service';
import {AlertModel} from "../../../shared/models/alert.model";

@Component({
    selector: 'app-confpage-edit',
    templateUrl: './confpage-edit.component.html',
    styleUrls: ['./confpage-edit.component.scss']
})
export class ConfpageEditComponent implements OnInit {

    private alert: AlertModel;
    private subpage;
    private isPublishing;
    private isDrafting;
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

    private pageLoading;

    htmlContentPl;
    htmlContentEn;
    htmlContentRu;

    constructor(
        private route: ActivatedRoute,
        private conferenceApi: ManageConferenceApiService,
        private router: Router
    ) {
    }

    ngOnInit() {
        this.pageLoading = true;

        this.subpageID = Number.parseInt(this.route.snapshot.paramMap.get('id'));

        const link = {
            id: this.subpageID
        };

        this.conferenceApi.getSubpage(link).subscribe(
            (res) => {
                this.subpage = res.conferencePage;
            },
            () => {
            },
            () => {
                this.pageLoading = false;
            }
        );
    }

    saveAsDraft() {
        this.isDrafting = true;
        this.subpage.status = 'in progress';

        this.conferenceApi.updateConfpage(this.subpage).subscribe(
            (res) => {
                if (res.success) {
                    this.subpage = res.conferencePage;
                    this.alert = new AlertModel('success', res.message);
                } else {
                    this.alert = new AlertModel('danger', res.message);
                }
            },
            () => {},
            () => {
                this.isDrafting = false;
            }
        );
    }

    publishPage() {
        this.isPublishing = true;
        this.subpage.status = 'published';

        this.conferenceApi.updateConfpage(this.subpage).subscribe(
            (res) => {
                if (res.success) {
                    this.subpage = res.conferencePage;
                    this.alert = new AlertModel('success', res.message);
                } else {
                    this.alert = new AlertModel('danger', res.message);
                }
            },
            () => {},
            () => {
                this.isPublishing = false;
            }
        );
    }
}
