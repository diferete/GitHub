import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { SolComprasService } from '../api/sol-compras.service';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';

@Component({
  selector: 'app-sol-compras',
  templateUrl: './sol-compras.page.html',
  styleUrls: ['./sol-compras.page.scss'],
})
export class SolComprasPage implements OnInit {
  cnpj: any;
  contador: number;

  aSolCompra: [];
  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public solComprasService: SolComprasService,
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

  ngOnInit() {}

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

  ionViewWillEnter() {
    this.getSolCompras();
  }

  getSolCompras() {
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
        return this.solComprasService.getSolCompras(usutoken, usucod);
      })
      .then((result: any) => {
        this.aSolCompra = result.DADOS.solicitacoes;
        this.contador = result.DADOS.contador;
      });
  }

  getDadosSolCompras(nr) {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: nr,
      },
    };
    this.router.navigate(['sol-compras-detalhe'], navigationExtras);
  }

  //pull do refresh
  doRefresh(event) {
    setTimeout(() => {
      this.getSolCompras();
      event.target.complete();
    }, 1000);
  }
}
