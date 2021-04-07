import { Component, OnInit } from '@angular/core';
import { AlertController } from '@ionic/angular';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { Router, NavigationExtras } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { StorageService } from '../api/storage.service';

@Component({
  selector: 'app-prod-metalbo',
  templateUrl: './prod-metalbo.page.html',
  styleUrls: ['./prod-metalbo.page.scss'],
})
export class ProdMetalboPage implements OnInit {

    dataMes: string;
    data: any;
    empresa: any;
    totalMensal: any;
    totalParaf: any;
    totalPorca: any;
    totalMaqQuente: any;

    prodDiario: [];

    constructor(public router: Router,
        public alertController: AlertController,
        public fatMetalboService: FatMetalboService,
        private route: ActivatedRoute,
        private StorageServ: StorageService) {
            this.data = new Date(),
            //this.dataMes = new Date().toISOString();
            this.dataMes = new Date().toDateString();
            this.empresa = 'filial';
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
        this.getProd();    
    }

    ngOnInit() {
    }

    //pull do refresh
    doRefresh(event) {
        this.getProd();

        setTimeout(() => {
            console.log('Async operation has ended');
            event.target.complete();
        }, 2000);
    }

    //função que pega produção 
    //chama função para carrega os dados do faturamento
    getProd() {
        //variáveis usuário e token
        let usutoken;
        let usucod;

        this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
                return this.StorageServ.retornaUsuCod();
            }).then((result: any) => {
                usucod = result;
                return this.fatMetalboService.getProdMetaldo(usutoken, usucod, this.dataMes, this.empresa);
            }).then((result: any) => {
                this.totalMensal = result.DADOS.totalMensal;
                this.totalParaf = result.DADOS.totalParaf;
                this.totalPorca = result.DADOS.totalPorca;
                this.totalMaqQuente = result.DADOS.maqquente;



                this.prodDiario = result.DADOS.diario;
            });

       /* this.fatMetalboService.getProdMetaldo(this.dataMes, this.empresa).then((result: any) => {
            this.totalMensal = result.DADOS.totalMensal;
            this.totalParaf = result.DADOS.totalParaf;
            this.totalPorca = result.DADOS.totalPorca;
            this.totalMaqQuente = result.DADOS.maqquente;

            

            this.prodDiario = result.DADOS.diario;
           

        })
            .catch((error: any) => {
                this.mensagemAlertInternet();
            });
       
       */
    }

    //abre tela detalhe
    getDadosProd(dataconv) {
        let navigationExtras: NavigationExtras = {
            state: {
                valorParaEnviar: dataconv
            }
        };
        console.log(navigationExtras);
        this.router.navigate(['prod-metalbo-detalhe'], navigationExtras);
    }

}
