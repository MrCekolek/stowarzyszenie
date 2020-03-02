import { Component, OnInit, Input } from '@angular/core';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { MatDialog, MatDialogConfig } from '@angular/material';
import { HomepagesModalComponent } from '../homepages-modal/homepages-modal.component';

@Component({
  selector: 'app-home-links-list',
  templateUrl: './home-links-list.component.html',
  styleUrls: ['./home-links-list.component.scss']
})
export class HomeLinksListComponent implements OnInit {

  @Input() links = [];
  lang;

  constructor(
    private languageService: LanguageService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.languageService.currentLang.subscribe(lg => {
      this.lang = lg;
    });
  }

  addHomepage() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;
    const dialogRef = this.dialog.open(HomepagesModalComponent, dialogConfig);
  }
}
