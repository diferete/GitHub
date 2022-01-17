import { Injectable } from '@angular/core';
import { HTTP } from '@ionic-native/http/ngx';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { map } from 'rxjs/operators';
import 'rxjs/add/operator/map';

@Injectable({
  providedIn: 'root',
})
export class ConexaoService {
  //**************Link para conexão com a Api**************
  //link = 'https://sistema.metalbo.com.br/enderecamento/index.php?classe=MET_TEC_Mobile&metodo=getRequisicao';
  link = 'http://localhost/GitHub/steeltrater/index.php?classe=MET_TEC_Mobile&metodo=getRequisicao';
  //link = 'https://sistema.metalbo.com.br/metalbo/index.php?classe=MET_TEC_Mobile&metodo=getRequisicao';

  constructor(private http: HttpClient) {}

  //*************Método para logar no sistema**********************************
  logaApp(usuario, senha) {
    let dadosEnv = {
      classe: 'MET_TEC_Login',
      metodo: 'validaMobLogin',
      dados: {
        usuario: usuario,
        senha: senha,
      },
      usucodigo: '',
      usutoken: '',
    };

    return new Promise((resolve, reject) => {
      this.http.post(this.link, dadosEnv).subscribe(
        (result: any) => {
          resolve(result);
          console.log(result);
        },
        (error) => {
          //console.log('erro');
          reject('Sem conexão!');
        }
      );
    });
  }

  //valida token
  validaToken(usucod, usutoken) {
    console.log(usucod + ' ' + usutoken);
    let dadosEnv = {
      classe: 'MET_TEC_Mobile',
      metodo: 'validaToken',
      dados: {
        usucodigo: usucod,
        usutoken: usutoken,
      },
      usucodigo: usucod,
      usutoken: usutoken,
    };

    return new Promise((resolve, reject) => {
      this.http.post(this.link, dadosEnv).subscribe(
        (result: any) => {
          resolve(result);
          console.log(result);
        },
        (error) => {
          //console.log('erro');
          reject('Sem conexão!');
        }
      );
    });
  }
}
