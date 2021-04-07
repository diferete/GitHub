import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProdPoliamidosPage } from './prod-poliamidos.page';

const routes: Routes = [
  {
    path: '',
    component: ProdPoliamidosPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProdPoliamidosPageRoutingModule {}
