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

}
