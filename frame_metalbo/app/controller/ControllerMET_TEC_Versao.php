<?php

/*
 * Classe que gerencia a Controller da VersaoSistema
 * @author: Alexandre W. de Souza
 * @since: 15/09/2017
 * 
 */

class ControllerMET_TEC_Versao extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_TEC_Versao');
        $this->setControllerDetalhe('MET_TEC_Updates');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getSeq();
        return $aRetorno;
    }

    public function getDadosUpdates() {
        $aVersoes = $this->Persistencia->getDadosVersoes();
        return $aVersoes;
    }

}
