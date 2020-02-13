<?php

/*
 * Classe que implementa os models da DELX_FIN_BancoConta
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ModelDELX_FIN_BancoConta {

    private $fin_bancocodigo;
    private $fin_bancocontanumero;
    private $fin_bancocontaagencia;
    private $fin_bancocontageraremessa;
    private $fin_bancocontacobrancaseq;
    private $fin_bancocontapagamentoseq;
    private $fin_bancocontaemitecheque;
    private $fin_bancocontaultimocheque;
    private $fin_bancocontalaycheque;
    private $fin_bancocontafilial;

    function getFin_bancocodigo() {
        return $this->fin_bancocodigo;
    }

    function getFin_bancocontanumero() {
        return $this->fin_bancocontanumero;
    }

    function getFin_bancocontaagencia() {
        return $this->fin_bancocontaagencia;
    }

    function getFin_bancocontageraremessa() {
        return $this->fin_bancocontageraremessa;
    }

    function getFin_bancocontacobrancaseq() {
        return $this->fin_bancocontacobrancaseq;
    }

    function getFin_bancocontapagamentoseq() {
        return $this->fin_bancocontapagamentoseq;
    }

    function getFin_bancocontaemitecheque() {
        return $this->fin_bancocontaemitecheque;
    }

    function getFin_bancocontaultimocheque() {
        return $this->fin_bancocontaultimocheque;
    }

    function getFin_bancocontalaycheque() {
        return $this->fin_bancocontalaycheque;
    }

    function getFin_bancocontafilial() {
        return $this->fin_bancocontafilial;
    }

    function setFin_bancocodigo($fin_bancocodigo) {
        $this->fin_bancocodigo = $fin_bancocodigo;
    }

    function setFin_bancocontanumero($fin_bancocontanumero) {
        $this->fin_bancocontanumero = $fin_bancocontanumero;
    }

    function setFin_bancocontaagencia($fin_bancocontaagencia) {
        $this->fin_bancocontaagencia = $fin_bancocontaagencia;
    }

    function setFin_bancocontageraremessa($fin_bancocontageraremessa) {
        $this->fin_bancocontageraremessa = $fin_bancocontageraremessa;
    }

    function setFin_bancocontacobrancaseq($fin_bancocontacobrancaseq) {
        $this->fin_bancocontacobrancaseq = $fin_bancocontacobrancaseq;
    }

    function setFin_bancocontapagamentoseq($fin_bancocontapagamentoseq) {
        $this->fin_bancocontapagamentoseq = $fin_bancocontapagamentoseq;
    }

    function setFin_bancocontaemitecheque($fin_bancocontaemitecheque) {
        $this->fin_bancocontaemitecheque = $fin_bancocontaemitecheque;
    }

    function setFin_bancocontaultimocheque($fin_bancocontaultimocheque) {
        $this->fin_bancocontaultimocheque = $fin_bancocontaultimocheque;
    }

    function setFin_bancocontalaycheque($fin_bancocontalaycheque) {
        $this->fin_bancocontalaycheque = $fin_bancocontalaycheque;
    }

    function setFin_bancocontafilial($fin_bancocontafilial) {
        $this->fin_bancocontafilial = $fin_bancocontafilial;
    }

}
