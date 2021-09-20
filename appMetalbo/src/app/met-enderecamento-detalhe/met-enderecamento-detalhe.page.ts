import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { AlertController, NavController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';
import { EnderecamentoService } from '../api/enderecamento.service';

@Component({
  selector: 'app-met-enderecamento-detalhe',
  templateUrl: './met-enderecamento-detalhe.page.html',
  styleUrls: ['./met-enderecamento-detalhe.page.scss'],
})
export class MetEnderecamentoDetalhePage implements OnInit {
  dados: any;
  codigo: any;
  prodes: any;
  est: any;
  nvl: any;
  col: any;
  tip: any;
  estante = '';
  nivel = '';
  coluna = '';
  tipo = '';
  endereco: [];

  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public enderecamentoService: EnderecamentoService,
    public alertController: AlertController,
    private navCtrl: NavController,
    public StorageServ: StorageService,
    public loadingController: LoadingController
  ) {
    this.route.queryParams.subscribe((params) => {
      let getNav = this.router.getCurrentNavigation();
      if (getNav.extras.state) {
        this.dados = getNav.extras.state.valorParaEnviar;
        console.log(this.dados);
        this.codigo = this.dados.procod;
        this.estante = this.dados.estante;
        this.nivel = this.dados.nivel;
        this.coluna = this.dados.coluna;
        this.tipo = this.dados.cod;
        this.prodes = this.dados.prodes;
      }
    });
  }

  ngOnInit() {}

  msgUpdateEndereco(dados) {
    this.AlertConfirm(dados);
  }

  async AlertConfirm(dados) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message:
        'Deseja alterar o endereço do item <strong>' +
        dados.procod +
        '</strong> para o endereço: <strong>' +
        this.estante +
        ' ' +
        this.nivel +
        ' ' +
        this.coluna +
        '</strong>',
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: (blah) => {},
        },
        {
          text: 'Sim',
          handler: () => {
            this.updateEndereco(dados);
          },
        },
      ],
    });

    await alert.present();
  }

  updateEndereco(dados) {
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
        this.est = this.estante;
        this.nvl = this.nivel;
        this.col = this.coluna;
        this.tip = this.tipo;
        return this.enderecamentoService.updateEndereco(
          usutoken,
          usucod,
          this.est,
          this.nvl,
          this.col,
          this.tip,
          dados.procod,
          dados.armcod
        );
      })
      .then((result: any) => {
        if (result.DADOS.retorno == true) {
          this.mensagemSucessoRetorno();
          this.voltar();
        } else {
          this.mensagemErroRetorno(result.DADOS);
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
  async mensagemErroRetorno(mensagem) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Erro',
      message: mensagem,
      buttons: ['OK'],
    });

    await alert.present();
  }

  //sucesso
  async mensagemSucessoRetorno() {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      subHeader: 'Endereço atualizado!',
      message: '',
      buttons: ['OK'],
    });

    await alert.present();
  }
  voltar() {
    this.navCtrl.back();
  }
}
