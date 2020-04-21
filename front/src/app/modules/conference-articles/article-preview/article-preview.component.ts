import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ApiService } from 'src/app/core/http/api.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';

@Component({
  selector: 'app-article-preview',
  templateUrl: './article-preview.component.html',
  styleUrls: ['./article-preview.component.scss']
})
export class ArticlePreviewComponent implements OnInit {

  private article;
  private lang;

  constructor(
    private dialogRef: MatDialogRef<ArticlePreviewComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private apiService: ApiService
  ) {
    if (data.article) {
      this.article = data.article;
    }

    if (data.lang) { 
      this.lang = data.lang;
    }
   }

  ngOnInit() {
  }

  dismiss() {
    this.dialogRef.close();
  }
}
