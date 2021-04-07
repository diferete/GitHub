import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProdPoliamidosPageRoutingModule } from './prod-poliamidos-routing.module';

import { ProdPoliamidosPage } from './prod-poliamidos.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProdPoliamidosPageRoutingModule
  ],
  declarations: [ProdPoliamidosPage]
})
export class ProdPoliamidosPageModule {}
