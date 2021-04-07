import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { FatSteelDetalhePageRoutingModule } from './fat-steel-detalhe-routing.module';

import { FatSteelDetalhePage } from './fat-steel-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    FatSteelDetalhePageRoutingModule
  ],
  declarations: [FatSteelDetalhePage]
})
export class FatSteelDetalhePageModule {}
