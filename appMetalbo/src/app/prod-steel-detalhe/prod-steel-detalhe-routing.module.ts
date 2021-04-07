import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProdSteelDetalhePage } from './prod-steel-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: ProdSteelDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProdSteelDetalhePageRoutingModule {}
