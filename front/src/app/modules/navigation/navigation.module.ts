import { NgModule } from '@angular/core';
import { SharedModule } from '../../shared/shared.module';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from './navbar/navbar.component';
import { AppRoutingModule } from '../../app-routing.module';
import { MatSidenavModule } from '@angular/material/sidenav';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import {MatInputModule} from "@angular/material";

@NgModule({
  declarations: [NavbarComponent],
  imports: [
    CommonModule,
    SharedModule,
    AppRoutingModule,
    MatSidenavModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule
  ],
  exports: [NavbarComponent],
  providers: []
})
export class NavigationModule { }
