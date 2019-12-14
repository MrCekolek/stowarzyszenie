import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './shared/shared.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { UserService } from "./shared/services/user/user.service";
import 'hammerjs';
import { NavigationModule } from './modules/navigation/navigation.module';
import { DashboardModule } from './modules/dashboard/dashboard.module';
import { NbSecurityModule } from '@nebular/security';
import { PageLoaderComponent } from './shared/components/page-loader/page-loader.component';

@NgModule({
  declarations: [
    AppComponent,
    PageLoaderComponent
  ],
  imports: [
    BrowserModule,
    SharedModule,
    BrowserAnimationsModule,
    NavigationModule,
    AppRoutingModule,
    DashboardModule,
    NbSecurityModule,
    NbSecurityModule.forRoot(),
  ],
  providers: [UserService, Document],
  bootstrap: [AppComponent]
})
export class AppModule { }
