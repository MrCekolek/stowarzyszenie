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
}
