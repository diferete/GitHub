<?php

/*
 * Classe que gerencia a Model da MET_GerenciaFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ModelMET_GerenciaFrete {
    
    private $Pessoa;
    private $nr;  
    private $cnpj; 
    private $nrconhe; 
    private $nrfat; 
    private $nrnotaoc; 
    private $totakg; 
    private $totalnf; 
    private $valorserv; 
    private $fracaofrete;
    private $seqregra; 
    private $codtipo;
    private $data;
    private $hora; 
    private $sit;
    private $usuario;
    private $obsfinal;
    private $empdes;
    private $dataem;
    private $datafn;
    private $valorserv2;
    private $valorserv3;
    
    function getValorserv3() {
        return $this->valorserv3;
    }

    function setValorserv3($valorserv3) {
        $this->valorserv3 = $valorserv3;
    }
    
    function getValorserv2() {
        return $this->valorserv2;
    }

    function setValorserv2($valorserv2) {
        $this->valorserv2 = $valorserv2;
    }
    
    function getDatafn() {
        return $this->datafn;
    }

    function setDatafn($datafn) {
        $this->datafn = $datafn;
    }
    
    function getDataem() {
        return $this->dataem;
    }

    function setDataem($dataem) {
        $this->dataem = $dataem;
    }
    
    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }
    
    function getFracaofrete() {
        return number_format($this->fracaofrete,0);
    }

    function getCodtipo() {
        return $this->codtipo;
    }

    function setFracaofrete($fracaofrete) {
        $this->fracaofrete = $fracaofrete;
    }

    function setCodtipo($codtipo) {
        $this->codtipo = $codtipo;
    }
    
    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }        

    function getNr() {
        return $this->nr;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getNrconhe() {
        return $this->nrconhe;
    }

    function getNrfat() {
        return $this->nrfat;
    }

    function getNrnotaoc() {
        return $this->nrnotaoc;
    }

    function getTotakg() {
        return $this->totakg;
    }

    function getTotalnf() {
        return $this->totalnf;
    }

    function getValorserv() {
        return $this->valorserv;
    }

    function getSeqregra() {
        return $this->seqregra;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getSit() {
        return $this->sit;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getObsfinal() {
        return $this->obsfinal;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setNrconhe($nrconhe) {
        $this->nrconhe = $nrconhe;
    }

    function setNrfat($nrfat) {
        $this->nrfat = $nrfat;
    }

    function setNrnotaoc($nrnotaoc) {
        $this->nrnotaoc = $nrnotaoc;
    }

    function setTotakg($totakg) {
        $this->totakg = $totakg;
    }

    function setTotalnf($totalnf) {
        $this->totalnf = $totalnf;
    }

    function setValorserv($valorserv) {
        $this->valorserv = $valorserv;
    }

    function setSeqregra($seqregra) {
        $this->seqregra = $seqregra;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setObsfinal($obsfinal) {
        $this->obsfinal = $obsfinal;
    }
    
}