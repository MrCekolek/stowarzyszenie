import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from 'src/app/shared/shared.module';
import { HomeNavManageComponent } from './home-nav-manage/home-nav-manage.component';
import { PageEditComponent } from './page-edit/page-edit.component';
import { NavAdminRouting } from './nav-admin-routing.module';
import { HomeLinksListComponent } from './home-links-list/home-links-list.component';
import { HomeLinkTileComponent } from './home-link-tile/home-link-tile.component';
import { ConferencePagesComponent } from './conference-pages/conference-pages.component';
import { HomepagesModalComponent } from './homepages-modal/homepages-modal.component';

@NgModule({
  declarations: [HomeNavManageComponent, PageEditComponent, HomeLinksListComponent, HomeLinkTileComponent, ConferencePagesComponent, HomepagesModalComponent],
  imports: [
    CommonModule,
    SharedModule,
    NavAdminRouting
  ],
  entryComponents: [HomepagesModalComponent]
})
export class NavAdminModule { }
