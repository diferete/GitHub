import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FatSteelPage } from './fat-steel.page';

const routes: Routes = [
  {
    path: '',
    component: FatSteelPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FatSteelPageRoutingModule {}
