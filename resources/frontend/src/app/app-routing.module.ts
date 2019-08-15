import {NgModule} from '@angular/core';
import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./home/home.component";
import {BatchComponent} from "./batch/batch.component";
import {SearchComponent} from "./search/search.component";
import {FaqComponent} from "./faq/faq.component";

const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'batch/:id', component: BatchComponent},
  {path: 'search', component: SearchComponent},
  {path: 'faq', component: FaqComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
