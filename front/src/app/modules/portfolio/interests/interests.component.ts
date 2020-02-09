import { Component, OnInit, Input } from '@angular/core';
import { InterestsApiService } from 'src/app/core/http/interests-api.service';

@Component({
  selector: 'app-interests',
  templateUrl: './interests.component.html',
  styleUrls: ['./interests.component.scss']
})
export class InterestsComponent implements OnInit {

  interests: any = [];
  @Input() owner: boolean;
  @Input() lang: string;
  @Input() role: string;

  constructor(
    private interestsApiService: InterestsApiService
  ) { }

  // TODO: pobrac interesty dla użytkownika
  ngOnInit() {
    this.interestsApiService.getAllInterests().subscribe(res => {
      console.log(res);
      if (res.success) {
        this.interests = res.interests;
      }
    });

    console.log(this.role);
  }
}
