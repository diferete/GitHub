import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { SolComprasItensPageRoutingModule } from './sol-compras-itens-routing.module';

import { SolComprasItensPage } from './sol-compras-itens.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    SolComprasItensPageRoutingModule
  ],
  declarations: [SolComprasItensPage]
})
export class SolComprasItensPageModule {}
