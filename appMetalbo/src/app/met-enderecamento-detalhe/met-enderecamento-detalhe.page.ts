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
  armcod: any;
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
    console.log(dados);
    if (dados.tipo == 'F') {
      this.mensagemTipoEnd();
    } else {
      this.AlertConfirmUpdateEndereco(dados);
    }
  }
  //validação tipo end
  async mensagemTipoEnd() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Endereços do tipo <strong>F - FIXO </strong>não podem ser alterados.',
      buttons: ['OK'],
    });

    await alert.present();
  }

  async AlertConfirmUpdateEndereco(dados) {
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
        console.log(dados.armcod);
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
          this.mensagemSucessoRetornoUpdateEnd();
          this.voltar();
        } else {
          this.mensagemErroRetornoUpdateEnd(result.DADOS);
        }
      });
  }

  msgUpdateAddListaEspera(dados) {
    this.AlertConfirmAddListaEspera(dados);
  }

  async AlertConfirmAddListaEspera(dados) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Deseja dar <strong>BAIXA DA EXPEDIÇÃO</strong> do item <strong>' + dados.procod + '</strong>?',
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: (blah) => {},
        },
        {
          text: 'Sim',
          handler: () => {
            this.updateAddListaEspera(dados);
          },
        },
      ],
    });

    await alert.present();
  }

  updateAddListaEspera(dados) {
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
        return this.enderecamentoService.updateAddListaEspera(
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
          this.mensagemSucessoRetornoAddListaEspera();
          this.voltar();
        } else {
          this.mensagemErroRetornoAddListaEspera(result.DADOS);
        }
      });
  }

  //erro retorno
  async mensagemErroRetornoUpdateEnd(mensagem) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Erro',
      message: mensagem,
      buttons: ['OK'],
    });

    await alert.present();
  }

  //sucesso
  async mensagemSucessoRetornoUpdateEnd() {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      subHeader: 'Endereço atualizado!',
      message: '',
      buttons: ['OK'],
    });

    await alert.present();
  }

  //erro retorno
  async mensagemErroRetornoAddListaEspera(mensagem) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: mensagem,
      buttons: ['OK'],
    });

    await alert.present();
  }

  //sucesso
  async mensagemSucessoRetornoAddListaEspera() {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      message: 'Item atualizado!',
      buttons: ['OK'],
    });

    await alert.present();
  }

  voltar() {
    this.navCtrl.back();
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
}
