<?php

/*
 * Classe que implementa os models da DELX_CID_Logradouro
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ModelDELX_CID_Logradouro {

    private $cid_paiscodigo;
    private $cid_logradourocep;
    private $cid_logradourorua;
    private $cid_logradourobairro;
    private $cid_logradourocidadecodigo;

    function getCid_paiscodigo() {
        return $this->cid_paiscodigo;
    }

    function getCid_logradourocep() {
        return $this->cid_logradourocep;
    }

    function getCid_logradourorua() {
        return $this->cid_logradourorua;
    }

    function getCid_logradourobairro() {
        return $this->cid_logradourobairro;
    }

    function getCid_logradourocidadecodigo() {
        return $this->cid_logradourocidadecodigo;
    }

    function setCid_paiscodigo($cid_paiscodigo) {
        $this->cid_paiscodigo = $cid_paiscodigo;
    }

    function setCid_logradourocep($cid_logradourocep) {
        $this->cid_logradourocep = $cid_logradourocep;
    }

    function setCid_logradourorua($cid_logradourorua) {
        $this->cid_logradourorua = $cid_logradourorua;
    }

    function setCid_logradourobairro($cid_logradourobairro) {
        $this->cid_logradourobairro = $cid_logradourobairro;
    }

    function setCid_logradourocidadecodigo($cid_logradourocidadecodigo) {
        $this->cid_logradourocidadecodigo = $cid_logradourocidadecodigo;
    }

}
