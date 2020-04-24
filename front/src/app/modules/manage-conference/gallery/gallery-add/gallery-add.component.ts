import { Component, EventEmitter, OnInit } from '@angular/core';
import { UploadOutput, UploadInput, UploadFile, humanizeBytes, UploaderOptions } from 'ngx-uploader';
import { ManageConferenceApiService } from "../../../../core/http/manage-conference-api.service";
import { UserProviderService } from 'src/app/core/services/user-provider.service';

@Component({
  selector: 'app-gallery-add',
  templateUrl: './gallery-add.component.html',
  styleUrls: ['./gallery-add.component.scss']
})
export class GalleryAddComponent implements OnInit {

  options: UploaderOptions;
  formData: FormData;
  files: UploadFile[];
  uploadInput: EventEmitter<UploadInput>;
  humanizeBytes: Function;
  dragOver: boolean;
  private loading: boolean;
  private conference;
  private imagePreview;

  constructor(
      private conferenceApi: ManageConferenceApiService,
      private userProvider: UserProviderService

  ) {
    this.options = { concurrency: 1, maxUploads: 100, maxFileSize: 1000000 };
    this.files = [];
    this.uploadInput = new EventEmitter<UploadInput>();
    this.humanizeBytes = humanizeBytes;
  }

  onUploadOutput(output: UploadOutput): void {
    switch (output.type) {
      case 'allAddedToQueue':
        const event: UploadInput = {
          type: 'uploadAll',
          url: 'http://stowarzyszenie.test/api/conference/gallery/create',
          method: 'POST',
          data: { token: localStorage.getItem('token'), conference_id: this.conference.id }
        };
        this.uploadInput.emit(event);

        break;
      case 'addedToQueue':
        if (typeof output.file !== 'undefined') {
          this.previewImage(output.file).then(response => {
            let file: any = Object.assign(output.file, { imagePreview: response });

            this.files.push(file);
          });
        }

        break;
      case 'uploading':
        if (typeof output.file !== 'undefined') {
          // update current data in files array for uploading file
          const index = this.files.findIndex((file) => typeof output.file !== 'undefined' && file.id === output.file.id);
          this.files[index] = output.file;
        }

        break;
      case 'removed':
        // remove file from array when removed
        this.files = this.files.filter((file: UploadFile) => file !== output.file);

        break;
      case 'dragOver':
        this.dragOver = true;

        break;
      case 'dragOut':
      case 'drop':
        this.dragOver = false;

        break;
      case 'done':
        // The file is downloaded

        break;
    }
  }

  previewImage(file: any) {
    const fileReader = new FileReader();
    return new Promise(resolve => {
      fileReader.readAsDataURL(file.nativeFile);
      fileReader.onload = function(e: any) {
        resolve(e.target.result);
      };
    });
  }

  removeFile(id: string): void {
    this.uploadInput.emit({ type: 'remove', id: id });
  }

  ngOnInit(): void {
    this.loading = true;

    this.conferenceApi.getConference().subscribe(
        (res) => {
          this.conference = res.conference;
        },
        () => {},
        () => {
          this.loading = false;
        }
    );
  }

}
