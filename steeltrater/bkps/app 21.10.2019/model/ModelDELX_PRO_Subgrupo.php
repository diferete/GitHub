<?php

/*
 * Classe que implementa os models da DELX_PRO_Subgrupo
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class ModelDELX_PRO_Subgrupo {

    private $pro_grupocodigo;
    private $pro_subgrupocodigo;
    private $pro_subgrupodescricao;

    function getPro_grupocodigo() {
        return $this->pro_grupocodigo;
    }

    function setPro_grupocodigo($pro_grupocodigo) {
        $this->pro_grupocodigo = $pro_grupocodigo;
    }

    function getPro_subgrupocodigo() {
        return $this->pro_subgrupocodigo;
    }

    function setPro_subgrupocodigo($pro_subgrupocodigo) {
        $this->pro_subgrupocodigo = $pro_subgrupocodigo;
    }

    function getPro_subgrupodescricao() {
        return $this->pro_subgrupodescricao;
    }

    function setPro_subgrupodescricao($pro_subgrupodescricao) {
        $this->pro_subgrupodescricao = $pro_subgrupodescricao;
    }

}
