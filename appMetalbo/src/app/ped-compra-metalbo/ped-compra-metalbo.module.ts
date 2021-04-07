import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PedCompraMetalboPageRoutingModule } from './ped-compra-metalbo-routing.module';

import { PedCompraMetalboPage } from './ped-compra-metalbo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PedCompraMetalboPageRoutingModule
  ],
  declarations: [PedCompraMetalboPage]
})
export class PedCompraMetalboPageModule {}
