import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ListaFofatizacaoDetalhePage } from './lista-fofatizacao-detalhe.page';

const routes: Routes = [
  {
    path: '',
    component: ListaFofatizacaoDetalhePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ListaFofatizacaoDetalhePageRoutingModule {}
