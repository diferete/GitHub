import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { SolComprasDetalhePageRoutingModule } from './sol-compras-detalhe-routing.module';

import { SolComprasDetalhePage } from './sol-compras-detalhe.page';

@NgModule({
  imports: [CommonModule, FormsModule, IonicModule, SolComprasDetalhePageRoutingModule],
  declarations: [SolComprasDetalhePage],
})
export class SolComprasDetalhePageModule {}
