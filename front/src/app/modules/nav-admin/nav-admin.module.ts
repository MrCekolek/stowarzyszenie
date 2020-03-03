import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from 'src/app/shared/shared.module';
import { HomeNavManageComponent } from './home-nav-manage/home-nav-manage.component';
import { PageEditComponent } from './page-edit/page-edit.component';
import { NavAdminRouting } from './nav-admin-routing.module';
import { HomeLinksListComponent } from './home-links-list/home-links-list.component';
import { ConferencePagesComponent } from './conference-pages/conference-pages.component';
import { HomepagesModalComponent } from './homepages-modal/homepages-modal.component';
import { ConferencePagesListComponent } from './conference-pages-list/conference-pages-list.component';
import { FormsModule } from '@angular/forms';
import { ConferencePagesModalComponent } from './conference-pages-modal/conference-pages-modal.component';
import { AngularEditorModule } from '@kolkov/angular-editor';

@NgModule({
  declarations: [HomeNavManageComponent, PageEditComponent, HomeLinksListComponent, ConferencePagesComponent, HomepagesModalComponent, ConferencePagesListComponent, ConferencePagesModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    NavAdminRouting,
    FormsModule,
    AngularEditorModule
  ],
  entryComponents: [HomepagesModalComponent]
})
export class NavAdminModule { }
