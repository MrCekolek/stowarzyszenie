import { Component, Inject, OnDestroy, Renderer2 } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { UserService } from './shared/services/user/user.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'front';
  private isPageLoading;

  constructor(
    public translateService: TranslateService,
    public userService: UserService,
    @Inject(Document) private document: Document,
    private renderer: Renderer2
  ) {
    this.translateService.addLangs(['pl', 'en']);
    this.translateService.setDefaultLang('pl');
  }

  ngOnInit() {
    // this.togglePageLoading(true);
    this.userService.loginStatus.subscribe(value => {
      if (!value) {
        this.renderer.addClass(document.body, 'layout-3');
      } else {
        this.renderer.removeClass(document.body, 'layout-3');
      }
    });
  }

  togglePageLoading(value: boolean) {
    this.isPageLoading = value;
  }

  ngOnDestroy() {
    this.renderer.removeClass(document.body, 'layout-3');
  }
}
