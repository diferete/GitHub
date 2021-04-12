import { Component, Input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';


@Component({
  selector: 'app-modal-itens',
  templateUrl: './modal-itens.component.html',
  styleUrls: ['./modal-itens.component.scss'],
})
export class ModalItensComponent implements OnInit {

  itens: [];
  constructor(private modalCtrl: ModalController) {

  }

  dismissModal() {
    this.modalCtrl.dismiss();
  }

  ngOnInit() {

  }



}
