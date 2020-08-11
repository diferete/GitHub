<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ModelDELX_PRO_Produtocaracte {

    
    private $pro_codigo;
    private $pro_produtocaractecodigo;
    private $pro_produtocaractevalor;
    private $pro_produtocaractedensidade;
    
    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getPro_produtocaractecodigo() {
        return $this->pro_produtocaractecodigo;
    }

    function getPro_produtocaractevalor() {
        return $this->pro_produtocaractevalor;
    }

    function getPro_produtocaractedensidade() {
        return $this->pro_produtocaractedensidade;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setPro_produtocaractecodigo($pro_produtocaractecodigo) {
        $this->pro_produtocaractecodigo = $pro_produtocaractecodigo;
    }

    function setPro_produtocaractevalor($pro_produtocaractevalor) {
        $this->pro_produtocaractevalor = $pro_produtocaractevalor;
    }

    function setPro_produtocaractedensidade($pro_produtocaractedensidade) {
        $this->pro_produtocaractedensidade = $pro_produtocaractedensidade;
    }



}
