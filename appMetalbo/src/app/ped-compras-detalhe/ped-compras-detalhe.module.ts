import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PedComprasDetalhePageRoutingModule } from './ped-compras-detalhe-routing.module';

import { PedComprasDetalhePage } from './ped-compras-detalhe.page';
import { ModalItensComponent } from '../modal-itens/modal-itens.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PedComprasDetalhePageRoutingModule
  ],
  declarations: [PedComprasDetalhePage, ModalItensComponent],
  entryComponents: [ModalItensComponent]
})
export class PedComprasDetalhePageModule { }
