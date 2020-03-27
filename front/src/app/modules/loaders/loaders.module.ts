import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { InsideComponentLoaderComponent } from './inside-component-loader/inside-component-loader.component';

@NgModule({
  declarations: [InsideComponentLoaderComponent],
  imports: [
    CommonModule
  ],
  exports: [InsideComponentLoaderComponent]
})
export class LoadersModule { }
