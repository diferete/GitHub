import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProdSteelDetalhePageRoutingModule } from './prod-steel-detalhe-routing.module';

import { ProdSteelDetalhePage } from './prod-steel-detalhe.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProdSteelDetalhePageRoutingModule
  ],
  declarations: [ProdSteelDetalhePage]
})
export class ProdSteelDetalhePageModule {}
