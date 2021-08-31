import { Component, OnInit } from '@angular/core';
import { StorageService } from '../api/storage.service';
import { AlertController } from '@ionic/angular';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { Router, NavigationExtras } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-prod-steel',
  templateUrl: './prod-steel.page.html',
  styleUrls: ['./prod-steel.page.scss'],
})
export class ProdSteelPage implements OnInit {
  dataMes: string;
  data: any;
  totalProducao: any;
  totalFornos: any;
  totalFio: any;
  prodDiario: [];

  constructor(
    private StorageServ: StorageService,
    public alertController: AlertController,
    public fatMetalboService: FatMetalboService,
    private route: ActivatedRoute,
    public router: Router
  ) {
    (this.data = new Date()), (this.dataMes = new Date().toDateString());
    //this.dataMes = new Date().toString().slice(0, 10);
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
    this.totalProducao = '0 Kg';
    this.totalFornos = '0 Kg';
    this.totalFio = '0 Kg';
    this.getProd();
  }

  doRefresh(event) {
    this.getProd();

    setTimeout(() => {
      console.log('Async operation has ended');
      event.target.complete();
    }, 2000);
  }

  //chama função para carrega os dados da produção
  getProd() {
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
        return this.fatMetalboService.getProdSteel(usutoken, usucod, this.dataMes);
      })
      .then((result: any) => {
        this.totalProducao = result.DADOS.totalMensal;
        this.totalFornos = result.DADOS.totalMensalForno;
        this.totalFio = result.DADOS.totalMensalFio;

        this.prodDiario = result.DADOS.diario;
        //console.log(this.prodDiario);
      });
  }

  //chama tela de detalhe
  getDadosProdDetalhe(p) {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: p,
      },
    };
    //console.log(navigationExtras);
    this.router.navigate(['prod-steel-detalhe'], navigationExtras);
  }
}
