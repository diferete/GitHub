import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';


@Component({
  selector: 'app-lista-fofatizacao-detalhe',
  templateUrl: './lista-fofatizacao-detalhe.page.html',
  styleUrls: ['./lista-fofatizacao-detalhe.page.scss'],
})
export class ListaFofatizacaoDetalhePage implements OnInit {
    dados: any;
    codigo: any;
    descmat: any;
    prioridade: any;
    sit: any;
    seq: any;

    constructor(private route: ActivatedRoute, private router: Router,
        public menu: MenuController,
        public fatMetalboService: FatMetalboService,
        public alertController: AlertController,
        public StorageServ: StorageService,
        public loadingController: LoadingController) {
        this.route.queryParams.subscribe(params => {
            let getNav = this.router.getCurrentNavigation();
            if (getNav.extras.state) {
                this.dados = getNav.extras.state.valorParaEnviar;
                console.log(this.dados);
                this.codigo = this.dados.codmt;
                this.descmat = this.dados.descmat;
                this.prioridade = this.dados.seqprio;
                this.sit = this.dados.situacao;
                this.seq = this.dados.seq;
                
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

    //erro retorno
    async mensagemErroRetorno(erro) {
        const alert = await this.alertController.create({
            header: 'Atenção!',
            subHeader: 'Não foi possível liberar a entrada!',
            message: erro,
            buttons: ['OK'],
        });

        await alert.present();
    }

    //sucesso
    async mensagemSucessoRetorno() {
        const alert = await this.alertController.create({
            header: 'Sucesso!',
            subHeader: 'Entrada liberada.',
            message: '',
            buttons: ['OK'],
        });

        await alert.present();
    }
    

    //mensagem confirmação
    async AlertConfirm() {
        const alert = await this.alertController.create({
            //cssClass: 'my-custom-class',
            header: 'Atenção!',
            message: 'Deseja liberar a entrada <strong>' + this.seq + ' para o pátio da fosfatização?</strong>!!!',
            buttons: [
                {
                    text: 'Cancelar',
                    role: 'cancel',
                  //  cssClass: 'secondary',
                    handler: (blah) => {
                        //console.log('Confirm Cancel: blah');
                    }
                }, {
                    text: 'Sim quero liberar!',
                    handler: () => {
                        this.setLiberado();
                    }
                }
            ]
        });

        await alert.present();
    }

  ngOnInit() {
  }

    //mensagem liberacao
    msgLiberaLista() {
        this.AlertConfirm();
    }


    setLiberado() {
        console.log('param ' + this.seq);

        //variáveis usuário e token
        let usutoken;
        let usucod;

        this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
                return this.StorageServ.retornaUsuCod();
            }).then((result: any) => {
                usucod = result;
                // console.log('data tela ' + this.dataMes);
                return this.fatMetalboService.setListaEsperaFosfatizacao(usutoken, usucod,this.seq);
            }).then((result: any) => {
                if (result.DADOS.retorno == true) {
                    this.mensagemSucessoRetorno();
                    this.voltar();
                } else {
                    this.mensagemErroRetorno(result.DADOS.mensagem);
                }
             });
    }

    voltar() {
        this.router.navigate(['lista-fosfatizacao']);
    }

}
