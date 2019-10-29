import { Component, OnInit, ViewChild } from '@angular/core';
import { SearchService } from "../../../shared/services/user/search.service";
import { MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { FormBuilder, FormGroup } from "@angular/forms";

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss']
})
export class UsersListComponent implements OnInit {
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
    private formBuilder: FormBuilder
  ) {
    this.createForm();
  }

  ngOnInit() {
    this.searchService.getUsers()
      .subscribe(
        data => {
          this.listData = new MatTableDataSource(data['users']);
          this.listData.sort = this.sort;
          this.listData.paginator = this.paginator;
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
