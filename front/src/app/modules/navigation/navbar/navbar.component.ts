import { Component, OnInit, ViewChild, Output, EventEmitter } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { UserService } from "../../../shared/services/user/user.service";
import { TokenService } from "../../auth/login/service/token.service";
import { Router, ActivatedRoute, NavigationEnd } from "@angular/router";
import { LanguageService } from "../../../shared/services/user/language.service";
import { SearchService } from "../../../shared/services/user/search.service";
import { FormGroup, FormBuilder } from "@angular/forms";
import { map } from "rxjs/operators";
import { MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { NavigationStart } from "@angular/router";
import { UserModel } from '../../../shared/models/user.model';

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

  constructor(
    private translateService: TranslateService,
    private userService: UserService,
    private tokenService: TokenService,
    private searchService: SearchService,
    private formBuilder: FormBuilder,
    private router: Router,
    private languageService: LanguageService,
    private activatedRoute: ActivatedRoute
  ) {
    this.userService.loginStatus.subscribe(value => this.loggedIn = value );
    this.createForm();
  }

  ngOnInit() {
    this.emitPageLoadingValue(true);
    let events: any = this.router.events;

    if (this.loggedIn) {
      this.router.events.subscribe(event => {
        // update user model
        if (event instanceof NavigationStart) {
          this.userService.me().subscribe(
            response => {
              this.userService.changeUser(new UserModel(response));
              console.log(new UserModel(response));
              this.emitPageLoadingValue(false);
            }
          );
        }
      });
  
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
        )
  
        const searchService = this.searchService;
        const self = this;
    } else {
      this.emitPageLoadingValue(false);
    }
  }

  createForm() {
    this.searchInputForm = this.formBuilder.group({
      'search_input': ['', []]
    });
  }

  logout() {
    this.tokenService.remove();
    this.userService.changeLoginStatus(false);
    this.router.navigateByUrl('/auth/login');
  }

  setLang(lang) {
    this.languageService.setLang(lang);
  }

  searchUsers() {
    this.listData.filter = this.search_input.value.trim().toLowerCase();
  }

  get search_input() {
    return this.searchInputForm.get('search_input');
  }

  emitPageLoadingValue(value) {
    this.isPageLoading.emit(value);
  }
}
