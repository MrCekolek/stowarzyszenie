import { AfterViewInit, Component, Inject, OnInit, ViewChild } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef, MatPaginator, MatSort, MatTableDataSource } from "@angular/material";
import { LanguageService } from "../../../shared/services/user/language.service";
import { PermissionRoleApiService } from "../../../core/http/permission-role-api.service";
import { UserRoleApiService } from "../../../core/http/user-role-api.service";
import { AlertModel } from "../../../shared/models/alert.model";
import { FormBuilder, FormGroup } from "@angular/forms";
import { TranslateService } from "@ngx-translate/core";

@Component({
  selector: 'app-new-role-user-modal',
  templateUrl: './new-role-user-modal.component.html',
  styleUrls: ['./new-role-user-modal.component.scss']
})
export class NewRoleUserModalComponent implements OnInit, AfterViewInit {
  @ViewChild(MatSort, {static: false}) sort: MatSort;
  @ViewChild(MatPaginator, {static: false}) paginator: MatPaginator;

  private roleId;
  private lang;
  private alert: AlertModel;
  private userListForm: FormGroup;
  private listData: MatTableDataSource<any>;
  private displayedColumns: string[] = [
    'id',
    'first_name',
    'last_name',
    'actions'
  ];

  constructor(
      private dialogRef: MatDialogRef<NewRoleUserModalComponent>,
      @Inject(MAT_DIALOG_DATA) data,
      private userRoleApiService: UserRoleApiService,
      private languageService: LanguageService,
      private formBuilder: FormBuilder,
      private dialog: MatDialog,
      private translationService: TranslateService
  ) {
    if (data) {
      this.roleId = data.role_id;
    }

    this.createForm();
  }

  ngOnInit() {
    this.languageService.currentLang.subscribe(data => {
      this.lang = data;
    });

    this.userRoleApiService.getUsersNotAssignedToRole(this.roleId).subscribe(
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

  dismiss() {
    this.dialogRef.close();
  }

  createForm() {
    this.userListForm = this.formBuilder.group({
      'search_input': ['', []]
    });
  }

  searchUsers() {
    this.listData.filter = this.search_input.value.trim().toLowerCase();
  }

  addUserToRole(user) {
    this.userRoleApiService.assignUserToRole(user.id, this.roleId).subscribe(
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
    )
  }

  get search_input() {
    return this.userListForm.get('search_input');
  }
}
