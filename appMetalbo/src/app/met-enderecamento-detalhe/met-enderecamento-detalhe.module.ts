import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoDetalhePageRoutingModule } from './met-enderecamento-detalhe-routing.module';

import { MetEnderecamentoDetalhePage } from './met-enderecamento-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MetEnderecamentoDetalhePageRoutingModule
  ],
  declarations: [MetEnderecamentoDetalhePage]
})
export class MetEnderecamentoDetalhePageModule {}
