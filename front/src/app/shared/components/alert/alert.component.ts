import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent implements OnInit {

  //danger, success, warning, info
  @Input() alertType: AlertTypes;
  @Input() message;

  constructor() { }

  ngOnInit() {
    
  }

}
