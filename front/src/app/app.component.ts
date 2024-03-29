import { Component, Inject, OnDestroy, Renderer2, ViewEncapsulation } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { Router, NavigationStart } from '@angular/router';
import { UserModel } from './shared/models/user.model';
import { SearchService } from './shared/services/user/search.service';
import { UserProviderService } from './core/services/user-provider.service';
import { TokenService } from "./modules/auth/login/service/token.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'front';
  private isPageLoading: boolean = true;
  private loggedIn: boolean;

  constructor(
    public translateService: TranslateService,
    public userProviderService: UserProviderService,
    @Inject(Document) private document: Document,
    private renderer: Renderer2,
    private router: Router,
    private searchService: SearchService,
    private tokenService: TokenService
  ) {
    this.translateService.addLangs(['pl', 'en']);
    this.translateService.setDefaultLang('pl');
  }

  ngOnInit() {
    this.isPageLoading = true;

    let events: any = this.router.events;

    this.userProviderService.loginStatus.subscribe(value => {
      this.loggedIn = value;

      if (!value) {
        this.renderer.addClass(document.body, 'layout-3');
      } else {
        this.renderer.removeClass(document.body, 'layout-3');
      }
    });

    if (this.loggedIn) {
      this.router.events.subscribe(event => {
        // update user model
        if (event instanceof NavigationStart) {
          if (this.tokenService.get()) {
            this.userProviderService.me().subscribe(
                response => {
                  this.userProviderService.setUser(new UserModel(response));
                }
            );
          }
        }
      });
    }

    this.isPageLoading = false;
  }

  ngOnDestroy() {
    this.renderer.removeClass(document.body, 'layout-3');
  }
}
