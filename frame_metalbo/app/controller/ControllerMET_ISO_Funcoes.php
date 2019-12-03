<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_ISO_Funcoes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ISO_Funcoes');
        $this->setControllerDetalhe('MET_ISO_FuncDesc');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        $aDados = $this->getArrayCampostela();
        $aRetorno[2] = $aDados['codsetor'];

        return $aRetorno;
    }

    public function afterDelete() {
        parent::afterDelete();

        $aDados[0] = $this->Model->getFilcgc();
        $aDados[1] = $this->Model->getNr();
        $this->Persistencia->deletaDependencias($aDados);


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
