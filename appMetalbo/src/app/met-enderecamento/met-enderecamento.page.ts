import { Component, OnInit } from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { ActivatedRoute } from '@angular/router';
import { AlertController } from '@ionic/angular';
import { StorageService } from '../api/storage.service';
import { LoadingController } from '@ionic/angular';
import { EnderecamentoService } from '../api/enderecamento.service';

@Component({
  selector: 'app-met-enderecamento',
  templateUrl: './met-enderecamento.page.html',
  styleUrls: ['./met-enderecamento.page.scss'],
})
export class MetEnderecamentoPage implements OnInit {
  estante = '';
  coluna = '';
  nivel = '';
  tipo = '';
  codigo = '';
  listaItens: [];

  constructor(
    public router: Router,
    public menu: MenuController,
    private route: ActivatedRoute,
    public enderecamentoService: EnderecamentoService,
    public alertController: AlertController,
    public StorageServ: StorageService,
    public loadingController: LoadingController
  ) {}

  getLista() {
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

        if (this.estante == '' && this.coluna == '' && this.nivel == '' && this.tipo == '' && this.codigo == '') {
          this.mensagemFiltro();
        } else {
          return this.enderecamentoService.getDadosEnderecamento(
            usutoken,
            usucod,
            this.estante,
            this.coluna,
            this.nivel,
            this.tipo,
            this.codigo
          );
        }
      })
      .then((result: any) => {
        this.listaItens = result.DADOS;
      });
  }

  //erro retorno
  async mensagemFiltro() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Filtro',
      message: 'Por favor adicione ao menos um filtro (Código ou endereço)!',
      buttons: ['OK'],
    });

    await alert.present();
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

  ngOnInit() {}

  ionViewWillEnter() {
    this.getLista();
  }
  //abre tela detalhe
  getDadosDetalhe(p) {
    let navigationExtras: NavigationExtras = {
      state: {
        valorParaEnviar: p,
      },
    };
    this.router.navigate(['met-enderecamento-detalhe'], navigationExtras);
  }
}
