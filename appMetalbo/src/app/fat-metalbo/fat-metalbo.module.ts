import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { FatMetalboPageRoutingModule } from './fat-metalbo-routing.module';
import { FatMetalboPage } from './fat-metalbo.page';


@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    FatMetalboPageRoutingModule
  ],
  declarations: [FatMetalboPage]
})
export class FatMetalboPageModule {}
