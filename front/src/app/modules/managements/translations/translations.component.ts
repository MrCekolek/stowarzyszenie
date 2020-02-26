import { Component, HostListener, OnInit } from '@angular/core';
import { AlertModel } from "../../../shared/models/alert.model";
import { LanguageService } from "../../../shared/services/user/language.service";
import { MatDialog, MatDialogConfig } from "@angular/material";
import { TranslationsApiService } from "../../../core/http/translations-api.service";
import { NewTranslationModalComponent } from "../new-translation-modal/new-translation-modal.component";
import { ConfirmationDialogComponent } from 'src/app/shared/components/confirmation-dialog/confirmation-dialog.component';

@Component({
  selector: 'app-translations',
  templateUrl: './translations.component.html',
  styleUrls: ['./translations.component.scss']
})
export class TranslationsComponent implements OnInit {

  private alert: AlertModel;
  private lang;
  private translations: any;
  private loading: boolean = true;

  constructor(
      private translationsApiService: TranslationsApiService,
      private dialog: MatDialog,
      private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });
    this.translationsApiService.getTranslations().subscribe(
      (data) => {
        this.translations = data['translations'];
      },
      (err) => {},
      () => {
        this.loading = false;
      }
    );
  }

  toggle() {
    let sectionsSegmentMain = document.querySelectorAll('section.segment-main.expandable.expanded, section.segment-main.expandable');

    for (let i = 0; i < sectionsSegmentMain.length; i++) {
      let addExists = false;
      let editExists = false;
      let deleteExists = false;

      for (let j = 0; j < sectionsSegmentMain[i].childNodes.length; j++) {
        // @ts-ignore
        if (sectionsSegmentMain[i].childNodes[j].className === 'segment-add') {
          addExists = true;
        }

        // @ts-ignore
        if (sectionsSegmentMain[i].childNodes[j].className === 'segment-edit') {
          editExists = true;
        }

        // @ts-ignore
        if (sectionsSegmentMain[i].childNodes[j].className === 'segment-delete') {
          deleteExists = true;
        }
      }

      if (!addExists) {
        if (isSegmentObjectType(sectionsSegmentMain[i])) {
          let node = addNode(sectionsSegmentMain[i],'segment-add', '<i class="fas fa-plus"></i> ', showNewModal, 'add');
          sectionsSegmentMain[i].appendChild(node);
        }
      }

      if (!editExists) {
        if (!isSegmentObjectType(sectionsSegmentMain[i])) {
          let node = addNode(sectionsSegmentMain[i],'segment-edit', '<i class="fas fa-pencil-alt"></i> ', showEditModal, 'edit');
          sectionsSegmentMain[i].appendChild(node);
        }
      }

      if (!deleteExists) {
        let node = addNode(sectionsSegmentMain[i],'segment-delete', '<i class="fas fa-minus"></i> ', showDeleteModal, 'delete');
        sectionsSegmentMain[i].appendChild(node);
      }

      function isSegmentObjectType(section) {
        return section.parentNode.className === 'segment segment-type-object' || section.parentNode.className === 'segment segment-type-object ng-star-inserted';
      }

      function addNode(sectionsSegmentMain, nodeClassName, nodeInnerHTML, showModal, modalType) {
        var node = document.createElement("span");
        node.className = nodeClassName;
        node.innerHTML = nodeInnerHTML;

        node.addEventListener('click', function (event) {
          event.stopPropagation();
          // @ts-ignore
          var parent = event.target.parentNode;
          var complete = false;
          var translationKey = [];

          do {
            if (parent.className === 'card-body example-container') {
              complete = true;
            }

            if (!complete) {
              if (parent.className === 'segment segment-type-object ng-star-inserted' ||
                  parent.className === 'segment segment-type-array ng-star-inserted' ||
                  parent.className === 'segment segment-type-object' ||
                  parent.className === 'segment segment-type-array') {
                if (parent.children.length > 0) {
                  var expandedChild = parent.children[0];
                  var keyChild = expandedChild.children[1].innerHTML;
                  translationKey.unshift(keyChild);
                }
              }

              parent = parent.parentNode;
            }
          } while (!complete);

          if (modalType === 'add' || modalType === 'delete') {
            showModal(translationKey.join('.'));
          } else {
            showModal(translationKey);
          }
        }, false);

        return node;
      }
    }

    function showNewModal(translationKey) {
      var event = new CustomEvent('showNewModal', {
        detail: {
          translationKey: translationKey
        }
      });

      window.dispatchEvent(event);
    }

    function showEditModal(translationKey) {
      var event = new CustomEvent('showEditModal', {
        detail: {
          translationKey: translationKey
        }
      });

      window.dispatchEvent(event);
    }

    function showDeleteModal(translationKey) {
      var event = new CustomEvent('showDeleteModal', {
        detail: {
          translationKey: translationKey
        }
      });

      window.dispatchEvent(event);
    }
  }

  @HostListener('window:showNewModal', ['$event.detail'])

  openNewTranslationModal(detail) {
    const obj  = {
      translation_key: detail['translationKey']
    };

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'new',
      translation: obj
    };

    const dialogRef = this.dialog.open(NewTranslationModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if (data) {
            if (data.success) {
              this.translations = data.translations;

              this.alert = new AlertModel('success', data.message);
            } else {
              this.alert = new AlertModel('danger', data.message);
            }
          }
        }
    );
  }

  @HostListener('window:showEditModal', ['$event.detail'])

  openEditTranslationModal(detail) {
    let translationKey = detail['translationKey'].join('.');
    let obj = this.getTranslation(this.translations, detail['translationKey']);
    obj['translation_key'] = translationKey;

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      modal_type: 'edit',
      translation: obj
    };

    const dialogRef = this.dialog.open(NewTranslationModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if (data) {
            if (data.success) {
              this.translations = data.translations;

              this.alert = new AlertModel('success', data.message);
            } else {
              this.alert = new AlertModel('danger', data.message);
            }
          }
        }
    );
  }

  getTranslation(array, translationKey) {
    let translationKeyShifted = translationKey.shift();

    if (translationKeyShifted) {
      return this.getTranslation(array[translationKeyShifted], translationKey);
    }

    return {
      translation_pl: array[0],
      translation_en: array[1],
      translation_ru: array[2]
    }
  }

  @HostListener('window:showDeleteModal', ['$event.detail'])

  deleteTranslation(detail) {
    const obj = {
      name_pl: detail['translationKey'],
      name_en: detail['translationKey'],
      name_ru: detail['translationKey']
    };

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRANSLATION.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.TRANSLATION.TEXT',
      element: obj,
      apiToDelete: `translation/destroy/${detail['translationKey']}`
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        (data) => {
          if (data) {
            if (data.success) {
              this.translations = data.translations;

              this.alert = new AlertModel('success', data.message);
            } else {
              this.alert = new AlertModel('danger', data.message);
            }
          }
        }
    );
  }
}
