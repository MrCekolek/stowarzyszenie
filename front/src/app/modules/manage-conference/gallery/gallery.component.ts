import { Component, EventEmitter, OnInit } from '@angular/core';
import { NgxGalleryOptions, NgxGalleryImage, NgxGalleryAnimation, NgxGalleryLayout } from 'ngx-gallery';
import { ManageConferenceApiService } from "../../../core/http/manage-conference-api.service";
import { AlertModel } from "../../../shared/models/alert.model";
import 'hammerjs';
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
    selector: 'app-gallery',
    templateUrl: './gallery.component.html',
    styleUrls: ['./gallery.component.scss']
})

export class GalleryComponent implements OnInit {

    private conference;
    private loading;
    private images = [];
    private deleting = false;
    private imagesDeletingIds = [];
    private alert;
    private galleryOptions;
    private galleryImages = [];

    constructor(
        private conferenceApi: ManageConferenceApiService,
        private userProvider: UserProviderService
    ) {
    }

    ngOnInit(): void {
        this.loading = true;

        this.conferenceApi.getConference().subscribe(
            (res) => {
                this.conference = res.conference;

                if (this.conference && this.conference.id) {
                    for (let i = 0; i < this.conference.conference_galleries.length; i++) {
                        this.galleryImages.push({
                            id: this.conference.conference_galleries[i].id,
                            small: this.conference.conference_galleries[i].file,
                            medium: this.conference.conference_galleries[i].file,
                            big: this.conference.conference_galleries[i].file,
                        });
                    }
                }
            },
            () => {
            },
            () => {
                this.loading = false;
            }
        );

        this.galleryOptions = [
            {
                width: '70%',
                height: '600px',
                thumbnailsColumns: 4,
                imageAnimation: NgxGalleryAnimation.Slide,
                imageSwipe: true,
                imageArrowsAutoHide: true,
                previewCloseOnEsc: true,
                previewKeyboardNavigation: true,
                previewZoom: true,
                previewRotate: true,
                previewCloseOnClick: true,
                previewFullscreen: true,
                previewSwipe: true,
                thumbnailsSwipe: true
            },
            // max-width 800
            {
                breakpoint: 800,
                width: '70%',
                height: '600px',
                imagePercent: 80,
                thumbnailsPercent: 20,
                thumbnailsMargin: 20,
                thumbnailMargin: 20
            },
            // max-width 400
            {
                breakpoint: 400,
                preview: false
            }
        ];
    }

    changeDeleting() {
        this.deleting = !this.deleting;
    }

    removeSelected() {
        this.loading = true;

        this.conferenceApi.destroyMultiGalleries(this.imagesDeletingIds, this.conference.id).subscribe(
            (res) => {
                if (res.success) {
                    this.conference.conference_galleries = res.conferenceGalleries;

                    for (let i = 0; i < this.imagesDeletingIds.length; i++) {
                        this.galleryImages.splice(this.galleryImages.findIndex(item => item.id === this.imagesDeletingIds[i]), 1);
                    }

                    this.imagesDeletingIds = [];

                    this.alert = new AlertModel('success', res.message);
                } else {
                    this.alert = new AlertModel('danger', res.message);
                }
            },
            () => {},
            () => {
                this.loading = false;
            }
        )
    }

    changeImagesDeleting(id) {
        const index = this.imagesDeletingIds.indexOf(id);

        if (index != -1) {
            this.imagesDeletingIds.splice(index, 1);
        } else {
            this.imagesDeletingIds.push(id);
        }
    }

    previewOpen() {
        document.getElementById('sidebar-wrapper-parent').style.zIndex = '-1';
        document.getElementById('main-navbar').style.zIndex = '-1';
    }

    previewClose() {
        document.getElementById('sidebar-wrapper-parent').style.zIndex = '890';
        document.getElementById('main-navbar').style.zIndex = '890';
    }
}
