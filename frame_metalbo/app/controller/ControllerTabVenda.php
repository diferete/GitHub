<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerTabVenda extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('TabVenda');
    }

    /**
     * Método para consultar preço por um código determinado
     */
    public function buscaPrecoRep($sDados) {
        $aDados = explode(',', $sDados);
        if (!empty($aDados[4])) {
            $this->Persistencia->adicionaFiltro('procod', $aDados[4]);
            $this->Model = $this->Persistencia->consultarWhere();
            $sPreco = number_format($this->Model->getPreco(), 2, ',', '.');
            $iLotemin = $this->Model->getLotemin();

            $sRetorno = "$('#" . $aDados[0] . "').val('" . $sPreco . "');"
                    . "$('#" . $aDados[1] . "').val('" . $sPreco . "');";

            echo $sRetorno;
        } else {
            $sRetorno = "$('#" . $aDados[0] . "').val('0');"
                    . "$('#" . $aDados[1] . "').val('0');";
            echo $sRetorno;
        }
        if ($iLotemin !== null) {
            echo "$('#" . $aDados[10] . "').val('" . number_format($iLotemin, 2, ',', '.') . "');";
        } else {
            echo "$('#" . $aDados[10] . "').val('0');";
        }
    }

    /**
     * Verifica se o item está na tabela de preço
     */
    public function getItemTab($sProcod) {
        if (!empty($sProcod)) {
            $sTab = $this->Persistencia->getItemTab($sProcod);
        }
        return $sTab;
    }

}
