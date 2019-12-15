import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-one-tab',
  templateUrl: './one-tab.component.html',
  styleUrls: ['./one-tab.component.scss']
})
export class OneTabComponent implements OnInit {
  @Input() cards;

  constructor() { }

  ngOnInit() {
  }

}
