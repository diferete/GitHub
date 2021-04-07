import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import 'rxjs/add/operator/map';
import { Observable } from 'rxjs';
import { ConexaoService } from './conexao.service';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root'
})
export class FatMetalboService {

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

    getFatMetalbo(usutoken, usucod, mes) {
       // console.log('mes é ' + mes);
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getFatMetalbo",
            dados: {
                "mes": mes,
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

    //Faturamento steeltrater
    getFatSteel(usutoken, usucod, mes) {
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getFatSteel",
            dados: {
                "mes": mes,
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);
                    setTimeout(() => {
                        this.loading.dismiss();
                    });
                   // console.log(result);
                },
                    (error) => {
                        reject('Sem conexão!');
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                    });
        });

    }

    
    //Faturamento steeltrater
    getPedMetalbo(usutoken, usucod, mes) {
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getPedMetalbo",
            dados: {
                "mes": mes,
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);
                    console.log(result);
                    setTimeout(() => {
                        this.loading.dismiss();
                    });
                },
                    (error) => {
                        reject('Sem conexão!');
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                    });
        });

    }

    //Produção Metalbo
    getProdMetaldo(usutoken, usucod,mes, empresa) {
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getProdMetalbo",
            dados: {
                "mes": mes,
                "empresa":empresa,
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);
                    setTimeout(() => {
                        this.loading.dismiss();
                    });
                    console.log(result);
                },
                    (error) => {
                        reject('Sem conexão!');
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                    });
        });
    }

    //produção steel
    getProdSteel(usutoken, usucod, mes) {
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getProdSteel",
            dados: {
                "mes": mes,
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);
                    setTimeout(() => {
                        this.loading.dismiss();
                    });
                    console.log(result);
                },
                    (error) => {
                        reject('Sem conexão!');
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                    });
        });
    }

    //produção etapas
    getEtapasSteel(usutoken, usucod, data) {
        
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "getProdSteelEtapa",
            dados: {
                "mes": data,
            },
            usucodigo: usucod,
            usutoken: usutoken
        };

      

        return new Promise((resolve, reject) => {
            this.http.post(this.conexao.link, dadosEnv)
                .subscribe((result: any) => {
                    resolve(result);
                    setTimeout(() => {
                        this.loading.dismiss();
                    });
                    console.log(result);
                },
                    (error) => {
                        reject('Sem conexão!');
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                    });
        });
    }

/*retorna a lista em espera fosfatização*/
    getListaEsperaFosfatizacao(usutoken, usucod, mes) {
        // console.log('mes é ' + mes);
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "listaLiberadoFosfatizacao",
            dados: {
                "mes": mes,
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
                    console.log(result);
                },
                    (error) => {
                        setTimeout(() => {
                            this.loading.dismiss();
                        });
                        reject('Sem conexão!');
                    });
        });


    }

/*Gera o update da lista fosfatização*/
    /*retorna a lista em espera fosfatização*/
    setListaEsperaFosfatizacao(usutoken, usucod, seq) {
        // console.log('mes é ' + mes);
        this.presentLoading('');
        let dadosEnv = {
            classe: "MET_TEC_MobileFat",
            metodo: "setLiberadoFosfatizacao",
            dados: {
                "usucod": usucod,
                "seq": seq,
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
