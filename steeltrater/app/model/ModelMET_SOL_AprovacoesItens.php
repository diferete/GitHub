<?php

/*
 * Implementa a classe model MET_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ModelMET_SOL_AprovacoesItens {

    private $filcgc;
    private $solcod;
    private $solproseq;
    private $solproqtda;
    private $procod;
    private $Produto;

    function getFilcgc() {
        return $this->filcgc;
    }

    function getSolcod() {
        return $this->solcod;
    }

    function getSolproseq() {
        return $this->solproseq;
    }

    function getSolproqtda() {
        return $this->solproqtda;
    }

    function getProcod() {
        return $this->procod;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setSolcod($solcod) {
        $this->solcod = $solcod;
    }

    function setSolproseq($solproseq) {
        $this->solproseq = $solproseq;
    }

    function setSolproqtda($solproqtda) {
        $this->solproqtda = $solproqtda;
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
