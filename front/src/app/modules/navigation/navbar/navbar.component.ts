import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from 'src/app/shared/services/user/user.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  private mainNavOpened = false;
  private accountNavOpened = false;
  private logged = false;

  constructor(
    private translateService: TranslateService,
    private route: ActivatedRoute,
    private userService: UserService
  ) { }

  ngOnInit() {
    console.log(this.route.url);
    this.userService.loginStatus.subscribe(status => {
      this.logged = status;
    });
  }
}
