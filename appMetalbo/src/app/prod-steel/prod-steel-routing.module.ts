import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProdSteelPage } from './prod-steel.page';

const routes: Routes = [
  {
    path: '',
    component: ProdSteelPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProdSteelPageRoutingModule {}
