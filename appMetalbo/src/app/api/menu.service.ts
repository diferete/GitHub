import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs';
import { ConexaoService } from './conexao.service';

@Injectable({
    providedIn: 'root'
})
export class MenuService {

    constructor(private http: HttpClient, public conexao: ConexaoService) { }


    getMenu(usutoken, usucod) {
        //console.log('Usucodigo menu ' + usucod);
        //console.log('Token menu ' + usutoken);

        let dadosEnv = {
            classe: "MET_TEC_Mobile",
            metodo: "getMenu",
            dados: {
                "usuario": "avanei@rexmaquinas.com.br",
                "senha": ""
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);

                },
                    (error) => {
                        reject('Sem conexão!');
                    });
        });


    }
}
