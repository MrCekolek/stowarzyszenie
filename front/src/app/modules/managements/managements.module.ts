import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from "../../shared/shared.module";
import { TranslationsComponent } from './translations/translations.component';
import { ManagementsRoutingModule } from "./managements-routing.module";
import { NgxJsonViewerModule } from "ngx-json-viewer";
import { NewTranslationModalComponent } from './new-translation-modal/new-translation-modal.component';
import { FormsModule } from "@angular/forms";
import { ConfirmationDialogComponent } from "../../shared/components/confirmation-dialog/confirmation-dialog.component";

@NgModule({
  declarations: [TranslationsComponent, NewTranslationModalComponent],
    imports: [
        CommonModule,
        SharedModule,
        ManagementsRoutingModule,
        NgxJsonViewerModule,
        FormsModule
    ],
    entryComponents: [NewTranslationModalComponent, ConfirmationDialogComponent],
    providers: []
})
export class ManagementsModule { }
