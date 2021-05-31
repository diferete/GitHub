import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { SolComprasPageRoutingModule } from './sol-compras-routing.module';

import { SolComprasPage } from './sol-compras.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    SolComprasPageRoutingModule
  ],
  declarations: [SolComprasPage]
})
export class SolComprasPageModule {}
