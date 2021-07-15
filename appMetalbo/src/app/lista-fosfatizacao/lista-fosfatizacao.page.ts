import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';

@Component({
  selector: 'app-lista-fosfatizacao',
  templateUrl: './lista-fosfatizacao.page.html',
  styleUrls: ['./lista-fosfatizacao.page.scss'],
})
export class ListaFosfatizacaoPage implements OnInit {
  dataMes: string;
  data: any;
  total: any;

  listaDiario = [];

  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public fatMetalboService: FatMetalboService,
    public alertController: AlertController,
    public StorageServ: StorageService,
    public loadingController: LoadingController
  ) {
    this.data = new Date();
    this.dataMes = new Date().toDateString();
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
    this.total = '0';
    this.getLista();
  }

  //pull do refresh
  doRefresh(event) {
    this.getLista();

    setTimeout(() => {
      console.log('Async operation has ended');
      event.target.complete();
    }, 2000);
  }

  //chama função para carrega os dados
  getLista() {
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
        // console.log('data tela ' + this.dataMes);
        return this.fatMetalboService.getListaEsperaFosfatizacao(usutoken, usucod, this.dataMes);
      })
      .then((result: any) => {
        // this.listaDiario = result.DADOS.total;
        this.total = result.DADOS.total;
        this.listaDiario = result.DADOS.lista;

        // console.log('total php ' + result.DADOS.lista);
      });
  }

  //abre tela detalhe
  getDadosDetalhe(dataconv) {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: dataconv,
      },
    };
    console.log(navigationExtras);
    this.router.navigate(['lista-fofatizacao-detalhe'], navigationExtras);
  }
}
