import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProdMetalboPageRoutingModule } from './prod-metalbo-routing.module';

import { ProdMetalboPage } from './prod-metalbo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProdMetalboPageRoutingModule
  ],
  declarations: [ProdMetalboPage]
})
export class ProdMetalboPageModule {}
