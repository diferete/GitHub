import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-fat-metalbo-detalhe',
  templateUrl: './fat-metalbo-detalhe.page.html',
  styleUrls: ['./fat-metalbo-detalhe.page.scss'],
})

export class FatMetalboDetalhePage implements OnInit {
  dados: any;
  data: any;
  peso: number;
  VlrLiq: any;
  ipi: any;
  mcipi: any;
  msipi: any;
  expor: any;
  sucata: any;

  constructor(private route: ActivatedRoute, private router: Router, private navCtrl: NavController) {
    this.route.queryParams.subscribe(params => {
      let getNav = this.router.getCurrentNavigation();
      if (getNav.extras.state) {
        this.dados = getNav.extras.state.valorParaEnviar;
        this.data = this.dados.dataconv;
        this.peso = this.dados.PesoLiquido;
        this.VlrLiq = this.dados.vlrliquido;
        this.ipi = this.dados.vlripi;
        this.mcipi = this.dados.mediaCipi;
        this.msipi = this.dados.mediaSipi;
        this.expor = this.dados.exportacao;
        this.sucata = this.dados.sucata;

      }
    });

  }

  ngOnInit() {
  }

  voltar() {
    this.navCtrl.back();
  }

}
