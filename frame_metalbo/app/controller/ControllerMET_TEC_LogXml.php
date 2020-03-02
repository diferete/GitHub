<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_LogXml extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_LogXml');
    }

    public function carregaLogXml($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sLogXml = $this->Persistencia->carregaLogXml($aCamposChave);

        $sScript = "$('#" . $aDados[2] . "').val('" . $sLogXml . "');";

        echo $sScript;
    }

}
