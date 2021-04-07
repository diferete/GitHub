import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProdSteelPageRoutingModule } from './prod-steel-routing.module';

import { ProdSteelPage } from './prod-steel.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProdSteelPageRoutingModule
  ],
  declarations: [ProdSteelPage]
})
export class ProdSteelPageModule {}
