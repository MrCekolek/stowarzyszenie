import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';

@Component({
  selector: 'app-committee',
  templateUrl: './committee.component.html',
  styleUrls: ['./committee.component.scss']
})
export class CommitteeComponent implements OnInit {

  private pcmembers = [];
  private conference_id;

  constructor(
    private conferenceApi: ManageConferenceApiService
  ) { }

  ngOnInit() {
    this.conferenceApi.getConference().subscribe(res => {
      this.conference_id = res.conference.id;
    });
  }

  addPC() {
    
  }
}
