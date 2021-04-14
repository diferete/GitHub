import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
    selector: 'app-ped-metalbo-detalhe',
    templateUrl: './ped-metalbo-detalhe.page.html',
    styleUrls: ['./ped-metalbo-detalhe.page.scss'],
})
export class PedMetalboDetalhePage implements OnInit {
    dados: any;
    data: any;
    Peso: any;
    AcumuPeso: any;
    ValorCipi: any;
    AcumuValor: any;
    MediaSipi: any;
    MediaCipi: any;
    NrPed: any;

    constructor(private route: ActivatedRoute, private router: Router) {
        this.route.queryParams.subscribe(params => {
            let getNav = this.router.getCurrentNavigation();
            if (getNav.extras.state) {
                this.dados = getNav.extras.state.valorParaEnviar;
                console.log(this.dados);
                this.data = this.dados.dataconv;
                this.Peso = this.dados.peso;
                this.AcumuPeso = this.dados.contpeso;
                this.ValorCipi = this.dados.vlrcomipi;
                this.AcumuValor = this.dados.contvlr;
                this.MediaCipi = this.dados.mediaCipi;
                this.MediaSipi = this.dados.mediaSipi;
                this.NrPed = this.dados.nr;
            }
        });
    }

    ngOnInit() {
    }


    voltar() {
        this.router.navigate(['ped-metalbo']);
    }
}
