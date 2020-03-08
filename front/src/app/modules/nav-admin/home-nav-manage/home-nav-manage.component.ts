import { Component, OnInit } from '@angular/core';
import { NavigationApiService } from 'src/app/core/http/navigation-api.service';

@Component({
  selector: 'app-home-nav-manage',
  templateUrl: './home-nav-manage.component.html',
  styleUrls: ['./home-nav-manage.component.scss']
})
export class HomeNavManageComponent implements OnInit {

  homelinks = [];
  loading: boolean;

  constructor(
    private naviApiService: NavigationApiService
  ) { }

  ngOnInit() {
    this.loading = true;
    this.naviApiService.getHomeLinks().subscribe(res => {
      this.homelinks = res.homeNavigations;
      this.loading = false;
    });
  }
}
