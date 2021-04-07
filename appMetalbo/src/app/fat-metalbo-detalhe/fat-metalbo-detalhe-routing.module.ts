import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FatMetalboDetalhePage } from './fat-metalbo-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: FatMetalboDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FatMetalboDetalhePageRoutingModule {}
