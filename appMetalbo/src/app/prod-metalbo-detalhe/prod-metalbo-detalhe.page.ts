import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-prod-metalbo-detalhe',
  templateUrl: './prod-metalbo-detalhe.page.html',
  styleUrls: ['./prod-metalbo-detalhe.page.scss'],
})
export class ProdMetalboDetalhePage implements OnInit {

    dados: any;
    data: any;
    MaqQuente: any;
    Parafusos: any;
    Porca: any;
    Rosq: any;
    TotalSemRosq: any;
    

    constructor(private route: ActivatedRoute, private router: Router) {
        this.route.queryParams.subscribe(params => {
            let getNav = this.router.getCurrentNavigation();
            if (getNav.extras.state) {
                this.dados = getNav.extras.state.valorParaEnviar;
                console.log(this.dados);
                this.data = this.dados.dataconv;
                this.MaqQuente = this.dados.maqquente;
                this.Parafusos = this.dados.parafuso;
                this.Porca = this.dados.porca;
                this.Rosq = this.dados.rosq;
                this.TotalSemRosq = this.dados.totalsemrosq;
            }
        });
    }

  ngOnInit() {
  }

    voltar() {
        this.router.navigate(['prod-metalbo']);
    }
}
