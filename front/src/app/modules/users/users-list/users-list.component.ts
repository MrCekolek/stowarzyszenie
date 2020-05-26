import {AfterViewInit, Component, OnInit, ViewChild} from '@angular/core';
import { SearchService } from "../../../shared/services/user/search.service";
import { MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { FormBuilder, FormGroup } from "@angular/forms";
import { TranslateService } from "@ngx-translate/core";

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss']
})
export class UsersListComponent implements OnInit, AfterViewInit {
  @ViewChild(MatSort, {static: false}) sort: MatSort;
  @ViewChild(MatPaginator, {static: false}) paginator: MatPaginator;

  private userListForm: FormGroup;
  private listData: MatTableDataSource<any>;
  private displayedColumns: string[] = [
    'id',
    'login_email',
    'first_name',
    'last_name',
    'actions'
    // 'contact_email',
    // 'phone_number'
  ];

  constructor(
    private searchService: SearchService,
    private formBuilder: FormBuilder,
    private translationService: TranslateService
  ) {
    this.createForm();
  }

  ngOnInit() {
    this.searchService.getUsers()
        .subscribe(
            (data) => {
              this.listData = new MatTableDataSource(data['users']);
              this.listData.sort = this.sort;
              this.listData.paginator = this.paginator;
            },
            () => {},
            () => {
              this.changeOfTranslation();
            }
        )
  }

  ngAfterViewInit(): void {
    this.translationService.stream('STOWARZYSZENIE.LABELS.PER_PAGE').subscribe(data => {
      if (document.getElementsByClassName('mat-paginator-page-size-label').length > 0) {
        document.getElementsByClassName('mat-paginator-page-size-label')[0].innerHTML = data;
      }
    });
  }

  changeOfTranslation() {
    this.translationService.stream('STOWARZYSZENIE.LABELS.OF').subscribe(
        (data) => {
          if (document.getElementsByClassName('mat-paginator-range-label').length > 0) {
            setTimeout(function () {
              if (document.getElementsByClassName('mat-paginator-range-label')[0]) {
                let rangeLabel = document.getElementsByClassName('mat-paginator-range-label')[0].innerHTML;

                document.getElementsByClassName('mat-paginator-range-label')[0].innerHTML = rangeLabel.replace(/of/g, data);
              }
            }, 500);
          }
        }
    )
  }

  createForm() {
    this.userListForm = this.formBuilder.group({
      'search_input': ['', []]
    });
  }

  searchUsers() {
    this.listData.filter = this.search_input.value.trim().toLowerCase();
  }

  get search_input() {
    return this.userListForm.get('search_input');
  }
}
