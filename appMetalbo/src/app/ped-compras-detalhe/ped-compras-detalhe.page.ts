import { Component, Injectable, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AlertController, NavController } from '@ionic/angular';
import { ModalController } from '@ionic/angular';
import { ModalItensComponent } from '../modal-itens/modal-itens.component';
import { PedCompraMetalboService } from '../api/ped-comprametalbo.service';
import { StorageService } from '../api/storage.service';
import { analyzeAndValidateNgModules } from '@angular/compiler';


@Component({
  selector: 'app-ped-compras-detalhe',
  templateUrl: './ped-compras-detalhe.page.html',
  styleUrls: ['./ped-compras-detalhe.page.scss'],
})
export class PedComprasDetalhePage implements OnInit {

  dados: any;
  nr: any;
  data: any;
  fornecedor: any;
  itens: [];
  valorTotal: any;
  solicitante: any;
  observacao: any;
  valorFrete: any;
  cnpj: any;
  teste: any;


  constructor(public alertController: AlertController, public StorageServ: StorageService,
    private route: ActivatedRoute,
    private router: Router,
    private navCtrl: NavController,
    private modalCtrl: ModalController,
    public pedCompraMetalboService: PedCompraMetalboService,) {
    this.route.queryParams.subscribe(params => {
      let getNav = this.router.getCurrentNavigation();
      if (getNav.extras.state) {
        this.dados = getNav.extras.state.valorParaEnviar;
        this.nr = this.dados.nr;
        this.data = this.dados.data;
        this.fornecedor = this.dados.fornecedor;
        this.itens = this.dados.itens;
        this.valorTotal = this.dados.valorTotal;
        this.solicitante = this.dados.usuario;
        this.observacao = this.dados.observacao;
        this.valorFrete = this.dados.valorFrete;
        this.cnpj = this.dados.cnpj;
      }
    });
  }

  ngOnInit() {
  }
  voltar() {
    this.navCtrl.back();
  }
  async modalItens() {
    const modal = await this.modalCtrl.create({
      component: ModalItensComponent, componentProps: { itens: this.itens }
    });
    await modal.present();
  }

  gerenPedidoCompra(sit) {
    //variáveis usuário e token
    let usutoken;
    let usucod;
    this.StorageServ.retornaToken()
      .then((result: any) => {
        usutoken = result;
        return this.StorageServ.retornaUsuCod();
      }).then((result: any) => {
        usucod = result;

      }).then((result: any) => {
        console.log(usutoken, usucod, sit, this.nr, this.cnpj);
      });
  }

  //mensagem liberacao
  msgLiberaLista(sit) {
    this.AlertConfirm(sit);
  }

  //mensagem confirmação
  async AlertConfirm(sit) {
    if (sit == 'a') {
      this.teste = 'APROVAR';
    } else if (sit == 'r') {
      this.teste = 'REPROVAR';
    }
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Deseja <strong>' + this.teste + '</strong> o pedido de compra número: <strong>' + this.nr + ' </strong>?',
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: (blah) => {
          }
        }, {
          text: this.teste,
          handler: () => {
            this.setLiberado(sit);
          }
        }
      ]
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
      }).then((result: any) => {
        usucod = result;
        return this.pedCompraMetalboService.gerenPedidoCompra(usutoken, usucod, sit, this.nr, this.cnpj);
      }).then((result: any) => {
        if (result.DADOS.retorno == true) {
          this.mensagemSucessoRetorno(result.DADOS.mensagem);
          this.voltar();
        } else {
          this.mensagemErroRetorno(result.DADOS.erro, result.DADOS.mensagem);
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
  async mensagemErroRetorno(erro, mensagem) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Não foi possível ' + mensagem + ' a solicitação!',
      message: erro,
      buttons: ['OK'],
    });

    await alert.present();
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
}
