import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { ReviewsApiService } from 'src/app/core/http/reviews-api.service';

@Component({
  selector: 'app-assign-reviewer-modal',
  templateUrl: './assign-reviewer-modal.component.html',
  styleUrls: ['./assign-reviewer-modal.component.scss']
})
export class AssignReviewerModalComponent implements OnInit {

  private article;
  private lang;
  private possibleReviewers = [];
  private bestReviewers = [];
  private loading;

  constructor(
    private dialogRef: MatDialogRef<AssignReviewerModalComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private languageService: LanguageService,
    private reviewsApi: ReviewsApiService
  ) {
    if (data.article) {
      this.article = data.article;
    }

    if (data.lang) { 
      this.lang = data.lang;
    }
   }

  ngOnInit() {
    // this.loading = true;
    // TODO: pobranie wszystkich recenzentow ktorzy spelniaja kryteria do przydzielenia (naleza do tracku, 
    //maja mniej niz 5 raz do zrecenzowania, maja przynajmniej jeden interest ten sam zaznaczony co artykul) -- napisac metode w ReviewsApiService

    // wybranie najlepszych recenzentow i dodanie ich do tablicy this.bestReviewers -- metoda tutaj albo w RevviewsApiService
    // this.reviewsApi.getBestReviewers().subscribe(res => {
    //   this.bestReviewers = res.best;
    //   this.loading = false;
    // });
  }

  dismiss() {
    this.dialogRef.close();
  }

  chooseReviewer(user) {
    // loading = true;
    // TODO: przypisanie recenzenta do artykulu - endpoint, metoda w reviewsApiService i wstawic tu dodawanie, 
    // jak sie wykona endpoint to robimy this.dialogRef.close(tutaj zwrocony res);
  }

}
