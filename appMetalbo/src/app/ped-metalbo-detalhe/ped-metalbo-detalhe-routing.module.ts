import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PedMetalboDetalhePage } from './ped-metalbo-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: PedMetalboDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PedMetalboDetalhePageRoutingModule {}
