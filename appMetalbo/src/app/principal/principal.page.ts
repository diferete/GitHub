import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { PainelfatprodService } from '../api/painelfatprod.service';
import { AlertController } from '@ionic/angular';
import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';
import { StatusBar } from '@ionic-native/status-bar/ngx';


@Component({
    selector: 'app-principal',
    templateUrl: './principal.page.html',
    styleUrls: ['./principal.page.scss'],
})
export class PrincipalPage implements OnInit {
    loading: any;

    constructor(public router: Router,
        public menu: MenuController,
        private route: ActivatedRoute,
        public painelFatprodService: PainelfatprodService,
        public alertController: AlertController,
        public Storage: NativeStorage,
        public StorageServ: StorageService,
        public loadingController: LoadingController,
        private statusBar: StatusBar) { }



    //CONEXÃO INTERNET
    async mensagemAlertInternet() {
        const alert = await this.alertController.create({
            header: 'Atenção!',
            subHeader: 'Verifique sua conexão com a internet.',
            message: 'Dados não ativos.',
            buttons: ['OK'],
        });

        await alert.present();
    }



    //CONEXÃO INTERNET
    async mensagemToken() {
        const alert = await this.alertController.create({
            header: 'Atenção!',
            subHeader: 'Seu Token não é válido.',
            message: 'É necessário fazer login no aplicativo novamente!',
            buttons: ['OK'],
        });

        await alert.present();
    }

    //variáveis do título do painel
    painelFatMetalbo: any;
    painelFatSteel: any;
    painelPedMetalbo: any;
    painelProdMetalbo: any;
    painelProdSteel: any;
    //dados enviar
    storeUsucod: any;
    storeUsuToken: any;
    /*Páginas iniciais*/
    painelDadosFatMetalbo = [];
    painelDadosFatSteel = [];
    painelDadosPedMetalbo = [];
    painelDadosProdMetalbo = [];
    painelDadosProdSteel = [];
    //Dados para enviar
    dadosEnv = [];

    ngOnInit(): void {
        this.menu.enable(true);
    }

    ionViewWillEnter() {
        this.menu.enable(true);

        // this.statusBar.overlaysWebView(true);
        this.statusBar.backgroundColorByHexString('#cc181e');
        //  this.presentLoading('Espere');

        this.getPainelFat();

        /*   setTimeout(() => {
               this.loading.dismiss();
           },2000); */
    }

    //MENSAGEM DE LOADING
    async presentLoading(message: string) {

        this.loading = await this.loadingController.create({
            message
        });
        return this.loading.present();
    }

    doRefresh(event) {

        setTimeout(() => {
            this.getPainelFat()
            console.log('Async operation has ended');
            event.target.complete();
        }, 1000);

    }

    getPainelFat() {

        //variáveis usuário e token
        let usutoken;
        let usucod;
        //solicita o token do storage
        this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
                console.log(usutoken);
                //solicita o código do usuário
                this.StorageServ.retornaUsuCod()
                    .then((result: any) => {
                        usucod = result;
                        //solicita os dados do servidor sistema.metalbo.com.br
                        this.painelFatprodService.getPainel(usutoken, usucod)
                            .then((result: any) => {
                                //verifica se o token é válido
                                if (result.bTOKEN == false) {
                                    console.log('Token inválido!');
                                    this.mensagemToken();
                                    this.StorageServ.removeDados();
                                    this.router.navigate(['/auth/login']);
                                } else {
                                    //libera os dados para o painel
                                    this.painelFatMetalbo = result.DADOS.PainelFatMetalbo;
                                    this.painelDadosFatMetalbo = result.DADOS.FatMetalbo;

                                    this.painelPedMetalbo = result.DADOS.PainelPedMetalbo;
                                    this.painelDadosPedMetalbo = result.DADOS.pedMetalbo;

                                    this.painelFatSteel = result.DADOS.PainelFatSteel;
                                    this.painelDadosFatSteel = result.DADOS.FatSteel;

                                    this.painelProdMetalbo = result.DADOS.PainelProdMetalbo;
                                    this.painelDadosProdMetalbo = result.DADOS.ProdMetalbo;

                                    this.painelProdSteel = result.DADOS.PainelProdSteel;
                                    this.painelDadosProdSteel = result.DADOS.ProdSteel;

                                }
                            });

                    });
            });

        //this.painelProdSteel = 'Painel Produção SteelTrater';

        /*  this.painelFatprodService.getPainel(usutoken).then((result: any) => {

                    this.painelFatMetalbo = result.DADOS.PainelFatMetalbo;
                    this.painelDadosFatMetalbo = result.DADOS.FatMetalbo;

                    this.painelPedMetalbo = result.DADOS.PainelPedMetalbo;
                    this.painelDadosPedMetalbo = result.DADOS.pedMetalbo;

                    this.painelFatSteel = result.DADOS.PainelFatSteel;
                    this.painelDadosFatSteel = result.DADOS.FatSteel;

                    this.painelProdMetalbo = result.DADOS.PainelProdMetalbo;
                    this.painelDadosProdMetalbo = result.DADOS.ProdMetalbo;
                    });*/

    }

    //Método para voltar tela logout
    logout() {
        this.StorageServ.removeDados();
        this.router.navigate(['/auth/login']);
    }

    getPedCompra() {
        this.router.navigate(['ped-compra-metalbo']);
    }

}
