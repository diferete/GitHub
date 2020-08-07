<?php

/*
 * Classe que implementa os models da DELX_CAD_Pessoa
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ModelMET_PROD_Produtos {

    private $pro_codigo;
    private $pro_descricao;
    private $pro_unidademedida;

    function getPro_unidademedida() {
        return $this->pro_unidademedida;
    }

    function setPro_unidademedida($pro_unidademedida) {
        $this->pro_unidademedida = $pro_unidademedida;
    }

    function getPro_descricao() {
        return $this->pro_descricao;
    }

    function setPro_descricao($pro_descricao) {
        $this->pro_descricao = $pro_descricao;
    }

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

}
