import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SolComprasItensPage } from './sol-compras-itens.page';

const routes: Routes = [
  {
    path: '',
    component: SolComprasItensPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SolComprasItensPageRoutingModule {}
