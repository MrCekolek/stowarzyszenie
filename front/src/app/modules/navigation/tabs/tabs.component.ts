import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-tabs',
  templateUrl: './tabs.component.html',
  styleUrls: ['./tabs.component.scss']
})
export class TabsComponent implements OnInit {

  @Input() tabss = [];
  @Input() lang;
  
  constructor() { }

  ngOnInit() {
  }

  selectTab(tab) {
    this.tabss.forEach((tab) => {
      tab.active = false;
    });
    tab.active = true;
  }

}
