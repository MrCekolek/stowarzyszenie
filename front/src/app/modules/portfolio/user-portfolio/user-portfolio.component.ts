import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { LanguageService } from '../../../shared/services/user/language.service';
import { UserProviderService } from 'src/app/core/services/user-provider.service';
import { PortfolioApiService } from 'src/app/core/http/portfolio-api.service';
import { UserModel } from 'src/app/shared/models/user.model';
import { LoginApiService } from 'src/app/core/http/login-api.service';

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
  private descLoader = false;
  private loadingDesc = false;
  user: UserModel;
  private description;

  private rolesList: string = '';
  private descEditing: boolean;
  private preview: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private languageService: LanguageService,
    private userProvider: UserProviderService,
    private portfolioService: PortfolioApiService,
    private loginServie: LoginApiService,
    private router: Router
  ) { }

  ngOnInit() {
    this.loading = true;
    this.descEditing = false;

    this.route.paramMap.subscribe(
        (params) => {
            this.loading = true;
            this.preview = false;

            this.userID = params.get('id');

            this.loginServie.getUserByID(this.userID).subscribe(
                (res) => {
                  this.user = res.user;
                  this.description = this.user.portfolio.description;
                  this.isOwner = this.userID == this.userProvider.getUser().id;

                  if (this.route.snapshot.queryParamMap.get('preview') == 'true') {
                    this.preview = true;
                  } else {
                    this.preview = !this.isOwner;
                  }
                },
                () => {},
                () => {
                  //get roles
                  for (let i = 0; i < this.user.roles.length; i++) {
                    this.rolesList += this.user.roles[i]['name_' + this.lang] + ' ';
                  }
                }
            );

            this.portfolioService.getTabs(this.userID).subscribe(value => {
              this.allTabs = value.portfolioTabs;
              this.loading = false;
            });
        },
        () => {},
        () => {
            this.loading = false;
        }
    );

    this.languageService.currentLang.subscribe(lg => {
      this.lang = lg;
    });
  }

  // TODO: zapis do api description
  modifyDesc() {
    if (this.description !== '' && this.description !== null) {
      this.loadingDesc = true;

      const portfolio = {
        id: this.userProvider.getUser().id,
        description: this.description
      };

      this.portfolioService.updateDescription(portfolio).subscribe(
          (res) => {
            if (res.success) {
              this.user.portfolio.description = this.description;
              this.descEditing = false;
            } else {
              this.description = this.user.portfolio.description;
            }
          },
          () => {},
          () => {
            this.loadingDesc = false;
          }
      );
    }
  }

  stopModify() {
    this.description = this.user.portfolio.description;

    this.descEditing = false
  }

  enterPreviewMode() {
    this.isOwner = false;
    this.preview = true;
  }

  exitPreviewMode() {
    this.isOwner = true;
    this.preview = false;
  }
}
