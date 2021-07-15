import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ToastController } from '@ionic/angular';
import { ConexaoService } from './conexao.service';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root',
})
export class SolComprasService {
  loading: any;

  constructor(
    private http: HttpClient,
    private toastController: ToastController,
    public conexao: ConexaoService,
    public loadingController: LoadingController
  ) {}

  async presentLoading() {
    this.loading = await this.toastController.create({
      message: 'Carregando!',
      color: 'dark',
      duration: 9000,
    });
    return this.loading.present();
  }

  getSolCompras(usutoken, usucod, cnpj) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_Solicitacao',
      metodo: 'getDadosSolicitacaoCompras',
      dados: {
        cnpj: cnpj,
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

  getQuantidades(usutoken, usucod, nr, codigo, qnt, cnpj) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_Solicitacao',
      metodo: 'getQuantidades',
      dados: {
        nr: nr,
        codigo: codigo,
        qnt: qnt,
        cnpj: cnpj,
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

  alteraQuantidades(usutoken, usucod, nr, codigo, qnt, cnpj) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_Solicitacao',
      metodo: 'alteraQuantidades',
      dados: {
        nr: nr,
        codigo: codigo,
        qnt: qnt,
        cnpj: cnpj,
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

  gerenSolicitacaoCompra(usutoken, usucod, sit, nr, cnpj) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'STEEL_SUP_Solicitacao',
      metodo: 'gerenSolicitacaoCompra',
      dados: {
        sit: sit,
        nr: nr,
        usucodigo: usucod,
        cnpj: cnpj,
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
