import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FatMetalboPage } from './fat-metalbo.page';

const routes: Routes = [
  {
    path: '',
    component: FatMetalboPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FatMetalboPageRoutingModule {}
