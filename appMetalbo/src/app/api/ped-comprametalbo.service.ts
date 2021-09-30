import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ToastController } from '@ionic/angular';
import { ConexaoService } from './conexao.service';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root',
})
export class PedCompraMetalboService {
  loading: any;

  constructor(
    private http: HttpClient,
    private toastController: ToastController,
    public conexao: ConexaoService,
    public loadingController: LoadingController
  ) {}

  //MENSAGEM DE LOADING

  async presentLoading() {
    this.loading = await this.toastController.create({
      message: 'Carregando!',
      color: 'dark',
      duration: 9000,
    });
    return this.loading.present();
  }
  /*
    async presentLoading(message: string) {
      this.loading = await this.loadingController.create({
        message,
        duration: 7000
      });
      return this.loading.present();
    }*/

  getPedCompras(usutoken, usucod, cnpj) {
    //console.log(cnpj);
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_PedidoCompra',
      metodo: 'getDadosPedidoCompras',
      dados: {
        cnpj: cnpj,
        usucodigo: usucod,
      },
      usucodigo: usucod,
      usutoken: usutoken,
    };

    return new Promise((resolve, reject) => {
      this.http.post(this.conexao.link, dadosEnv).subscribe(
        (result: any) => {
          setTimeout(() => {
            this.loading.dismiss();
          });
          resolve(result);
        },
        (error) => {
          setTimeout(() => {
            this.loading.dismiss();
          });
          reject('Sem conexão!');
        }
      );
    });
  }

  gerenPedidoCompra(usutoken, usucod, sit, seq, cnpj) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_PedidoCompra',
      metodo: 'gerenPedidoCompra',
      dados: {
        sit: sit,
        seq: seq,
        cnpj: cnpj,
        usucodigo: usucod,
      },
      usucodigo: usucod,
      usutoken: usutoken,
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.conexao.link, dadosEnv).subscribe(
        (result: any) => {
          setTimeout(() => {
            this.loading.dismiss();
          });
          resolve(result);
        },
        (error) => {
          setTimeout(() => {
            this.loading.dismiss();
          });
          reject('Sem conexão!');
        }
      );
    });
  }
}
