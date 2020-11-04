<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_SUP_Solicitacao extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SUP_Solicitacao');
        $this->setControllerDetalhe('STEEL_SUP_SolicitacaoItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $this->Model->getDELX_FIL_Empresa()->getFil_codigo());
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $this->Model->getSUP_SolicitacaoSeq());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFil_codigo();
        $aRetorno[1] = $this->Model->getSUP_SolicitacaoSeq();
        return $aRetorno;
    }

}
