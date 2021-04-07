import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { FatMetalboDetalhePageRoutingModule } from './fat-metalbo-detalhe-routing.module';

import { FatMetalboDetalhePage } from './fat-metalbo-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    FatMetalboDetalhePageRoutingModule
  ],
  declarations: [FatMetalboDetalhePage]
})
export class FatMetalboDetalhePageModule {}
