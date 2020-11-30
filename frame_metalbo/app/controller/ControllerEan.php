<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerEan extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Ean');
    }

    /**
     * Consulta ean na emissão de solicitações de pedidos
     */
    public function consultaCaixasRep($sDados) {
        $aDados = explode(',', $sDados);
        if (!empty($aDados[4])) {
            $aPcs = $this->Persistencia->consutaCaixaMaster($aDados[4]);
            echo "$('#" . $aDados[2] . "').val('" . $aPcs[0] . "');"
            . "$('#" . $aDados[3] . "').val('" . $aPcs[1] . "');"
            . "$('#" . $aDados[11] . "').val('" . number_format($aPcs[0], 0) . "');";
        } else {
            echo "$('#" . $aDados[2] . "').val('0');"
            . "$('#" . $aDados[3] . "').val('0');"
            . "$('#" . $aDados[11] . "').val('0');";
        }
    }

}
