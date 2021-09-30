import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MetEnderecamentoNovoPage } from './met-enderecamento-novo.page';

const routes: Routes = [
  {
    path: '',
    component: MetEnderecamentoNovoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MetEnderecamentoNovoPageRoutingModule {}
