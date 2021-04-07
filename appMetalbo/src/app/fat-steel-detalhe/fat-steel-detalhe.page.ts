import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { NavController } from '@ionic/angular';

@Component({
    selector: 'app-fat-steel-detalhe',
    templateUrl: './fat-steel-detalhe.page.html',
    styleUrls: ['./fat-steel-detalhe.page.scss'],
})
export class FatSteelDetalhePage implements OnInit {
    dados: any;
    data: any;
    PesoInd: any;
    ValorFat: any;
    ValorServ: any;
    ValorInsumo: any;
    PesoIndFio: any;
    ValorServicoFio: any;
    ValorInsumoFio: any;
    PesoIndAcab: any;
    ValorServicoAcab: any;
    ValorInsumoAcab: any;


    constructor(private router: Router, private route: ActivatedRoute, private navCtrl: NavController) {
        this.route.queryParams.subscribe(params => {
            let getNav = this.router.getCurrentNavigation();
            if (getNav.extras.state) {
                console.log(getNav.extras.state);
                this.dados = getNav.extras.state.valorParaEnviar;
                this.data = this.dados.dataChar;
                this.PesoInd = this.dados.PesoInd;
                this.ValorFat = this.dados.ValorFat;
                this.ValorServ = this.dados.ValorServico;
                this.ValorInsumo = this.dados.ValorInsumo;
                this.PesoIndFio = this.dados.PesoIndFio;
                this.ValorServicoAcab = this.dados.ValorServicoAcab;
                this.ValorInsumoAcab = this.dados.ValorInsumoAcab;
                this.ValorServicoFio = this.dados.ValorServicoFio;
                this.ValorInsumoFio = this.dados.ValorInsumoFio;

                this.PesoIndAcab = this.dados.PesoIndAcab;

            }
        });
    }

    ngOnInit() {
    }

    voltar() {
        this.navCtrl.back();
    }

}
