import { Component, OnInit } from '@angular/core';
import { Validators, FormGroup, FormControl } from '@angular/forms';
import { Router } from '@angular/router';
import { MenuController, ToastController } from '@ionic/angular';
import { AlertController } from '@ionic/angular';
import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { ConexaoService } from '../api/conexao.service';
import { StorageService } from '../api/storage.service';
import { StatusBar } from '@ionic-native/status-bar/ngx';




//******************************************************************************************************
@Component({
    selector: 'app-login',
    templateUrl: './login.page.html',
    styleUrls: [
        './styles/login.page.scss'
    ]
})

//******************************************************************************************************
export class LoginPage implements OnInit {
    loginForm: FormGroup;
    usuario: string;
    senha: string;
    token: any;
    dadosRetorno: any;



    validation_messages = {
        'email': [
            { type: 'required', message: 'É necessário informar seu e-mail.' },
            { type: 'pattern', message: 'Atenção informe um e-mail válido.' }
        ],
        'password': [
            { type: 'required', message: 'É necessário niformar uma senha.' },
            { type: 'minlength', message: 'Senha precisa ter no mínimo 5 caracteres.' }
        ]
    };

    //*******************************************************************************************************
    constructor(
        public Storage: NativeStorage,
        public router: Router,
        public menu: MenuController,
        public alertController: AlertController,
        public conexao: ConexaoService,
        private toastController: ToastController,
        public StorageServ: StorageService,
        private statusBar: StatusBar
    ) {
        this.loginForm = new FormGroup({
            'email': new FormControl('', Validators.compose([
                Validators.required,
                Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
            ])),
            'password': new FormControl('', Validators.compose([
                Validators.minLength(5),
                Validators.required
            ]))
        });
    }
    //*********************************************************************************************************
    //MENSAGEM DE PROBLEMAS NO LOGIN
    async mensagemAlert() {
        const alert = await this.alertController.create({
            header: 'Atenção!',
            subHeader: 'Verifique sua senha de usuário.',
            message: 'Consulte a área de TI!',
            buttons: ['OK'],
        });

        await alert.present();
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
    //USUÁRIO LOGADO COM SUCESSO
    async mensagemLogado() {
        const toast = await this.toastController.create({
            message: 'Usuário logado!',
            color: 'dark',
            duration: 3000
        });
        toast.present();
    }

    //USUÁRIO LOGADO COM ERRO
    async mensagemErroLogin() {
        const toast = await this.toastController.create({
            message: 'Erro no login!',
            color: 'danger',
            duration: 3000
        });
        toast.present();
    }


    //**********************************************************************************************************
    ngOnInit(): void {
        this.menu.enable(false);
    }
    //**********************************************************************************************************  
    //GERA O LOGIN NO SISTEMA
    doLogin(): void {
        this.usuario = this.loginForm.value.email;
        this.senha = this.loginForm.value.password;

        let Dados: any;

        
     
        //chama método para logar no sistema
        this.conexao.logaApp(this.usuario, this.senha)
            .then((result: any) => {
                if (result.SUCESSO) {
                    this.mensagemLogado();
                    this.gravaDadosUsuario(result.DADOS.usucodigo, result.DADOS.usunome, result.DADOS.usulogin, result.DADOS.codsetor, result.TOKEN, result.DADOS.usulogin);
                    this.router.navigate(['principal']); 
                } else {
                    this.mensagemAlert();
                    this.mensagemErroLogin();
                }
              })
                .catch((error: any) => {
                    this.mensagemAlertInternet();
                });
        }
    //***********************************************************************************************************
    goToForgotPassword(): void {
        console.log('redirect to forgot-password page');
    }

    //************************************************************************************************************
    //GRAVA DADOS DO USUÁRIO NO DISPOSITIVO
    gravaDadosUsuario(usucodigo, usunome, usologin, codsetor, usutoken, usuemail): void {
        this.StorageServ.gravaDados(usucodigo, usunome, usologin, codsetor, usutoken, usuemail);

    }

    //se tiver token válido entra
    ionViewWillEnter() {
        this.statusBar.backgroundColorByHexString('#cc181e');
        this.doValidaToken();
    }

    //valida token
    doValidaToken() {
        let usutoken;
        let usucod;
        //solicita o token do storage
       this.StorageServ.retornaToken()
            .then((result: any) => {
                usutoken = result;
               
                //solicita o código do usuário
                this.StorageServ.retornaUsuCod()
                    .then((result: any) => {
                        usucod = result;
                        //solicita os dados do servidor sistema.metalbo.com.br
                        this.conexao.validaToken(usucod,usutoken)
                            .then((result: any) => {
                                //verifica se o token é válido
                                if (result.bTOKEN == true) {

                                    this.router.navigate(['principal']); 
                                   
                                    /*this.router.navigate(['/auth/login']);*/
                               } else {
                                /*this.router.navigate(['/auth/login']);*/
                                }
                            });

                    });
            });
        
    }
    /* doFacebookLogin(): void {
       console.log('facebook login');
       this.router.navigate(['app/categories']);
     }
   
     doGoogleLogin(): void {
       console.log('google login');
       this.router.navigate(['app/categories']);
     }
   
     doTwitterLogin(): void {
       console.log('twitter login');
       this.router.navigate(['app/categories']);
     }*/

/*  } else {
        this.mensagemAlert();
        }*/

}