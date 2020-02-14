<?php

/*
 * Classe que implementa os models da DELX_PRO_Familia
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ModelDELX_PRO_Familia {

    private $pro_grupocodigo;
    private $pro_subgrupocodigo;
    private $pro_familiacodigo;
    private $pro_familiadescricao;

    function getPro_grupocodigo() {
        return $this->pro_grupocodigo;
    }

    function getPro_subgrupocodigo() {
        return $this->pro_subgrupocodigo;
    }

    function getPro_familiacodigo() {
        return $this->pro_familiacodigo;
    }

    function getPro_familiadescricao() {
        return $this->pro_familiadescricao;
    }

    function setPro_grupocodigo($pro_grupocodigo) {
        $this->pro_grupocodigo = $pro_grupocodigo;
    }

    function setPro_subgrupocodigo($pro_subgrupocodigo) {
        $this->pro_subgrupocodigo = $pro_subgrupocodigo;
    }

    function setPro_familiacodigo($pro_familiacodigo) {
        $this->pro_familiacodigo = $pro_familiacodigo;
    }

    function setPro_familiadescricao($pro_familiadescricao) {
        $this->pro_familiadescricao = $pro_familiadescricao;
    }

}
