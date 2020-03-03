import { Component, OnInit } from '@angular/core';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';

@Component({
  selector: 'app-conference-pages',
  templateUrl: './conference-pages.component.html',
  styleUrls: ['./conference-pages.component.scss']
})
export class ConferencePagesComponent implements OnInit {

  conflinks = [];
  loading: boolean;

  constructor(
    private naviApiService: NavigationApiService
  ) { }

  ngOnInit() {
    // TODO: pobranie menu konferencji
    // this.loading = true;
    // this.naviApiService.getHomeLinks().subscribe(res => {
    //   this.conflinks = res.home_navigations;
    //   this.loading = false;
    // });
  }
}
