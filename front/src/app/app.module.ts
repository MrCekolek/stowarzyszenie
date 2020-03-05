import { BrowserModule } from '@angular/platform-browser';
import { NgModule, APP_INITIALIZER } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './shared/shared.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import 'hammerjs';
import { NavigationModule } from './modules/navigation/navigation.module';
import { DashboardModule } from './modules/dashboard/dashboard.module';
import { PageLoaderComponent } from './shared/components/page-loader/page-loader.component';
import { UserProviderService } from "./core/services/user-provider.service";
import { NgxJsonViewerModule } from "ngx-json-viewer";
import { ManagementsModule } from "./modules/managements/managements.module";
import { RoleUserModule } from "./modules/role-user/role-user.module";

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
    ManagementsModule,
    RoleUserModule,
    NgxJsonViewerModule
  ],
  providers: [Document, UserProviderService, {
      provide: APP_INITIALIZER,
      useFactory: userProviderFactory,
      deps: [UserProviderService],
      multi: true
    }],
  bootstrap: [AppComponent]
})

export class AppModule { }

export function userProviderFactory(provider: UserProviderService) {
  return () => provider.load();
}

