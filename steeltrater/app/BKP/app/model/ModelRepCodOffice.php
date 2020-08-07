<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelRepCodOffice {

    private $filcgc;
    private $officecod;
    private $officeseq;
    private $repcod;
    private $resp_venda_cod;
    private $resp_venda_nome;

    function getResp_venda_cod() {
        return $this->resp_venda_cod;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setResp_venda_cod($resp_venda_cod) {
        $this->resp_venda_cod = $resp_venda_cod;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficeseq() {
        return $this->officeseq;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficeseq($officeseq) {
        $this->officeseq = $officeseq;
    }

}
