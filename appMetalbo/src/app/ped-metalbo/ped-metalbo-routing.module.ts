import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PedMetalboPage } from './ped-metalbo.page';

const routes: Routes = [
  {
    path: '',
    component: PedMetalboPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PedMetalboPageRoutingModule {}
