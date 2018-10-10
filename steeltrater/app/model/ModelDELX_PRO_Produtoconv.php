<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018 
 */

class ModelDELX_PRO_Produtoconv {

    private $pro_codigo;
    private $pro_convcodigo;
    private $pro_convunidade;
    private $pro_convfator;
    private $pro_convpadrao;
    private $pro_convdimensao;
    private $pro_convproduto;
    private $pro_produtoconvpesobruto;
    private $pro_produtoconvpesoliq;

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getPro_convcodigo() {
        return $this->pro_convcodigo;
    }

    function getPro_convunidade() {
        return $this->pro_convunidade;
    }

    function getPro_convfator() {
        return $this->pro_convfator;
    }

    function getPro_convpadrao() {
        return $this->pro_convpadrao;
    }

    function getPro_convdimensao() {
        return $this->pro_convdimensao;
    }

    function getPro_convproduto() {
        return $this->pro_convproduto;
    }

    function getPro_produtoconvpesobruto() {
        return $this->pro_produtoconvpesobruto;
    }

    function getPro_produtoconvpesoliq() {
        return $this->pro_produtoconvpesoliq;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setPro_convcodigo($pro_convcodigo) {
        $this->pro_convcodigo = $pro_convcodigo;
    }

    function setPro_convunidade($pro_convunidade) {
        $this->pro_convunidade = $pro_convunidade;
    }

    function setPro_convfator($pro_convfator) {
        $this->pro_convfator = $pro_convfator;
    }

    function setPro_convpadrao($pro_convpadrao) {
        $this->pro_convpadrao = $pro_convpadrao;
    }

    function setPro_convdimensao($pro_convdimensao) {
        $this->pro_convdimensao = $pro_convdimensao;
    }

    function setPro_convproduto($pro_convproduto) {
        $this->pro_convproduto = $pro_convproduto;
    }

    function setPro_produtoconvpesobruto($pro_produtoconvpesobruto) {
        $this->pro_produtoconvpesobruto = $pro_produtoconvpesobruto;
    }

    function setPro_produtoconvpesoliq($pro_produtoconvpesoliq) {
        $this->pro_produtoconvpesoliq = $pro_produtoconvpesoliq;
    }

}
