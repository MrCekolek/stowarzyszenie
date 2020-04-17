import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SharedModule } from '../../shared/shared.module';
import { MyArticlesComponent } from './my-articles/my-articles.component';
import { SubmitArticleComponent } from './submit-article/submit-article.component';
import { AllArticlesComponent } from './all-articles/all-articles.component';
import { EditArticleComponent } from './edit-article/edit-article.component';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        redirectTo: 'my'
      },
      {
        path: 'my',
        component: MyArticlesComponent
      },
      {
        path: 'add',
        component: SubmitArticleComponent
      },
      {
        path: 'edit/:id',
        component: EditArticleComponent
      },
      {
        path: 'all',
        component: AllArticlesComponent
      },
    ]
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
    SharedModule
  ],
  exports: [RouterModule]
})
export class ConferenceArticlesRoutingModule { }
