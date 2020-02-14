<?php

/*
 * Classe que implementa os models da DELX_CID_Cidade
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ModelDELX_CID_Cidade {

    private $cid_paiscodigo;
    private $cid_codigo;
    private $cid_estadocodigo;
    private $cid_descricao;
    private $cid_cidadecodibge;

    function getCid_paiscodigo() {
        return $this->cid_paiscodigo;
    }

    function getCid_codigo() {
        return $this->cid_codigo;
    }

    function getCid_estadocodigo() {
        return $this->cid_estadocodigo;
    }

    function getCid_descricao() {
        return $this->cid_descricao;
    }

    function getCid_cidadecodibge() {
        return $this->cid_cidadecodibge;
    }

    function setCid_paiscodigo($cid_paiscodigo) {
        $this->cid_paiscodigo = $cid_paiscodigo;
    }

    function setCid_codigo($cid_codigo) {
        $this->cid_codigo = $cid_codigo;
    }

    function setCid_estadocodigo($cid_estadocodigo) {
        $this->cid_estadocodigo = $cid_estadocodigo;
    }

    function setCid_descricao($cid_descricao) {
        $this->cid_descricao = $cid_descricao;
    }

    function setCid_cidadecodibge($cid_cidadecodibge) {
        $this->cid_cidadecodibge = $cid_cidadecodibge;
    }

}
