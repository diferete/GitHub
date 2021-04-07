import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PedPoliamidosPageRoutingModule } from './ped-poliamidos-routing.module';

import { PedPoliamidosPage } from './ped-poliamidos.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PedPoliamidosPageRoutingModule
  ],
  declarations: [PedPoliamidosPage]
})
export class PedPoliamidosPageModule {}
