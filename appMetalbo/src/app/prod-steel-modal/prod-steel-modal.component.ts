import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-prod-steel-modal',
  templateUrl: './prod-steel-modal.component.html',
  styleUrls: ['./prod-steel-modal.component.scss'],
})
export class ProdSteelModalComponent implements OnInit {
  val: any;
  constructor(private modalCtrl: ModalController) {
    console.log(this.val);
  }

  dismissModal() {
    this.modalCtrl.dismiss();
  }
  ngOnInit() {}
}
