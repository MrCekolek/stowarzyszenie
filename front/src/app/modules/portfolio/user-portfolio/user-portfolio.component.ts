import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../../../shared/services/user/user.service';
import { LanguageService } from '../../../shared/services/user/language.service';


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
    private userService: UserService,
    private languageService: LanguageService
  ) { }

  ngOnInit() {
    this.userID = this.route.snapshot.params['id'];
    
    this.isOwner = this.userID == this.languageService.getUser().id;
  }
}
