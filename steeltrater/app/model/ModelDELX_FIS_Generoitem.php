<?php

/*
 * Implementa classe controller
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * * */

class ModelDELX_FIS_Generoitem {

    private $fis_generoitemcodigo;
    private $fis_generoitemdescricao;

    function getFis_generoitemcodigo() {
        return $this->fis_generoitemcodigo;
    }

    function getFis_generoitemdescricao() {
        return $this->fis_generoitemdescricao;
    }

    function setFis_generoitemcodigo($fis_generoitemcodigo) {
        $this->fis_generoitemcodigo = $fis_generoitemcodigo;
    }

    function setFis_generoitemdescricao($fis_generoitemdescricao) {
        $this->fis_generoitemdescricao = $fis_generoitemdescricao;
    }

}
