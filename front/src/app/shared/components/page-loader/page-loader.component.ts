import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-page-loader',
  templateUrl: './page-loader.component.html',
  styleUrls: ['./page-loader.component.scss']
})
export class PageLoaderComponent implements OnInit {

  loading: boolean = false;
  loadingSubscription: Subscription;

  constructor(
  ) { }

  ngOnInit() {
  }

  ngOnDestroy() {
  }
}
