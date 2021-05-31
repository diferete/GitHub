import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { PedCompraMetalboService } from '../api/ped-comprametalbo.service';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';

@Component({
  selector: 'app-ped-compra-metalbo',
  templateUrl: './ped-compra-metalbo.page.html',
  styleUrls: ['./ped-compra-metalbo.page.scss'],
})
export class PedCompraMetalboPage implements OnInit {
  cnpj: any;
  empresa: any;
  contador: number;

  aPedCompra: [];

  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public pedCompraMetalboService: PedCompraMetalboService,
    public alertController: AlertController,
    public StorageServ: StorageService,
    public loadingController: LoadingController
  ) {
    this.route.queryParams.subscribe((params) => {
      let getNav = this.router.getCurrentNavigation();
      if (getNav.extras.state) {
        this.cnpj = getNav.extras.state.valorParaEnviar;
      }
    });
  }
  //mensagem internet
  async mensagemAlertInternet() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Verifique sua conexão com a internet.',
      message: 'Dados não ativos.',
      buttons: ['OK'],
    });

    await alert.present();
  }
  ngOnInit() {}

  ionViewWillEnter() {
    this.getPedCompras();
  }

  getPedCompras() {
    //variáveis usuário e token
    let usutoken;
    let usucod;
    this.StorageServ.retornaToken()
      .then((result: any) => {
        usutoken = result;
        return this.StorageServ.retornaUsuCod();
      })
      .then((result: any) => {
        usucod = result;
        return this.pedCompraMetalboService.getPedCompras(usutoken, usucod, this.cnpj);
      })
      .then((result: any) => {
        console.log(result.DADOS);
        this.aPedCompra = result.DADOS.pedidos;
        this.empresa = result.DADOS.empresa;
        this.contador = result.DADOS.contador;
      });
  }

  getDadosPedCompras(sup_pedidoseq) {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: sup_pedidoseq,
      },
    };
    this.router.navigate(['ped-compras-detalhe'], navigationExtras);
  }

  //pull do refresh
  doRefresh(event) {
    setTimeout(() => {
      this.getPedCompras();
      event.target.complete();
    }, 1000);
  }
}
