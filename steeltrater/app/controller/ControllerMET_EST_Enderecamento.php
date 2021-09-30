<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerMET_EST_Enderecamento
 *
 * @author Alexandre
 */
class ControllerMET_EST_Enderecamento extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_EST_Enderecamento');
    }

    public function getDadosEnderecamento($oDados) {
        $aRetorno = $this->Persistencia->getDadosEnderecamento($oDados);
        return $aRetorno;
    }

    public function updateEndereco($oDados) {
        $aRetorno = $this->Persistencia->updateEndereco($oDados);
        $aIonic = array();
        $aIonic['retorno'] = $aRetorno[0];
        $aIonic['mensagem'] = $aRetorno[1];
        $aIonic['armcod'] = $aRetorno[2];
        return $aIonic;
    }

    public function getDescricao($oDados) {
        $aRetorno = $this->Persistencia->getDescricao($oDados);
        return $aRetorno;
    }

    public function insereNovoEndereco($oDados) {
        $aRetorno = $this->Persistencia->insereNovoEndereco($oDados);
        $aIonic = array();
        $aIonic['retorno'] = $aRetorno[0];
        $aIonic['mensagem'] = $aRetorno[1];
        return $aIonic;
    }

    public function addListaEspera($oDados) {
        $aRetorno = $this->Persistencia->addListaEspera($oDados);
        $aIonic = array();
        $aIonic['retorno'] = $aRetorno[0];
        $aIonic['mensagem'] = $aRetorno[1];
        return $aIonic;
    }

}
