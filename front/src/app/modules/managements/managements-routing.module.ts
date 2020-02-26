import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoggedGuard } from 'src/app/shared/guards/logged.guard.guard';
import { TranslationsComponent } from "./translations/translations.component";

const routes: Routes = [{
    path: '',

    children: [
        {
            path: '',
            pathMatch: 'full',
            redirectTo: 'translations',
            canActivateChild: [
                LoggedGuard
            ]
        },
        {
            path: 'translations',
            component: TranslationsComponent,
            canActivateChild: [
                LoggedGuard
            ]
        }
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class ManagementsRoutingModule { }
