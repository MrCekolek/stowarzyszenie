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
import { UserProviderService} from "./core/services/user-provider.service";

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
    DashboardModule
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

