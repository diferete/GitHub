import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { ProdMetalboDetalhePageRoutingModule } from './prod-metalbo-detalhe-routing.module';
import { ProdMetalboDetalhePage } from './prod-metalbo-detalhe.page';

@NgModule({
  imports: [CommonModule, FormsModule, IonicModule, ProdMetalboDetalhePageRoutingModule],
  declarations: [ProdMetalboDetalhePage],
})
export class ProdMetalboDetalhePageModule {}
