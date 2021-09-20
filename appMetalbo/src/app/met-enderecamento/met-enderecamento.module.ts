import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoPageRoutingModule } from './met-enderecamento-routing.module';

import { MetEnderecamentoPage } from './met-enderecamento.page';

@NgModule({
  imports: [CommonModule, FormsModule, IonicModule, MetEnderecamentoPageRoutingModule],
  declarations: [MetEnderecamentoPage],
})
export class MetEnderecamentoPageModule {}
