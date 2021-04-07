import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PedMetalboDetalhePageRoutingModule } from './ped-metalbo-detalhe-routing.module';

import { PedMetalboDetalhePage } from './ped-metalbo-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PedMetalboDetalhePageRoutingModule
  ],
  declarations: [PedMetalboDetalhePage]
})
export class PedMetalboDetalhePageModule {}
