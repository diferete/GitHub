import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FatPoliamidosPage } from './fat-poliamidos.page';

const routes: Routes = [
  {
    path: '',
    component: FatPoliamidosPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FatPoliamidosPageRoutingModule {}
