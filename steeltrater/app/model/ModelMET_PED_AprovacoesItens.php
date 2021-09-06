<?php

/*
 * Implementa a classe model MET_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class ModelMET_PED_AprovacoesItens {

    private $filcgc;
    private $pdcnro;
    private $pdcproseq;
    private $pdcproqtdp;
    private $pdcprovlru;
    private $procod;
    private $Produto;

    function getPdcprovlru() {
        return $this->pdcprovlru;
    }

    function setPdcprovlru($pdcprovlru) {
        $this->pdcprovlru = $pdcprovlru;
    }

    function getPdcproqtdp() {
        return $this->pdcproqtdp;
    }

    function setPdcproqtdp($pdcproqtdp) {
        $this->pdcproqtdp = $pdcproqtdp;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getPdcnro() {
        return $this->pdcnro;
    }

    function getPdcproseq() {
        return $this->pdcproseq;
    }

    function getProcod() {
        return $this->procod;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setPdcnro($pdcnro) {
        $this->pdcnro = $pdcnro;
    }

    function setPdcproseq($pdcproseq) {
        $this->pdcproseq = $pdcproseq;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function getProduto() {
        if (!isset($this->Produto)) {
            $this->Produto = Fabrica::FabricarModel('Produto');
        }
        return $this->Produto;
    }

    function setProduto($Produto) {
        $this->Produto = $Produto;
    }

}
