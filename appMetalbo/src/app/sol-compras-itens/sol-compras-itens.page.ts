import { Component, Injectable, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AlertController, NavController } from '@ionic/angular';
import { SolComprasService } from '../api/sol-compras.service';
import { StorageService } from '../api/storage.service';

@Component({
  selector: 'app-sol-compras-itens',
  templateUrl: './sol-compras-itens.page.html',
  styleUrls: ['./sol-compras-itens.page.scss'],
})
export class SolComprasItensPage implements OnInit {
  dados: any;
  nr: any;
  itens: [];
  retorno: boolean;

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
        this.nr = this.dados.nr;
        this.itens = this.dados.itens;
      }
    });
  }
  trackByFn(index: any, item: any) {
    return index;
  }

  msgAlteraQnt(nr, codigo, qnt) {
    let usutoken;
    let usucod;

    this.StorageServ.retornaToken()
      .then((result: any) => {
        usutoken = result;
        return this.StorageServ.retornaUsuCod();
      })
      .then((result: any) => {
        usucod = result;
        return this.solComprasService.getQuantidades(usutoken, usucod, nr, codigo, qnt);
      })
      .then((result: any) => {
        if (result.DADOS.retorno == true) {
          this.AlertConfirm(nr, codigo, qnt);
          //this.mensagemSucessoRetorno(result.DADOS.mensagem);
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

  //mensagem confirmação
  async AlertConfirm(nr, codigo, qnt) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Atenção, o item ' + codigo + ' teve sua quantidade alterada! Deseja gravar essa quantidade?',
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: (blah) => {},
        },
        {
          text: 'Sim',
          handler: () => {
            this.alteraQuantitade(nr, codigo, qnt);
          },
        },
      ],
    });
    await alert.present();
  }

  alteraQuantitade(nr, codigo, qnt) {
    let usutoken;
    let usucod;

    this.StorageServ.retornaToken()
      .then((result: any) => {
        usutoken = result;
        return this.StorageServ.retornaUsuCod();
      })
      .then((result: any) => {
        usucod = result;
        return this.solComprasService.alteraQuantidades(usutoken, usucod, nr, codigo, qnt);
      })
      .then((result: any) => {
        if (result.DADOS.retorno == true) {
          this.mensagemSucessoRetorno(codigo);
        } else {
          this.mensagemErroRetorno();
        }
      });
  }

  //erro retorno
  async mensagemErroRetorno() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Não foi possível alterar a quantidade do item, tente novamente!',
      buttons: ['OK'],
    });
    await alert.present();
  }

  //sucesso
  async mensagemSucessoRetorno(codigo) {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      message: 'Quantidade alterada do item ' + codigo + '!',
      buttons: ['OK'],
    });
    await alert.present();
  }

  ngOnInit() {}
}
