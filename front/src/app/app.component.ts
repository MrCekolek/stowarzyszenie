import { Component, OnInit } from '@angular/core';
import { LanguageService } from "./services/language/language.service";
import { TranslateService } from "@ngx-translate/core";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit{
  title = 'front';

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

  ngOnInit() { }

  detectLang(value) {
    return this.languageService.supportedLangs.includes(value) ? value : this.translateService.getDefaultLang();
  }
}
