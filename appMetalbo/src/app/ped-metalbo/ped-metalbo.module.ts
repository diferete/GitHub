import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PedMetalboPageRoutingModule } from './ped-metalbo-routing.module';

import { PedMetalboPage } from './ped-metalbo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PedMetalboPageRoutingModule
  ],
  declarations: [PedMetalboPage]
})
export class PedMetalboPageModule {}
