<?php

/**
 * Implementa Model da classe
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class ModelDELX_PRO_Produtocoproduto {

    private $pro_codigo;
    private $pro_coprodutoseq;
    private $pro_coprodutocodigo;
    private $pro_coprodutograde;
    private $pro_coprodutoquantidade;
    private $pro_coprodutomotivo;

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getPro_coprodutoseq() {
        return $this->pro_coprodutoseq;
    }

    function getPro_coprodutocodigo() {
        return $this->pro_coprodutocodigo;
    }

    function getPro_coprodutograde() {
        return $this->pro_coprodutograde;
    }

    function getPro_coprodutoquantidade() {
        return $this->pro_coprodutoquantidade;
    }

    function getPro_coprodutomotivo() {
        return $this->pro_coprodutomotivo;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setPro_coprodutoseq($pro_coprodutoseq) {
        $this->pro_coprodutoseq = $pro_coprodutoseq;
    }

    function setPro_coprodutocodigo($pro_coprodutocodigo) {
        $this->pro_coprodutocodigo = $pro_coprodutocodigo;
    }

    function setPro_coprodutograde($pro_coprodutograde) {
        $this->pro_coprodutograde = $pro_coprodutograde;
    }

    function setPro_coprodutoquantidade($pro_coprodutoquantidade) {
        $this->pro_coprodutoquantidade = $pro_coprodutoquantidade;
    }

    function setPro_coprodutomotivo($pro_coprodutomotivo) {
        $this->pro_coprodutomotivo = $pro_coprodutomotivo;
    }

}
