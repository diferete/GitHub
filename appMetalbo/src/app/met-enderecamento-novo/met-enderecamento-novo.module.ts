import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoNovoPageRoutingModule } from './met-enderecamento-novo-routing.module';

import { MetEnderecamentoNovoPage } from './met-enderecamento-novo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MetEnderecamentoNovoPageRoutingModule
  ],
  declarations: [MetEnderecamentoNovoPage]
})
export class MetEnderecamentoNovoPageModule {}
