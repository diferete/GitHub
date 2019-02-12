<?php

/* 
 * Classe que implementa model dos precos
 * 
 * @author Avanei Martendal
 * @since 23/01/2019
 */

class ModelDELX_TPV_TabelaPrecoProduto {
    private $tpv_codigo;
    private $tpv_produtocodigo;
    private $tpv_produtopreco;
    
    function getTpv_codigo() {
        return $this->tpv_codigo;
    }

    function getTpv_produtocodigo() {
        return $this->tpv_produtocodigo;
    }

    function getTpv_produtopreco() {
        return $this->tpv_produtopreco;
    }

    function setTpv_codigo($tpv_codigo) {
        $this->tpv_codigo = $tpv_codigo;
    }

    function setTpv_produtocodigo($tpv_produtocodigo) {
        $this->tpv_produtocodigo = $tpv_produtocodigo;
    }

    function setTpv_produtopreco($tpv_produtopreco) {
        $this->tpv_produtopreco = $tpv_produtopreco;
    }


    
}