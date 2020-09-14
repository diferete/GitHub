<?php

/*
 * Implementa a classe persistencia MET_QUAL_RncMaterial
 * @author Cleverton Hoffmann
 * @since 25/08/2020
 */

class ViewMET_QUAL_RncMaterial extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaFiltro(true);
        $this->getTela()->setBMostraFiltro(true);

        $oCodCorrida = new CampoConsulta('Código', 'cod');
        $oDescCorrida = new CampoConsulta('Corrida', 'corrida');

        $oFilCodCorrida = new Filtro($oCodCorrida, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilDescCorrida = new Filtro($oDescCorrida, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $this->addFiltro($oFilCodCorrida, $oFilDescCorrida);

        $this->addCampos($oCodCorrida, $oDescCorrida);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
