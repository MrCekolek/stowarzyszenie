import { Component, OnInit } from '@angular/core';
import { ManageConferenceApiService } from 'src/app/core/http/manage-conference-api.service';
import { OwlOptions } from 'ngx-owl-carousel-o';
import {MatDialog, MatDialogConfig} from "@angular/material";
import { ConferenceRoleModalComponent } from "../conference-role-modal/conference-role-modal.component";
import { AlertModel } from "../../../shared/models/alert.model";
import * as _ from 'lodash';
import {CommitteeModalComponent} from "../committee-modal/committee-modal.component";


@Component({
  selector: 'app-committee',
  templateUrl: './committee.component.html',
  styleUrls: ['./committee.component.scss']
})
export class CommitteeComponent implements OnInit {

  private loading;
  private alert: AlertModel;
  customOptions: OwlOptions = {
    loop: true,
    mouseDrag: true,
    touchDrag: false,
    pullDrag: false,
    dots: false,
    navSpeed: 700,
    navText: ['<', '>'],
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      740: {
        items: 3
      },
      940: {
        items: 4
      }
    },
    nav: true
  };

  private pcmembers = [];
  private conference_id;

  constructor(
    private conferenceApi: ManageConferenceApiService,
    private dialog: MatDialog
  ) { }

  ngOnInit() {
    this.loading = true;

    this.conferenceApi.getConference().subscribe(
      (res) => {
        this.conference_id = res.conference.id;
      },
      () => {},
      () => {
        this.conferenceApi.getPC(this.conference_id).subscribe(
            (res) => {
              if (res.success) {
                this.pcmembers = res.programmeCommittees;

                console.log(this.pcmembers);
              }
            },
            () => {},
            () => {
              this.loading = false;
            }
        )
      }
    );
  }

  addPC() {
    const dialogConfig = new MatDialogConfig();

    var originalPcMembers = _.cloneDeep(this.pcmembers);

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      user: this.pcmembers,
      conference_id: this.conference_id
    };

    const dialogRef = this.dialog.open(CommitteeModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        (data) => {
          if (data) {
            if (data.success) {
              this.pcmembers = data.programmeCommittees;
              this.alert = new AlertModel('success', data.message);
            } else {
              this.pcmembers = originalPcMembers;
              this.alert = new AlertModel('danger', data.message);
            }
          } else {
            this.pcmembers = originalPcMembers;
          }
        }
    );
  }
}
