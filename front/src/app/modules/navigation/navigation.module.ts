import { NgModule } from '@angular/core';
import { SharedModule } from '../../shared/shared.module';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from './navbar/navbar.component';
import { AppRoutingModule } from '../../app-routing.module';
import { MatSidenavModule } from '@angular/material/sidenav';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { MatInputModule } from "@angular/material";
import { BreadcrumbComponent } from './breadcrumb/breadcrumb.component';
import { UserSearchComponent } from './user-search/user-search.component';
import { HomePageComponent } from './home-page/home-page.component';
import { ScrollingModule } from '@angular/cdk/scrolling';
import { NgScrollbarModule } from 'ngx-scrollbar';
import { ConferencePageComponent } from './conference-page/conference-page.component';
import { MatTabsModule } from '@angular/material/tabs';
import { TabsComponent } from './tabs/tabs.component';
import { TabComponent } from './tab/tab.component';

@NgModule({
  declarations: [NavbarComponent, BreadcrumbComponent, UserSearchComponent, HomePageComponent, ConferencePageComponent, TabsComponent, TabComponent],
  imports: [
    CommonModule,
    SharedModule,
    AppRoutingModule,
    MatSidenavModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule,
    ScrollingModule,
    NgScrollbarModule,
    MatTabsModule
  ],
  exports: [NavbarComponent, TabsComponent],
  providers: []
})

export class NavigationModule { }
