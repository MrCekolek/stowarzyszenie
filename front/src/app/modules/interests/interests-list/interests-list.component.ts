import { Component, OnInit } from '@angular/core';
import { InterestsService } from 'src/app/core/services/interests.service';
import { Observable, Observer } from 'rxjs';

@Component({
  selector: 'app-interests-list',
  templateUrl: './interests-list.component.html',
  styleUrls: ['./interests-list.component.scss']
})
export class InterestsListComponent implements OnInit {

  allInterests: any = [];

  constructor(
    private interestsService: InterestsService
  ) { }

  ngOnInit() {
    this.interestsService.getInterests().subscribe( value => {
      this.allInterests = value;
      console.log(this.allInterests);
    });
  }

  ngOnDestroy() {
  }

  addNewInterest(newInterestName: string) {
     this.interestsService.addNewInterest(newInterestName).subscribe(response => {
       console.log(response);
     });
  }
}
