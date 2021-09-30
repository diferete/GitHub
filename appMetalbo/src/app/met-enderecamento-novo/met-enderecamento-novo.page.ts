import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { AlertController, NavController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';
import { EnderecamentoService } from '../api/enderecamento.service';

@Component({
  selector: 'app-met-enderecamento-novo',
  templateUrl: './met-enderecamento-novo.page.html',
  styleUrls: ['./met-enderecamento-novo.page.scss'],
})
export class MetEnderecamentoNovoPage implements OnInit {
  estante = '';
  nivel = '';
  coluna = '';
  tipo = '';
  codigo = '';
  descricao = '';
  procod: any;
  tip: any;
  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public enderecamentoService: EnderecamentoService,
    public alertController: AlertController,
    private navCtrl: NavController,
    public StorageServ: StorageService,
    public loadingController: LoadingController
  ) {}

  ngOnInit() {}

  ionViewWillEnter() {
    this.codigo = '';
  }

  getDescricao() {
    //variáveis usuário e token
    let usutoken;
    let usucod;
    if (this.codigo == '') {
    } else {
      this.StorageServ.retornaToken()
        .then((result: any) => {
          usutoken = result;
          return this.StorageServ.retornaUsuCod();
        })
        .then((result: any) => {
          usucod = result;
          return this.enderecamentoService.getDescricao(usutoken, usucod, this.codigo);
        })
        .then((result: any) => {
          if (result.DADOS != null) {
            this.descricao = result.DADOS;
          } else {
            this.mensagemErroItem();
          }
        });
    }
  }
  //erro retorno
  async mensagemErroItem() {
    this.descricao = '';
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Item não encontrado.',
      buttons: ['OK'],
    });

    await alert.present();
  }
  async mensagemErroItemVazio() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message: 'Favor preencher o campo com código e endereços do item!',
      buttons: ['OK'],
    });

    await alert.present();
  }

  msgConfInsereNovoEndereco() {
    if (this.codigo == '' || this.estante == '' || this.nivel == '' || this.coluna == '' || this.tipo == '') {
      this.mensagemErroItemVazio();
    } else {
      this.AlertConfirmInsereEndereco();
    }
  }

  async AlertConfirmInsereEndereco() {
    switch (this.tipo) {
      case '1':
        this.tip = 'F';
        break;
      case '2':
        this.tip = 'E';
        break;
      case '3':
        this.tip = 'ND';
        break;
      case '4':
        this.tip = 'EXP';
        break;
    }
    const alert = await this.alertController.create({
      header: 'Atenção!',
      message:
        'Deseja inserir o endereço do item <strong>' +
        this.codigo +
        '</strong> para o endereço: <strong>' +
        this.estante +
        ' ' +
        this.nivel +
        ' ' +
        this.coluna +
        '</strong> do tipo <strong>' +
        this.tip,
      buttons: [
        {
          text: 'Cancelar',
          role: 'cancel',
          handler: (blah) => {},
        },
        {
          text: 'Sim',
          handler: () => {
            this.insereNovoEndereco();
          },
        },
      ],
    });

    await alert.present();
  }

  insereNovoEndereco() {
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
        return this.enderecamentoService.insereNovoEndereco(
          usutoken,
          usucod,
          this.codigo,
          this.estante,
          this.nivel,
          this.coluna,
          this.tipo
        );
      })
      .then((result: any) => {
        console.log(result.DADOS.retorno);
        if (result.DADOS.retorno == true) {
          this.mensagemSucesso();
          this.estante = '';
          this.nivel = '';
          this.coluna = '';
          this.tipo = '';
          this.codigo = '';
          this.descricao = '';
        } else {
          this.mensagemErro(result.DADOS.mensagem);
        }
      });
  }

  //erro retorno
  async mensagemErro(mensagem) {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Erro ao inserir endereço',
      message: mensagem,
      buttons: ['OK'],
    });

    await alert.present();
  }

  //sucesso
  async mensagemSucesso() {
    const alert = await this.alertController.create({
      header: 'Sucesso!',
      subHeader: 'Endereço inserido!',
      message: '',
      buttons: ['OK'],
    });

    await alert.present();
  }

  voltar() {
    this.navCtrl.back();
  }
}
