import { NgModule } from '@angular/core';
import { SharedModule } from '../../shared/shared.module';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from './navbar/navbar.component';

@NgModule({
  declarations: [NavbarComponent],
  imports: [
    CommonModule,
    SharedModule
  ],
  exports: [NavbarComponent],
  providers: []
})
export class NavigationModule { }
