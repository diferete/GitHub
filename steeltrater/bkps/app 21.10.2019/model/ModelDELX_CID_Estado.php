<?php

/*
 * Classe que implementa os models da DELX_CID_Estado
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ModelDELX_CID_Estado {

    private $cid_paiscodigo;
    private $cid_estadocodigo;
    private $cid_estadodescricao;
    private $cid_estadoibge;
    private $cid_estadoaliquotaintra;
    private $cid_estadoaliquotainter;

    function getCid_paiscodigo() {
        return $this->cid_paiscodigo;
    }

    function getCid_estadocodigo() {
        return $this->cid_estadocodigo;
    }

    function getCid_estadodescricao() {
        return $this->cid_estadodescricao;
    }

    function getCid_estadoibge() {
        return $this->cid_estadoibge;
    }

    function getCid_estadoaliquotaintra() {
        return $this->cid_estadoaliquotaintra;
    }

    function getCid_estadoaliquotainter() {
        return $this->cid_estadoaliquotainter;
    }

    function setCid_paiscodigo($cid_paiscodigo) {
        $this->cid_paiscodigo = $cid_paiscodigo;
    }

    function setCid_estadocodigo($cid_estadocodigo) {
        $this->cid_estadocodigo = $cid_estadocodigo;
    }

    function setCid_estadodescricao($cid_estadodescricao) {
        $this->cid_estadodescricao = $cid_estadodescricao;
    }

    function setCid_estadoibge($cid_estadoibge) {
        $this->cid_estadoibge = $cid_estadoibge;
    }

    function setCid_estadoaliquotaintra($cid_estadoaliquotaintra) {
        $this->cid_estadoaliquotaintra = $cid_estadoaliquotaintra;
    }

    function setCid_estadoaliquotainter($cid_estadoaliquotainter) {
        $this->cid_estadoaliquotainter = $cid_estadoaliquotainter;
    }

}
