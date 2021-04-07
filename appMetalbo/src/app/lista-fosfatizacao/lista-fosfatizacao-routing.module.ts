import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ListaFosfatizacaoPage } from './lista-fosfatizacao.page';

const routes: Routes = [
  {
    path: '',
    component: ListaFosfatizacaoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ListaFosfatizacaoPageRoutingModule {}
