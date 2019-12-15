import { Component, OnInit, ViewChild } from '@angular/core';
import { InterestsService } from 'src/app/core/services/interests.service';
import { LanguageService } from 'src/app/shared/services/user/language.service';
import { Interest } from 'src/app/shared/models/interest.model';
import { AlertModel } from 'src/app/shared/models/alert.model';

@Component({
  selector: 'app-interests-list',
  templateUrl: './interests-list.component.html',
  styleUrls: ['./interests-list.component.scss']
})
export class InterestsListComponent implements OnInit {

  @ViewChild('newInterest', {static: false}) newInterest: any;

  allInterests: Array<Interest> = [];
  lang: any;

  private alert: AlertModel

  private loading: boolean;
  private addLoading = false;

  constructor(
    private interestsService: InterestsService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.interestsService.getInterests().subscribe( value => {
      for(const key in value.interests) {
        if (value.interests.hasOwnProperty(key)) {
          this.allInterests.push(new Interest(value.interests[key]));
        }
      };

      if (this.allInterests.length > 0) {
        this.loading = false;
      }
      console.log(this.allInterests);
    });

    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });
  }

  ngOnDestroy() {
  }

  addNewInterest(newInterestName: string) {
    this.addLoading = true;
     this.interestsService.addNewInterest(newInterestName).subscribe(response => {
       if (response.success) {
        this.alert = new AlertModel('success', response.message);
        this.allInterests.push(response.interest);
        this.newInterest.value = '';
        this.addLoading = false;
       } else {
        this.alert = new AlertModel('danger', response.message);
       }
     });
  }

  deleteInterest(id: number) {
    console.log(id);
    this.allInterests.find(i => i.id === id).deleteLoading = true;
    this.interestsService.deleteInterest(id).subscribe(response => {
      if (response.success) {
        this.alert = new AlertModel('success', response.message);
        this.allInterests.find(i => i.id === id).deleteLoading = false;
        this.allInterests.splice(this.allInterests.findIndex(item => item.id === id), 1);
      } else {
        this.alert = new AlertModel('danger', response.message);
      }
    });
  }

  enableEditing(interest) {
    interest.editing = true;
  }

  updateInterest(new_name: string, interest) {
    this.allInterests.find(i => i.id === interest.id).editing = true;
    this.allInterests.find(i => i.id === interest.id).editing_loading = true;
    this.interestsService.updateInterest(interest.id, new_name).subscribe(response => {
      console.log(response);
      if (response.success) {
        this.alert = new AlertModel('success', response.message);
        this.allInterests.find(i => i.id === interest.id).name_pl = response.interest.name_pl;
        this.allInterests.find(i => i.id === interest.id).name_en = response.interest.name_en;
        this.allInterests.find(i => i.id === interest.id).name_ru = response.interest.name_ru;
      } else {
        this.alert = new AlertModel('danger', response.message);
      }

      this.allInterests.find(i => i.id === interest.id).editing_loading = false;
      this.allInterests.find(i => i.id === interest.id).editing = false;
    });
  }
}
