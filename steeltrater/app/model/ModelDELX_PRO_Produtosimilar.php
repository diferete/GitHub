<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ModelDELX_PRO_Produtosimilar {

    private $pro_codigo;
    private $pro_similarcodigo;
    private $pro_similarobservacao;

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getPro_similarcodigo() {
        return $this->pro_similarcodigo;
    }

    function getPro_similarobservacao() {
        return $this->pro_similarobservacao;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setPro_similarcodigo($pro_similarcodigo) {
        $this->pro_similarcodigo = $pro_similarcodigo;
    }

    function setPro_similarobservacao($pro_similarobservacao) {
        $this->pro_similarobservacao = $pro_similarobservacao;
    }

}
