<?php

/*
 * * Implementa classe controller
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class ControllerMET_MP_ManutHistorico extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MP_ManutHistorico');
    }

    public function acaoMostraRelEspecifico($sDados) {
        parent::acaoMostraRelEspecifico($sDados);

        
    }
    public function buscaDados($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $oRow = $this->Persistencia->consultaDados($aCamposChave['codsit']);

        echo"$('#" . $aDados[0] . "').val('" . $oRow->ciclo . "');"
        . "$('#" . $aDados[1] . "').val('" . $oRow->resp . "');";
    }

}

