import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TranslateModule, TranslateLoader, TranslateService } from '@ngx-translate/core';
import { HttpClientModule, HttpClient } from '@angular/common/http';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatButtonModule } from '@angular/material/button';
import { LanguageService } from "./services/user/language.service";
import { MatTableModule } from '@angular/material/table';
import { MatFormFieldModule, MatIconModule, MatPaginatorModule, MatSortModule, MATERIAL_SANITY_CHECKS } from "@angular/material";
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatDialogModule } from "@angular/material";
import { SpinnerComponent } from './components/spinner/spinner.component';
import { DeleteAlertComponent } from './components/delete-alert/delete-alert.component';
import { AlertComponent } from './components/alert/alert.component'; 
import { OverlayModule } from '@angular/cdk/overlay';
import { LangPipe } from './pipes/lang.pipe';

export function HttpLoaderFactory (http: HttpClient) {
  return new TranslateHttpLoader(http, './assets/i18n/', '.json');
}

@NgModule({
  declarations: [SpinnerComponent, DeleteAlertComponent, AlertComponent, LangPipe],
  imports: [
    CommonModule,
    HttpClientModule,
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: (HttpLoaderFactory),
        deps: [ HttpClient ]
      }
    }),
    MatTooltipModule,
    MatButtonModule,
    MatTableModule,
    MatIconModule,
    MatPaginatorModule,
    MatSortModule,
    MatFormFieldModule,
    FormsModule,
    ReactiveFormsModule,
    MatDialogModule,
    OverlayModule
  ],
  exports: [
    CommonModule,
    TranslateModule,
    MatTableModule,
    MatIconModule,
    MatPaginatorModule,
    MatSortModule,
    MatFormFieldModule,
    AlertComponent,
    MatDialogModule,
    OverlayModule
  ],
  providers: [
    {
      provide: MATERIAL_SANITY_CHECKS,
      useValue: false
    }
  ]
})

export class SharedModule {

  constructor(
    private languageService: LanguageService,
    public translateService: TranslateService
  ) {
    this.translateService.addLangs(this.languageService.supportedLangs);
    this.translateService.setDefaultLang('en');
    this.languageService.currentLang.subscribe(
      value => this.translateService.use(this.detectLang(value))
    );
   }

  detectLang(value) {
    return this.languageService.supportedLangs.includes(value) ? value : this.translateService.getDefaultLang();
  }
}
