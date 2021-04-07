import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ListaFosfatizacaoPageRoutingModule } from './lista-fosfatizacao-routing.module';

import { ListaFosfatizacaoPage } from './lista-fosfatizacao.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ListaFosfatizacaoPageRoutingModule
  ],
  declarations: [ListaFosfatizacaoPage]
})
export class ListaFosfatizacaoPageModule {}
