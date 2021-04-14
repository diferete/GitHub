import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PedCompraMetalboPage } from './ped-compra-metalbo.page';

const routes: Routes = [
  {
    path: '',
    component: PedCompraMetalboPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PedCompraMetalboPageRoutingModule {}
