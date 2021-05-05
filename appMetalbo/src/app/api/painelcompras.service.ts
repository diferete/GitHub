import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs';
import { ConexaoService } from './conexao.service';
import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { StorageService } from '../api/storage.service';
import { async } from '@angular/core/testing';
import { LoadingController } from '@ionic/angular';
import { AlertController } from '@ionic/angular';


@Injectable({
  providedIn: 'root'
})
export class PainelcomprasService {
  loading: any;
  constructor(private http: HttpClient,
    public conexao: ConexaoService,
    public Storage: NativeStorage,
    public StorageServ: StorageService,
    public loadingController: LoadingController,
    public alertController: AlertController,) { }

  //MENSAGEM DE LOADING
  async presentLoading(message: string) {

    this.loading = await this.loadingController.create({
      message,
      duration: 7000
    });
    return this.loading.present();
  }

  //CONEXÃO INTERNET
  async mensagemAlertInternet() {
    const alert = await this.alertController.create({
      header: 'Atenção!',
      subHeader: 'Verifique sua conexão com a internet.',
      message: 'Dados não ativos.',
      buttons: ['OK'],
    });

    await alert.present();
  }

  getBadgeCount(usutoken, usucod) {

    this.presentLoading('');


    return new Promise((resolve, reject) => {
      let dadosEnv = {
        classe: "STEEL_SUP_PedidoCompra",
        metodo: "getDadosBadgeCompras",
        dados: {
          "usucodigo": usucod,

        },
        usucodigo: usucod,
        usutoken: usutoken,
      };


      // alert('3-Token enviado '+dadosEnv.usutoken);
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
            this.mensagemAlertInternet();
          });
    });


  }

}
