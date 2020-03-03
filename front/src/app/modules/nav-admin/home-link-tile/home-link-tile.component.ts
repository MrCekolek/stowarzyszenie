import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-home-link-tile',
  templateUrl: './home-link-tile.component.html',
  styleUrls: ['./home-link-tile.component.scss']
})
export class HomeLinkTileComponent implements OnInit {

  @Input() link;
  @Input() lang;

  constructor() { }

  ngOnInit() {
  }

}
