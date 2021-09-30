import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ToastController } from '@ionic/angular';
import { ConexaoService } from './conexao.service';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root',
})
export class EnderecamentoService {
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
  getDadosEnderecamento(usutoken, usucod, estante, coluna, nivel, tipo, codigo) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'MET_EST_Enderecamento',
      metodo: 'getDadosEnderecamento',
      dados: {
        usucodigo: usucod,
        estante: estante,
        coluna: coluna,
        nivel: nivel,
        tipo: tipo,
        codigo: codigo,
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

  updateEndereco(usutoken, usucod, estante, nivel, coluna, tipo, codigo, armcod) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'MET_EST_Enderecamento',
      metodo: 'updateEndereco',
      dados: {
        usucodigo: usucod,
        estante: estante,
        nivel: nivel,
        coluna: coluna,
        tipo: tipo,
        codigo: codigo,
        armcod: armcod,
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

  getDescricao(usutoken, usucod, cod) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'MET_EST_Enderecamento',
      metodo: 'getDescricao',
      dados: {
        usucodigo: usucod,
        codigo: cod,
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

  updateAddListaEspera(usutoken, usucod, estante, nivel, coluna, tipo, codigo, armcod) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'MET_EST_Enderecamento',
      metodo: 'addListaEspera',
      dados: {
        usucodigo: usucod,
        estante: estante,
        nivel: nivel,
        coluna: coluna,
        tipo: tipo,
        codigo: codigo,
        armcod: armcod,
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

  insereNovoEndereco(usutoken, usucod, procod, estante, nivel, coluna, tipo) {
    this.presentLoading();
    let dadosEnv = {
      classe: 'MET_EST_Enderecamento',
      metodo: 'insereNovoEndereco',
      dados: {
        usucodigo: usucod,
        codigo: procod,
        estante: estante,
        nivel: nivel,
        coluna: coluna,
        tipo: tipo,
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
