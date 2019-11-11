import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './shared/shared.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { UserService } from "./shared/services/user/user.service";
import 'hammerjs';
import { NavigationModule } from './modules/navigation/navigation.module';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { DashboardModule } from './modules/dashboard/dashboard.module';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    SharedModule,
    BrowserAnimationsModule,
    NavigationModule,
    NgbModule,
    AppRoutingModule,
    DashboardModule
  ],
  providers: [UserService],
  bootstrap: [AppComponent]
})
export class AppModule { }
