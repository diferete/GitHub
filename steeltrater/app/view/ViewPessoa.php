<?php

/**
 * Classe que implementa ViewPessoa
 */
class ViewPessoa extends View {

    function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBMostraFiltro(true);

        $oEmpoCod = new CampoConsulta('Código', 'empcod', CampoConsulta::TIPO_LARGURA, 20);

        $oEmpDes = new CampoConsulta('Empresa', 'empdes', CampoConsulta::TIPO_LARGURA, 20);

        $FiltroEmpcod = new Filtro($oEmpoCod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $FiltroEmpdes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $this->addFiltro($FiltroEmpcod, $FiltroEmpdes);
        $this->addCampos($oEmpoCod, $oEmpDes);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
