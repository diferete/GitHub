<?php

/*
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * * */

class ModelDELX_FIS_Cnae {

    private $fis_cnaecodigo;
    private $fis_cnaedescricao;

    function getFis_cnaecodigo() {
        return $this->fis_cnaecodigo;
    }

    function getFis_cnaedescricao() {
        return $this->fis_cnaedescricao;
    }

    function setFis_cnaecodigo($fis_cnaecodigo) {
        $this->fis_cnaecodigo = $fis_cnaecodigo;
    }

    function setFis_cnaedescricao($fis_cnaedescricao) {
        $this->fis_cnaedescricao = $fis_cnaedescricao;
    }

}
