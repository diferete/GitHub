<?php

/*
 * Classe que implementa os models da STEEL_PCP_ProdReceita
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

Class ModelSTEEL_PCP_ProdReceita {

    private $pro_codigo;
    private $cod_receita;

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getCod_receita() {
        return $this->cod_receita;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setCod_receita($cod_receita) {
        $this->cod_receita = $cod_receita;
    }

}
