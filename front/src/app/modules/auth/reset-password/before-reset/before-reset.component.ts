import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-before-reset',
  templateUrl: './before-reset.component.html',
  styleUrls: ['./before-reset.component.scss']
})
export class BeforeResetComponent implements OnInit {

  private resetSend = false;

  constructor() { }

  ngOnInit() {
  }

  sendReset() {
    this.resetSend = !this.resetSend;
  }
}
