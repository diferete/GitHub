<?php

/* 
 * Classe que implementa a model da importaçao do xml para gerar ops
 * 
 * @author Avanei Martendal
 * @since 13/02/2019
 */

class ModelSTEEL_PCP_ImportaXml {
    
    private $seq;
    private $empcod;
    private $empdes;
    private $nfnro;
    private $nfser;
    private $nfseq;
    private $procod;
    private $prodes;
    private $un;
    private $qtd;
    private $vlrUnit;
    private $vlrTotal;
    private $dataimp;
    private $horaimp;
    private $opSteel;
    private $ncm;
    private $CodInterno;
    private $opCliente;
    private $xPed;
    private $nItemPed;
    

    function getXPed() {
        return $this->xPed;
    }

    function getNItemPed() {
        return $this->nItemPed;
    }

    function setXPed($xPed) {
        $this->xPed = $xPed;
    }

    function setNItemPed($nItemPed) {
        $this->nItemPed = $nItemPed;
    }

        
    function getOpCliente() {
        return $this->opCliente;
    }

    function setOpCliente($opCliente) {
        $this->opCliente = $opCliente;
    }

        
    function getCodInterno() {
        return $this->CodInterno;
    }

    function setCodInterno($CodInterno) {
        $this->CodInterno = $CodInterno;
    }

        
            
    function getNcm() {
        return $this->ncm;
    }

    function setNcm($ncm) {
        $this->ncm = $ncm;
    }

        
    function getOpSteel() {
        return $this->opSteel;
    }

    function setOpSteel($opSteel) {
        $this->opSteel = $opSteel;
    }

            
    function getDataimp() {
        return $this->dataimp;
    }

    function getHoraimp() {
        return $this->horaimp;
    }

    function setDataimp($dataimp) {
        $this->dataimp = $dataimp;
    }

    function setHoraimp($horaimp) {
        $this->horaimp = $horaimp;
    }

                
    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getUn() {
        return $this->un;
    }

    function getQtd() {
        return $this->qtd;
    }

    function getVlrUnit() {
        return $this->vlrUnit;
    }

    function getVlrTotal() {
        return $this->vlrTotal;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setUn($un) {
        $this->un = $un;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    function setVlrUnit($vlrUnit) {
        $this->vlrUnit = $vlrUnit;
    }

    function setVlrTotal($vlrTotal) {
        $this->vlrTotal = $vlrTotal;
    }

        
    function getNfseq() {
        return $this->nfseq;
    }

    function setNfseq($nfseq) {
        $this->nfseq = $nfseq;
    }

        
    function getSeq() {
        return $this->seq;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getNfnro() {
        return $this->nfnro;
    }

    function getNfser() {
        return $this->nfser;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setNfnro($nfnro) {
        $this->nfnro = $nfnro;
    }

    function setNfser($nfser) {
        $this->nfser = $nfser;
    }

    

    
}

