import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProdMetalboPage } from './prod-metalbo.page';

const routes: Routes = [
  {
    path: '',
    component: ProdMetalboPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProdMetalboPageRoutingModule {}
