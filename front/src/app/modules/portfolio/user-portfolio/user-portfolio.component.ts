import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from 'src/app/shared/services/user/user.service';

@Component({
  selector: 'app-user-portfolio',
  templateUrl: './user-portfolio.component.html',
  styleUrls: ['./user-portfolio.component.scss']
})
export class UserPortfolioComponent implements OnInit {

  private userID;
  private isOwner: boolean;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService
  ) { }

  ngOnInit() {
    if (!this.userID) {
      this.userID = this.route.snapshot.params['id'];
    }

    // TODO: odkryc czemu user is undefined
    this.userID === this.userService.user.id ? 
    this.isOwner = true : this.isOwner = false;

    console.log('s');
  }
}
