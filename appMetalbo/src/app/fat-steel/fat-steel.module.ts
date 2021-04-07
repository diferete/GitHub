import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { FatSteelPageRoutingModule } from './fat-steel-routing.module';

import { FatSteelPage } from './fat-steel.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    FatSteelPageRoutingModule
  ],
  declarations: [FatSteelPage]
})
export class FatSteelPageModule {}
