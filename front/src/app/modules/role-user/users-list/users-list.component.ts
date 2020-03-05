import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute, Router } from "@angular/router";
import { LanguageService } from "../../../shared/services/user/language.service";
import { UserRoleApiService } from "../../../core/http/user-role-api.service";
import { MatDialog, MatDialogConfig, MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { FormBuilder, FormGroup } from "@angular/forms";
import {  TranslateService } from "@ngx-translate/core";
import { Role } from "../../../shared/models/role.model";
import { ConfirmationDialogComponent } from "../../../shared/components/confirmation-dialog/confirmation-dialog.component";
import { AlertModel } from "../../../shared/models/alert.model";
import { NewRoleUserModalComponent } from "../new-role-user-modal/new-role-user-modal.component";

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss']
})
export class UsersListComponent implements OnInit, AfterViewInit {
  @ViewChild(MatSort, {static: false}) sort: MatSort;
  @ViewChild(MatPaginator, {static: false}) paginator: MatPaginator;

  private roleId;
  private role: Role;
  private lang;
  private alert: AlertModel;
  private userListForm: FormGroup;
  private listData: MatTableDataSource<any>;
  private displayedColumns: string[] = [
    'id',
    'login_email',
    'first_name',
    'last_name'
  ];

  constructor(
      private route: ActivatedRoute,
      private languageService: LanguageService,
      private router: Router,
      private formBuilder: FormBuilder,
      private userRoleApiService: UserRoleApiService,
      private translationService: TranslateService,
      private dialog: MatDialog
  ) {
    this.createForm();
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(lang => {
      this.lang = lang;
    });

    this.roleId = this.route.snapshot.params['roleId'];

    if (this.roleId != 2) {
      this.displayedColumns.push('actions');
    }

    this.userRoleApiService.getRole(this.roleId).subscribe(
        (data) => {
          if (data.success) {
            this.role = data.role;
          }
        },
        () => {},
        () => {}
    );

    this.userRoleApiService.getUsers(this.roleId).subscribe(
      (data) => {
        this.listData = new MatTableDataSource(data['users']);
        this.listData.sort = this.sort;
        this.listData.paginator = this.paginator;
      },
      () => {},
      () => {
        this.changeOfTranslation();
      }
    );
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
              let rangeLabel = document.getElementsByClassName('mat-paginator-range-label')[0].innerHTML;

              document.getElementsByClassName('mat-paginator-range-label')[0].innerHTML = rangeLabel.replace(/of/g, data);
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

  openNewRoleUserModal() {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      role_id: this.roleId
    };

    const dialogRef = this.dialog.open(NewRoleUserModalComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(() => {
        this.userRoleApiService.getUsers(this.roleId).subscribe(
            (data) => {
              this.listData = new MatTableDataSource(data['users']);
              this.listData.sort = this.sort;
              this.listData.paginator = this.paginator;
            }
        );
    });
  }

  removeUserFromRole(user) {
    const obj = {
      role_id: this.roleId,
      user_id: user.id,
      name_pl: this.role.name_pl,
      name_en: this.role.name_en,
      name_ru: this.role.name_ru
    };

    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = {
      title: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.ROLE_USER.TITLE',
      text: 'STOWARZYSZENIE.HELPERS.ALERT.DELETE.ROLE_USER.TEXT',
      element: obj,
      apiToDelete: `role/${this.roleId}/user/${user.id}/destroy`
    };

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        (data) => {
          if (data) {
            if (data.success) {
              const index = this.listData.data.findIndex(item => item.id === user.id);
              this.listData.data.splice(index, 1);
              this.listData._updateChangeSubscription();

              this.alert = new AlertModel('success', data.message);
            } else {
              this.alert = new AlertModel('danger', data.message);
            }
          }
        }
    );
  }

  get search_input() {
    return this.userListForm.get('search_input');
  }
}
