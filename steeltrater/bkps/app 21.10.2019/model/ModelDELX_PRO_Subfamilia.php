<?php

/*
 * Classe que implementa os models da DELX_PRO_Subfamilia
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ModelDELX_PRO_Subfamilia {

    private $pro_grupocodigo;
    private $pro_subgrupocodigo;
    private $pro_familiacodigo;
    private $pro_subfamiliacodigo;
    private $pro_subfamiliadescricao;

    function getPro_grupocodigo() {
        return $this->pro_grupocodigo;
    }

    function getPro_subgrupocodigo() {
        return $this->pro_subgrupocodigo;
    }

    function getPro_familiacodigo() {
        return $this->pro_familiacodigo;
    }

    function getPro_subfamiliacodigo() {
        return $this->pro_subfamiliacodigo;
    }

    function getPro_subfamiliadescricao() {
        return $this->pro_subfamiliadescricao;
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

    function setPro_subfamiliacodigo($pro_subfamiliacodigo) {
        $this->pro_subfamiliacodigo = $pro_subfamiliacodigo;
    }

    function setPro_subfamiliadescricao($pro_subfamiliadescricao) {
        $this->pro_subfamiliadescricao = $pro_subfamiliadescricao;
    }

}
