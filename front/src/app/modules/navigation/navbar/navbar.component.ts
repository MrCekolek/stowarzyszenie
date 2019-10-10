import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { UserService } from "../../../shared/services/user/user.service";
import * as $ from 'jquery';
import { TokenService } from "../../auth/login/service/token.service";
import { Router } from "@angular/router";
import { LanguageService } from "../../../shared/services/user/language.service";
import { SearchService } from "./service/search.service";
import { FormGroup, FormBuilder } from "@angular/forms";
import {debounceTime, distinctUntilChanged, map, switchMap} from "rxjs/operators";


@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {
  public searchInputForm: FormGroup;
  private searchInputSubscription;
  private loggedIn: boolean;
  private isLoading: boolean = false;
  private flagsImages = [
    '../../../assets/images/uk_flag.png',
    '../../../assets/images/pl_flag.png',
    '../../../assets/images/ru_flag.png'
  ];
  private translations = [
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.EN',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.PL',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.RU'
  ];
  private languageIndex = {
    'en': 0,
    'pl': 1,
    'ru': 2,
  };
  private foundedUsers = [];
  private searchTyped = 'elo';

  constructor(
    private translateService: TranslateService,
    private userService: UserService,
    private tokenService: TokenService,
    private searchService: SearchService,
    private formBuilder: FormBuilder,
    private router: Router,
    private languageService: LanguageService
  ) {
    this.userService.loginStatus.subscribe(value => this.loggedIn = value );
    this.createForm();
    this.registerFormValuesChanged();
  }

  ngOnInit() {
    $(document).ready(() => {
      // $('[data-toggle="tooltip"]').hover(function(){
      //     $(this).tooltip('show');
      // }, function(){
      //     $(this).tooltip('hide');
      // });

      ////////// CLICK FUNCTIONS /////////////

      const searchService = this.searchService;
      const self = this;

      searchService.getUsers(self.searchTyped).subscribe(
        data => {
          self.foundedUsers = data['users']
        }
      );

      $('.hamburger').click(function() {
        $('.sidebar-wrapper').toggleClass('collapsed');
      });

      $('.sidebar-overlay').click(function() {
        $('.sidebar-wrapper').toggleClass('collapsed');
      });

      $('.header-menu').click(function() {
        $('.header-right').toggleClass('opened');
      });

      $('.header-right-overlay').click(function() {
        $('.header-right').toggleClass('opened');
      });

      $('.title').click(function(event){
        $( event.target ).closest( 'ul.submenu' ).css('background', '#000');
        console.log($( event.target ).closest( '.submenu' ));
      });

      $('#search-icon').click(function() {
        searchService.getUsers(self.searchTyped).subscribe(
          data => self.foundedUsers = data['users']
        );

        $('.search-sidenav').toggleClass('opened');
      });

      $('.search-overlay').click(function() {
        $('.search-sidenav').toggleClass('opened');
      });
    });
  }

  createForm() {
    this.searchInputForm = this.formBuilder.group({
      'search_input': [this.searchTyped, []]
    });
  }

  registerFormValuesChanged() {
    this.searchInputSubscription = this.search_input.valueChanges
      .pipe(
        map(
          data => {
            this.isLoading = true;
            return data;
          }
        ),
        distinctUntilChanged(),
        debounceTime(1),
        switchMap(
          data  => {
            return this.searchService.getUsers(data);
          }
        ),
      )
      .subscribe(
        data => {
          this.foundedUsers = data['users'];
          this.isLoading = false;
        }
      );
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.tokenService.remove();
    this.userService.changeLoginStatus(false);
    this.router.navigateByUrl('/auth/login');
  }

  setLang(lang) {
    this.languageService.setLang(lang);
  }

  get search_input() {
    return this.searchInputForm.get('search_input');
  }
}
