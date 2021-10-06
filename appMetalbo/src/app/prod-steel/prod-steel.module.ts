import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProdSteelPageRoutingModule } from './prod-steel-routing.module';

import { ProdSteelPage } from './prod-steel.page';
import { ProdSteelModalComponent } from '../prod-steel-modal/prod-steel-modal.component';

@NgModule({
  imports: [CommonModule, FormsModule, IonicModule, ProdSteelPageRoutingModule],
  declarations: [ProdSteelPage, ProdSteelModalComponent],
  entryComponents: [ProdSteelModalComponent],
})
export class ProdSteelPageModule {}
