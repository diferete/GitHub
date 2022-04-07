import { Component } from '@angular/core';
import { Platform } from '@ionic/angular';
import { SplashScreen } from '@ionic-native/splash-screen/ngx';
import { StatusBar } from '@ionic-native/status-bar/ngx';
import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { MenuService } from './api/menu.service';
import { StorageService } from './api/storage.service';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: [
    './side-menu/styles/side-menu.scss',
    './side-menu/styles/side-menu.shell.scss',
    './side-menu/styles/side-menu.responsive.scss',
  ],
})
export class AppComponent {
  /*variáves de menu*/
  menItens: any;
  /*Páginas iniciais*/
  FATURAMENTO = [];
  /*Páginas de pedidos*/
  PEDIDO = [];
  /*Página de produção*/
  PRODUCAO = [];
  /*Página fostatizacao*/
  FOSFATIZACAO = [];
  /*Página de sistema*/
  SISTEMA = [];
  /**/
  ENDERECAMENTOS = [];

  constructor(
    private platform: Platform,
    private splashScreen: SplashScreen,
    private statusBar: StatusBar,
    public Storage: NativeStorage,
    public MenuService: MenuService,
    public StorageServ: StorageService
  ) {
    this.initializeApp();
  }
  nome: string;
  email: string;

  initializeApp() {
    this.platform.ready().then(() => {
      this.statusBar.styleDefault();
      this.splashScreen.hide();
      this.carregaDadosUser();
      /*Carrega itens menu*/
      this.getItensMenu();
    });
  }

  menuOpened() {
    // alert('entrou');
    this.getItensMenu();
  }

  carregaDadosUser() {
    //carrega variável de ambientes
    this.Storage.getItem('usunome')
      .then((result) => {
        if (result != null) {
          this.nome = result;
        }
      })
      .catch((e) => {
        //alert('error: ' + e);
      });

    this.Storage.getItem('usuemail')
      .then((result) => {
        if (result != null) {
          this.email = result;
        }
      })
      .catch((e) => {
        //alert('error: ' + e);
      });
  }

  /*carrega dados do menu*/
  getItensMenu() {
    let usutoken;
    let usucod;
    // alert('Vai carregar menu');
    this.StorageServ.retornaToken().then((result: any) => {
      usutoken = result;
      this.StorageServ.retornaUsuCod().then((result: any) => {
        usucod = result;
        this.MenuService.getMenu(usutoken, usucod).then((result: any) => {
          //console.log('MENU ->->-> ' + result.DADOS.FOSFATIZAÇÃO);
          this.FATURAMENTO = result.DADOS.FATURAMENTO;
          this.PRODUCAO = result.DADOS.PRODUÇÃO;
          this.SISTEMA = result.DADOS.SISTEMA;
          this.PEDIDO = result.DADOS.PEDIDOS;
          this.FOSFATIZACAO = result.DADOS.FOSFATIZAÇÃO;
          this.ENDERECAMENTOS = result.DADOS.ENDEREÇAMENTO;
        });
      });
    });
  }

  logout() {
    // alert('chegou');
    this.StorageServ.removeDados();
    // this.router.navigate(['/auth/login']);
  }
}
