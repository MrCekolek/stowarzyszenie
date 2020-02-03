import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { LanguageService } from '../../../shared/services/user/language.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';
import { UserModel } from 'src/app/shared/models/user.model';

@Component({
  selector: 'app-user-portfolio',
  templateUrl: './user-portfolio.component.html',
  styleUrls: ['./user-portfolio.component.scss']
})
export class UserPortfolioComponent implements OnInit {

  private userID;
  private isOwner: boolean;

  allTabs: any = [];
  lang: string = '';

  private loading = true;

  user: UserModel;

  constructor(
    private route: ActivatedRoute,
    private languageService: LanguageService,
    private userProvider: UserProviderService,
    private portfolioService: PortfolioApiService
  ) { }

  ngOnInit() {
    this.loading = true;
    
    this.userID = this.route.snapshot.params['id'];
    this.isOwner = this.userID == this.userProvider.getUser().id;  
    this.user = this.userProvider.getUser();
    console.log(this.user);

    this.portfolioService.getTabs(this.userID).subscribe(value => {
      this.allTabs = value.portfolioTabs;
      this.loading = false;
    });

    this.languageService.currentLang.subscribe( lg => {
      this.lang = lg;
    });
  }
}
