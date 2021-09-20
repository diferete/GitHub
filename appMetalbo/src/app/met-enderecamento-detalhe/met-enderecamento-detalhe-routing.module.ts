import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MetEnderecamentoDetalhePage } from './met-enderecamento-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: MetEnderecamentoDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MetEnderecamentoDetalhePageRoutingModule {}
