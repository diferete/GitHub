import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProdMetalboDetalhePage } from './prod-metalbo-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: ProdMetalboDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProdMetalboDetalhePageRoutingModule {}
