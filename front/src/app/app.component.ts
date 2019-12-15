import { Component, Inject, OnDestroy, Renderer2 } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { UserService } from './shared/services/user/user.service';
import { Router, NavigationStart } from '@angular/router';
import { UserModel } from './shared/models/user.model';
import { SearchService } from './shared/services/user/search.service';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'front';
  private isPageLoading;
  private loggedIn: boolean;

  constructor(
    public translateService: TranslateService,
    public userService: UserService,
    @Inject(Document) private document: Document,
    private renderer: Renderer2,
    private router: Router,
    private searchService: SearchService
  ) {
    this.translateService.addLangs(['pl', 'en']);
    this.translateService.setDefaultLang('pl');
  }

  ngOnInit() {
    this.togglePageLoading(true);
    this.userService.loginStatus.subscribe(value => {
      this.loggedIn = value;

      if (!value) {
        this.renderer.addClass(document.body, 'layout-3');
      } else {
        this.renderer.removeClass(document.body, 'layout-3');
      }
    });

    let events: any = this.router.events;

    if (this.loggedIn) {
      this.router.events.subscribe(event => {
        // update user model
        if (event instanceof NavigationStart) {
          this.userService.me().subscribe(
            response => {
              this.userService.changeUser(new UserModel(response));
              console.log(new UserModel(response));
              this.isPageLoading = false;
            }
          );
        }
      });
    }
  }

  togglePageLoading(value: boolean) {
    this.isPageLoading = value;
  }

  ngOnDestroy() {
    this.renderer.removeClass(document.body, 'layout-3');
  }
}
