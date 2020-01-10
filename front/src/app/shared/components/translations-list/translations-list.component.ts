import { Component, OnInit , Input} from '@angular/core';
import { LanguageService } from '../../services/user/language.service';

@Component({
  selector: 'app-translations-list',
  templateUrl: './translations-list.component.html',
  styleUrls: ['./translations-list.component.scss']
})
export class TranslationsListComponent implements OnInit {

  @Input() translations: any;

  constructor(
    private languageService: LanguageService
  ) { }

  ngOnInit() {
  }

  trackByFn(index: any, item: any) {
    return index;
  }
}
