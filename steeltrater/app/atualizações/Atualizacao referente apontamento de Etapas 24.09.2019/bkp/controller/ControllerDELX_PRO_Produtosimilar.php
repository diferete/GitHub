<?php

/*
 * 
 * Implementa controller da classe
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ControllerDELX_PRO_Produtosimilar extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Produtosimilar');
    }

     public function buscaDados($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaDados($aCamposChave['pro_similarcodigo']);

        echo"$('#" . $aParam[0] . "').val('" . $oRow->pro_descricao . "');"
        . "$('#" . $aParam[1] . "').val('" . $oRow->pro_unidademedida . "');";
    }
}
