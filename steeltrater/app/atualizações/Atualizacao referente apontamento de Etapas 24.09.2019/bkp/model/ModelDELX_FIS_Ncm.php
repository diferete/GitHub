<?php

/**
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 *  */
class ModelDELX_FIS_Ncm {

    private $fis_ncmcodigo;
    private $fis_ncmdescricao;

    function getFis_ncmcodigo() {
        return $this->fis_ncmcodigo;
    }

    function getFis_ncmdescricao() {
        return $this->fis_ncmdescricao;
    }

    function setFis_ncmcodigo($fis_ncmcodigo) {
        $this->fis_ncmcodigo = $fis_ncmcodigo;
    }

    function setFis_ncmdescricao($fis_ncmdescricao) {
        $this->fis_ncmdescricao = $fis_ncmdescricao;
    }

}
