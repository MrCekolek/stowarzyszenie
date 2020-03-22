import { Component, OnInit, Input } from '@angular/core';
import { InterestsApiService } from 'src/app/core/http/interests-api.service';

@Component({
  selector: 'app-interests',
  templateUrl: './interests.component.html',
  styleUrls: ['./interests.component.scss']
})
export class InterestsComponent implements OnInit {

  interests: any = [];
  interestUsers: any = [];
  @Input() owner: boolean;
  @Input() userID: number;
  @Input() lang: string;
  @Input() role: string;
  @Input() preview: boolean;
  @Input() portfolio: boolean;

  constructor(
    private interestsApiService: InterestsApiService
  ) { }

  ngOnInit() {
    this.interestsApiService.getUserInterests(this.userID).subscribe(res => {
      if (res.success) {
        this.interests = res.interests;
        this.interestUsers = res.interestUsers;
      }
    });
  }

  markInterest(interest, input) {
    if (input) {
      this.interestsApiService.createInterestUser(this.userID, interest.id).subscribe(res => {
        if (res.success) {
          this.interestUsers.push(res.interestUser);
        }
      });
    } else {
      this.interestsApiService.deleteInterestUser(this.userID, interest.id).subscribe(res => {
        if (res.success) {
          const index = this.interestUsers.findIndex(item => item.id === interest.id);

          this.interestUsers.slice(index, 1);
        }
      });
    }
  }

  interestChecked(interest) {
    var isChecked = false;

    for (let i = 0; i < interest.users.length; i++) {
      if (interest.users[i].id == this.userID) {
        isChecked = true;

        break;
      }
    }

    return isChecked;
  }
}
