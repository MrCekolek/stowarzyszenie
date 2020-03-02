import { Component, OnInit, ViewChild, Output, EventEmitter } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { TokenService } from "../../auth/login/service/token.service";
import { Router, ActivatedRoute, NavigationEnd } from "@angular/router";
import { LanguageService } from "../../../shared/services/user/language.service";
import { SearchService } from "../../../shared/services/user/search.service";
import { FormGroup, FormBuilder } from "@angular/forms";
import { map } from "rxjs/operators";
import { MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { UserProviderService } from "../../../core/services/user-provider.service";

declare const $: any;

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {

  @ViewChild(MatSort, {static: false}) sort: MatSort;
  @ViewChild(MatPaginator, {static: false}) paginator: MatPaginator;

  private searchInputForm: FormGroup;
  private listData: MatTableDataSource<any>;
  private displayedColumns: string[] = [
    'avatar',
    'name',
    'actions'
  ];
  private loggedIn: boolean;
  private isLoading: boolean = false;
  @Output() isPageLoading = new EventEmitter<boolean>();

  private flagsImages = [
    '../../../assets/images/pl_flag.png',
    '../../../assets/images/uk_flag.png',
    '../../../assets/images/ru_flag.png'
  ];
  private translations = [
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.PL',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.EN',
    'STOWARZYSZENIE.MODULES.NAVIGATION.LANGUAGES.RU'
  ];
  private languageIndex = {
    'pl': 0,
    'en': 1,
    'ru': 2,
  };

  constructor(
    private translateService: TranslateService,
    private tokenService: TokenService,
    private searchService: SearchService,
    private formBuilder: FormBuilder,
    private router: Router,
    private languageService: LanguageService,
    private activatedRoute: ActivatedRoute,
    private userProviderService: UserProviderService
  ) {
    this.userProviderService.loginStatus.subscribe(value => this.loggedIn = value);
    this.createForm();
  }

  ngOnInit() {
    window.addEventListener('resize', function () {
      if (window.innerWidth <= 1024) {
        if (document.getElementById('main-navbar').classList.contains('main-navbar-toggled')) {
          document.getElementById('main-navbar').classList.remove('main-navbar-toggled');
          document.getElementById('main-navbar').classList.add('main-navbar-collapsed');
        }

        if (document.getElementById('main-content').classList.contains('main-content-toggled')) {
          document.getElementById('main-content').classList.remove('main-content-toggled');
          document.getElementById('main-content').classList.add('main-content-collapsed');
        }

        if (document.getElementById('main-footer').classList.contains('main-footer-toggled')) {
          document.getElementById('main-footer').classList.remove('main-footer-toggled');
          document.getElementById('main-footer').classList.add('main-footer-collapsed');
        }
      } else {
        if (document.getElementById('main-navbar').classList.contains('main-navbar-collapsed')) {
          document.getElementById('main-navbar').classList.remove('main-navbar-collapsed');
          document.getElementById('main-navbar').classList.add('main-navbar-toggled');
        }

        if (document.getElementById('main-content').classList.contains('main-content-collapsed')) {
          document.getElementById('main-content').classList.remove('main-content-collapsed');
          document.getElementById('main-content').classList.add('main-content-toggled');
        }

        if (document.getElementById('main-footer').classList.contains('main-footer-collapsed')) {
          document.getElementById('main-footer').classList.remove('main-footer-collapsed');
          document.getElementById('main-footer').classList.add('main-footer-toggled');
        }
      }
    });

    // $(document).ready(() => {
    //   $('li.dropdown').unbind('click');

    //   $('li.dropdown').click(() => {
    //     console.log( $(this).closest('ul.dropdown-menu'));
    //     $(this).closest('ul.dropdown-menu').slideToggle();
    //   });
    // });

    this.searchService.getUsers()
        .pipe(
          map(
            data => {
              this.isLoading = true;
  
              return data;
            }
          )
        )
        .subscribe(
          data => {
            this.listData = new MatTableDataSource(data['users'].slice(-5));
            this.listData.sort = this.sort;
            this.listData.paginator = this.paginator;
  
            this.isLoading = false;
          }
        );
  
        const searchService = this.searchService;
        const self = this;
  }

  createForm() {
    this.searchInputForm = this.formBuilder.group({
      'search_input': ['', []]
    });
  }

  logout() {
    this.tokenService.remove();
    this.userProviderService.changeLoginStatus(false);
    this.router.navigateByUrl('/auth/login');
  }

  setLang(lang) {
    this.languageService.setLang(lang);
  }

  searchUsers(value) {
    if (!this.isLoading) {
      this.listData.filter = value;
    }
  }

  get search_input() {
    return this.searchInputForm.get('search_input');
  }

  emitPageLoadingValue(value) {
    this.isPageLoading.emit(value);
  }

  toggleSidebar() {
    if (document.body.classList.contains('sidebar-gone')) {
      document.body.classList.remove('sidebar-gone');
      document.getElementById('main-navbar').classList.remove('main-navbar-collapsed');
      document.getElementById('main-navbar').classList.add('main-navbar-toggled');
      document.getElementById('main-content').classList.remove('main-content-collapsed');
      document.getElementById('main-content').classList.add('main-content-toggled');
      document.getElementById('main-footer').classList.remove('main-footer-collapsed');
      document.getElementById('main-footer').classList.add('main-footer-toggled');
    } else {
      document.body.classList.add('sidebar-gone');
      document.getElementById('main-navbar').classList.remove('main-navbar-toggled');
      document.getElementById('main-navbar').classList.add('main-navbar-collapsed');
      document.getElementById('main-content').classList.remove('main-content-toggled');
      document.getElementById('main-content').classList.add('main-content-collapsed');
      document.getElementById('main-footer').classList.remove('main-footer-toggled');
      document.getElementById('main-footer').classList.add('main-footer-collapsed');
    }
  }
}
