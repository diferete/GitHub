import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ListaFofatizacaoDetalhePageRoutingModule } from './lista-fofatizacao-detalhe-routing.module';

import { ListaFofatizacaoDetalhePage } from './lista-fofatizacao-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ListaFofatizacaoDetalhePageRoutingModule
  ],
  declarations: [ListaFofatizacaoDetalhePage]
})
export class ListaFofatizacaoDetalhePageModule {}
