import { Component, Injectable, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AlertController, NavController } from '@ionic/angular';
import { SolComprasService } from '../api/sol-compras.service';
import { StorageService } from '../api/storage.service';
import { NavigationExtras } from '@angular/router';

@Component({
  selector: 'app-sol-compras-detalhe',
  templateUrl: './sol-compras-detalhe.page.html',
  styleUrls: ['./sol-compras-detalhe.page.scss'],
})
export class SolComprasDetalhePage implements OnInit {
  dados: any;
  nr: any;
  data: any;
  solicitante: any;
  itens: [];
  situacao: any;
  cnpj: any;

  constructor(
    public alertController: AlertController,
    public StorageServ: StorageService,
    private route: ActivatedRoute,
    private router: Router,
    private navCtrl: NavController,
    public solComprasService: SolComprasService
  ) {
    this.route.queryParams.subscribe((params) => {
      let getNav = this.router.getCurrentNavigation();
      if (getNav.extras.state) {
        this.dados = getNav.extras.state.valorParaEnviar;
        this.cnpj = this.dados.cnpj;
        this.nr = this.dados.nr;
        this.data = this.dados.data;
        this.solicitante = this.dados.solicitante;
        this.itens = this.dados.itens;
      }
    });
  }

  ngOnInit() {}
  voltar() {
    this.navCtrl.back();
  }
  //mensagem liberacao
  msgLiberaLista(sit) {
    this.AlertConfirm(sit);
  }

  //mensagem confirmação
  async AlertConfirm(sit) {
    if (sit == 'a') {
      this.situacao = 'APROVAR';
    } else if (sit == 'r') {
      this.situacao = 'REPROVAR';
    }
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Deseja <strong>' + this.situacao + '</strong> solicitação número: <strong>' + this.nr + ' </strong>?',
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: () => {},
        },
        {
          text: this.situacao,
          handler: () => {
            this.setLiberado(sit);
          },
        },
      ],
    });
    await alert.present();
  }

  setLiberado(sit) {
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
        return this.solComprasService.gerenSolicitacaoCompra(usutoken, usucod, sit, this.nr, this.cnpj);
      })
      .then((result: any) => {
        if (result.DADOS.retorno == true) {
          this.mensagemSucessoRetorno(result.DADOS.mensagem);
          this.navBack();
        } else {
          this.mensagemErroRetorno(result.DADOS.erro, result.DADOS.mensagem, result.DADOS.param);
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
  async mensagemErroRetorno(erro, mensagem, param) {
    if (param == 'C') {
      const alert = await this.alertController.create({
        header: 'Atenção!',
        subHeader: erro,
        message: erro,
        buttons: ['OK'],
      });

      await alert.present();
    } else {
      const alert = await this.alertController.create({
        header: 'Atenção!',
        subHeader: 'Não foi possível ' + mensagem + ' a solicitação!',
        message: erro,
        buttons: ['OK'],
      });

      await alert.present();
    }
  }

  //sucesso
  async mensagemSucessoRetorno(mensagem) {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      subHeader: 'Solicitação ' + mensagem + '!',
      message: '',
      buttons: ['OK'],
    });

    await alert.present();
  }

  listaItens() {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: this.dados,
      },
    };
    this.router.navigate(['sol-compras-itens'], navigationExtras);
  }

  navBack() {
    this.router.navigate(['sol-compras']);
  }
}
