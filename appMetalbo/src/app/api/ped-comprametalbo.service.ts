import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs';
import { ConexaoService } from './conexao.service';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root'
})
export class PedCompraMetalboService {

  loading: any;

  constructor(private http: HttpClient,
    public conexao: ConexaoService,
    public loadingController: LoadingController) { }

  //MENSAGEM DE LOADING
  async presentLoading(message: string) {

    this.loading = await this.loadingController.create({
      message
    });
    return this.loading.present();
  }

  getPedCompras(usutoken, usucod, mes, cnpj) {
    this.presentLoading('');
    let dadosEnv = {
      classe: "STEEL_SUP_PedidoCompra",
      metodo: "getDadosPedidoCompras", dados: {
        "mes": mes,
        "cnpj": cnpj,
      },
      usucodigo: usucod,
      usutoken: usutoken
    };

    return new Promise((resolve, reject) => {
      this.http.post(this.conexao.link, dadosEnv)
        .subscribe((result: any) => {
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
          });
    });
  }

  gerenPedidoCompra(usutoken, usucod, sit, seq, cnpj) {
    this.presentLoading('');
    let dadosEnv = {
      classe: "STEEL_SUP_PedidoCompra",
      metodo: "gerenPedidoCompra", dados: {
        "sit": sit,
        "seq": seq,
        "cnpj": cnpj,
        "usucodigo": usucod,
      },
      usucodigo: usucod,
      usutoken: usutoken
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.conexao.link, dadosEnv)
        .subscribe((result: any) => {
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
          });
    });
  }
}
