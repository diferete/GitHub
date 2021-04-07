import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';

@Component({
  selector: 'app-fat-steel',
  templateUrl: './fat-steel.page.html',
  styleUrls: ['./fat-steel.page.scss'],
})
export class FatSteelPage implements OnInit {

    dataMes: string;
    data: any;
    totalServico: any;
    totalInsumo: any;
    pesoPoPf: any;
    pesoMaq: any;
    totalFat: any;
    fatDiario = [];

    constructor(public router: Router,
        public menu: MenuController,
        public fatMetalboService: FatMetalboService,
        private route: ActivatedRoute,
        public alertController: AlertController,
        public StorageServ: StorageService) {
            this.data = new Date(),
           // this.dataMes = new Date().toISOString();
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

      ngOnInit() {
      }
    ionViewWillEnter() {
        this.totalServico = 'R$ 0';
        this.totalInsumo = 'R$ 0';
        this.pesoPoPf = '0 Kg';
        this.pesoMaq = '0 Kg';
        this.getFat();
        //this.fatMetalboService.getFatMetalbo(this.dataMes);
    }
    //abre tela detalhe
    getDadosFat(dataconv) {
        let navigationExtras: NavigationExtras = {
            state: {
                valorParaEnviar: dataconv
            }
        };
        console.log(navigationExtras);
        this.router.navigate(['fat-steel-detalhe'], navigationExtras);
    }
    //pull do refresh
    doRefresh(event) {
        this.getFat();

        setTimeout(() => {
            console.log('Async operation has ended');
            event.target.complete();
        }, 2000);
    }

    //chama função para carrega os dados do faturamento
    getFat() {
        //variáveis usuário e token
        let usutoken;
        let usucod;

        this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
                return this.StorageServ.retornaUsuCod();
            }).then((result: any) => {
                usucod = result;
                return this.fatMetalboService.getFatSteel(usutoken, usucod, this.dataMes);
            }).then((result: any) => {
                this.totalServico = result.DADOS.totalServico;
                this.totalInsumo = result.DADOS.totalInsumo;
                this.pesoPoPf = result.DADOS.totalPoPf;
                this.pesoMaq = result.DADOS.totalFio;
                this.totalFat = result.DADOS.totalFat;

                this.fatDiario = result.DADOS.diario;
            });
    }

}
