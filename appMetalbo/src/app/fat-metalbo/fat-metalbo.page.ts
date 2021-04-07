import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';


@Component({
    selector: 'app-fat-metalbo',
    templateUrl: './fat-metalbo.page.html',
    styleUrls: ['./fat-metalbo.page.scss'],
})
export class FatMetalboPage implements OnInit {


    dataMes: string;
    data: any;
    vlrTotal: any;
    pesoTotal: any;

    fatDiario = [];

    constructor(public router: Router,
        public menu: MenuController,
        private route: ActivatedRoute,
        public fatMetalboService: FatMetalboService,
        public alertController: AlertController,
        public StorageServ: StorageService,
        public loadingController: LoadingController) {
        this.data = new Date();
        //this.dataMes = new Date().toString();
        this.dataMes = new Date().toDateString();
        //this.dataMes = new Date().toString().slice(0, 10); //toString();

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
        this.vlrTotal = 'R$ 0';
        this.pesoTotal = '0 Kg';
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
        //console.log(navigationExtras);
        this.router.navigate(['fat-metalbo-detalhe'], navigationExtras);
    }
    //pull do refresh
    doRefresh(event) {
        this.getFat();

        setTimeout(() => {
            //console.log('Async operation has ended');
            event.target.complete();
        }, 2000);
    }
    //chama função para carrega os dados
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
                //console.log('data tela ' + this.dataMes);
                return this.fatMetalboService.getFatMetalbo(usutoken, usucod, this.dataMes);
            }).then((result: any) => {
                this.vlrTotal = result.DADOS.total;
                this.pesoTotal = result.DADOS.totalPeso;

                this.fatDiario = result.DADOS.diario;

                //console.log('teste dados '+result.DADOS.diario);
            });

    }
}
