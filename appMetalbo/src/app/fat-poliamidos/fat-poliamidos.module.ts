import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { FatPoliamidosPageRoutingModule } from './fat-poliamidos-routing.module';

import { FatPoliamidosPage } from './fat-poliamidos.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    FatPoliamidosPageRoutingModule
  ],
  declarations: [FatPoliamidosPage]
})
export class FatPoliamidosPageModule {}
