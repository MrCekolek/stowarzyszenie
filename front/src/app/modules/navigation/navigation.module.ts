import { NgModule } from '@angular/core';
import { SharedModule } from '../../shared/shared.module';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from './navbar/navbar.component';
import { AppRoutingModule } from '../../app-routing.module';
import { UserSidenavComponent } from './user-sidenav/user-sidenav.component';
import { MatSidenavModule } from '@angular/material/sidenav';

@NgModule({
  declarations: [NavbarComponent, UserSidenavComponent],
  imports: [
    CommonModule,
    SharedModule,
    AppRoutingModule,
    MatSidenavModule
  ],
  exports: [NavbarComponent, UserSidenavComponent],
  providers: []
})
export class NavigationModule { }
