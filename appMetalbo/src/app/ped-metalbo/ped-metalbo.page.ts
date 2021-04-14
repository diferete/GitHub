import { Component, OnInit } from '@angular/core';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { AlertController } from '@ionic/angular';
import { Router, NavigationExtras } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';

@Component({
    selector: 'app-ped-metalbo',
    templateUrl: './ped-metalbo.page.html',
    styleUrls: ['./ped-metalbo.page.scss'],
})
export class PedMetalboPage implements OnInit {

    dataMes: string;
    data: any;
    vlrTotal: any;
    pesoTotal: any;

    pedDiario = [];

    constructor(public router: Router,
        public menu: MenuController,
        private route: ActivatedRoute,
        public fatMetalboService: FatMetalboService,
        public alertController: AlertController,
        public StorageServ: StorageService) {
        this.data = new Date(),
            //this.dataMes = new Date().toISOString();
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

    ionViewWillEnter() {
        this.vlrTotal = 'R$ 0';
        this.pesoTotal = '0 Kg';
        this.getPed();

    }

    ngOnInit() {
    }

    //pull do refresh
    doRefresh(event) {
        this.getPed();

        setTimeout(() => {
            console.log('Async operation has ended');
            event.target.complete();
        }, 2000);
    }

    //abre tela detalhe
    getDadosPed(dataconv) {
        let navigationExtras: NavigationExtras = {
            state: {
                valorParaEnviar: dataconv
            }
        };
        console.log(navigationExtras);
        this.router.navigate(['ped-metalbo-detalhe'], navigationExtras);
    }

    //chama função para carrega os dados
    getPed() {
        //variáveis usuário e token
        let usutoken;
        let usucod;

        this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
                return this.StorageServ.retornaUsuCod();
            }).then((result: any) => {
                usucod = result;
                return this.fatMetalboService.getPedMetalbo(usutoken, usucod, this.dataMes);
            }).then((result: any) => {
                console.log(result.DADOS);
                this.vlrTotal = result.DADOS.vlrcomipi;
                this.pesoTotal = result.DADOS.pesoMes;

                this.pedDiario = result.DADOS.diario;
            });
    }
}
