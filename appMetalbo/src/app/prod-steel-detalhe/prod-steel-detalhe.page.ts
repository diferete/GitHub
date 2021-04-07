import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FatMetalboService } from '../api/fat-metalbo.service';
import { StorageService } from '../api/storage.service';

@Component({
  selector: 'app-prod-steel-detalhe',
  templateUrl: './prod-steel-detalhe.page.html',
  styleUrls: ['./prod-steel-detalhe.page.scss'],
})
export class ProdSteelDetalhePage implements OnInit {
      dados: any;
      data: any;
      etapas: [];

    constructor(private router: Router,
        private route: ActivatedRoute,
        public fatMetalboService: FatMetalboService,
        public StorageServ: StorageService) {
        this.route.queryParams.subscribe(params => {
            let getNav = this.router.getCurrentNavigation();
            if (getNav.extras.state) {
                console.log(getNav.extras.state);
                this.dados = getNav.extras.state.valorParaEnviar;
                this.data = this.dados.data;
                

            }
        });

    }

      ngOnInit() {
      }

    ionViewWillEnter() {
        this.getEtapas();
    }

        getEtapas() {
            //variáveis usuário e token
            let usutoken;
            let usucod;

            this.StorageServ.retornaToken()
                .then((result: any) => {
                    usutoken = result;
                    return this.StorageServ.retornaUsuCod();
                }).then((result: any) => {
                    usucod = result;
                    return this.fatMetalboService.getEtapasSteel(usutoken, usucod, this.data);
                }).then((result: any) => {
                    this.etapas = result.DADOS;
                    console.log(this.etapas);
                });



        }

    voltar() {
        this.router.navigate(['prod-steel']);
    }
}
