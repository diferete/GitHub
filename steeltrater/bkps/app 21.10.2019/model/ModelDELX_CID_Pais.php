<?php

/*
 * Classe que implementa os models da DELX_CID_Pais
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ModelDELX_CID_Pais {

    private $cid_paiscodigo;
    private $cid_paisdescricao;
    private $cid_paisusacep;
    private $cid_paisibge;

    function getCid_paiscodigo() {
        return $this->cid_paiscodigo;
    }

    function getCid_paisdescricao() {
        return $this->cid_paisdescricao;
    }

    function getCid_paisusacep() {
        return $this->cid_paisusacep;
    }

    function getCid_paisibge() {
        return $this->cid_paisibge;
    }

    function setCid_paiscodigo($cid_paiscodigo) {
        $this->cid_paiscodigo = $cid_paiscodigo;
    }

    function setCid_paisdescricao($cid_paisdescricao) {
        $this->cid_paisdescricao = $cid_paisdescricao;
    }

    function setCid_paisusacep($cid_paisusacep) {
        $this->cid_paisusacep = $cid_paisusacep;
    }

    function setCid_paisibge($cid_paisibge) {
        $this->cid_paisibge = $cid_paisibge;
    }

}
