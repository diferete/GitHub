import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PedComprasDetalhePage } from './ped-compras-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: PedComprasDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PedComprasDetalhePageRoutingModule {}
