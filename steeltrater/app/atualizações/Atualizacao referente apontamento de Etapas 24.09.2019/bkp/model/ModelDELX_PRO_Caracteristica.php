<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ModelDELX_PRO_Caracteristica {

    private $pro_caracteristicacodigo;
    private $pro_caracteristicadescricao;
    private $pro_caracteristicavlrdefinidos;
    
    function getPro_caracteristicacodigo() {
        return $this->pro_caracteristicacodigo;
    }

    function getPro_caracteristicadescricao() {
        return $this->pro_caracteristicadescricao;
    }

    function getPro_caracteristicavlrdefinidos() {
        return $this->pro_caracteristicavlrdefinidos;
    }

    function setPro_caracteristicacodigo($pro_caracteristicacodigo) {
        $this->pro_caracteristicacodigo = $pro_caracteristicacodigo;
    }

    function setPro_caracteristicadescricao($pro_caracteristicadescricao) {
        $this->pro_caracteristicadescricao = $pro_caracteristicadescricao;
    }

    function setPro_caracteristicavlrdefinidos($pro_caracteristicavlrdefinidos) {
        $this->pro_caracteristicavlrdefinidos = $pro_caracteristicavlrdefinidos;
    }



}
