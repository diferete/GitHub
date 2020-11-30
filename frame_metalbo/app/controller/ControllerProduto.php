<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerProduto extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Produto');
    }

    public function mostraTelaRelatorioProduto($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'TelaRelatorioProduto');
    }

    /**
     * Função que retorna o peso dos produtos
     */
    public function retPeso($sDados) {
        $aDados = explode(',', $sDados);
        if (!empty($aDados[4])) {
            $sPeso = $this->Persistencia->consultaPeso($aDados[4]);
            echo "$('#" . $aDados[5] . "').val('" . $sPeso . "');";
        } else {
            echo "$('#" . $aDados[5] . "').val('0');";
        }
    }

    /**
     * Função que verifica se item é b7
     */
    public function getB7($sProcod) {
        if (!empty($sProcod)) {
            $bB7 = $this->Persistencia->getB7($sProcod);
        }
        return $bB7;
    }

    public function mostraTelaRelEan($renderTo, $sMetodo = '') {
        parent::criaTelaDiversa($renderTo, 'ListaEmb');
    }

}
