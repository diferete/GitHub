import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SolComprasPage } from './sol-compras.page';

const routes: Routes = [
  {
    path: '',
    component: SolComprasPage,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SolComprasPageRoutingModule {}
