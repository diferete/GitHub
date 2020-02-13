<?php

/*
 * Classe que implementa os models da DELX_PRO_Grupo
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class ModelDELX_PRO_Grupo {

    private $pro_grupodescricao;
    private $pro_grupocodigo;

    function getPro_grupocodigo() {
        return $this->pro_grupocodigo;
    }

    function setPro_grupocodigo($pro_grupocodigo) {
        $this->pro_grupocodigo = $pro_grupocodigo;
    }

    function getPro_grupodescricao() {
        return $this->pro_grupodescricao;
    }

    function setPro_grupodescricao($pro_grupodescricao) {
        $this->pro_grupodescricao = $pro_grupodescricao;
    }

}
