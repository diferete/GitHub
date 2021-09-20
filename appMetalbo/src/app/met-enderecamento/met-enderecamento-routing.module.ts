import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MetEnderecamentoPage } from './met-enderecamento.page';

const routes: Routes = [
  {
    path: '',
    component: MetEnderecamentoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MetEnderecamentoPageRoutingModule {}
