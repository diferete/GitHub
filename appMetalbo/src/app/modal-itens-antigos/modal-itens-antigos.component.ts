import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-modal-itens-antigos',
  templateUrl: './modal-itens-antigos.component.html',
  styleUrls: ['./modal-itens-antigos.component.scss'],
})
export class ModalItensAntigosComponent implements OnInit {
  itens: [];
  constructor(private modalCtrl: ModalController) {}

  dismissModal() {
    this.modalCtrl.dismiss();
  }

  ngOnInit() {}
}
