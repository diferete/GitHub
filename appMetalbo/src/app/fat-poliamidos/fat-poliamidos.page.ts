import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-fat-poliamidos',
  templateUrl: './fat-poliamidos.page.html',
  styleUrls: ['./fat-poliamidos.page.scss'],
})
export class FatPoliamidosPage implements OnInit {
  dataInicial: string;
  dataFinal: string;
    data: any;

    constructor(public router: Router,
        public menu: MenuController,
        private route: ActivatedRoute) {
        this.dataFinal = new Date().toISOString(),
            this.data = new Date(),
            this.dataInicial = new Date(this.data.getFullYear(), this.data.getMonth(), 1).toISOString(); ///'1/' + this.data.getDate() + '/' + this.data.getFullYear();
        console.log(this.dataInicial); }

  ngOnInit() {
  }

}
