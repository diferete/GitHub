<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualNovoProjRep {

    private $EmpRex;
    private $nr;
    private $Pessoa;
    private $resp_proj_cod;
    private $resp_proj_nome;
    private $dtimp;
    private $horaimp;
    private $resp_venda_cod;
    private $resp_venda_nome;
    private $sitproj;
    private $sitgeralproj;
    private $officecod;
    private $officedes;
    private $repnome;
    private $emailCli;
    private $contato;
    private $desc_novo_prod;
    private $quant_pc;
    private $anexo1;
    private $anexo2;
    private $anexo3;
    private $replibobs;
    private $sitvendas;
    private $repcod;
    private $sitcliente;
    private $acabamento;
    private $grucod;

    function getGrucod() {
        return $this->grucod;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function getAcabamento() {
        return $this->acabamento;
    }

    function setAcabamento($acabamento) {
        $this->acabamento = $acabamento;
    }

    function getSitcliente() {
        return $this->sitcliente;
    }

    function setSitcliente($sitcliente) {
        $this->sitcliente = $sitcliente;
    }

    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

    function getSitvendas() {
        return $this->sitvendas;
    }

    function setSitvendas($sitvendas) {
        $this->sitvendas = $sitvendas;
    }

    function getAnexo1() {
        return $this->anexo1;
    }

    function getAnexo2() {
        return $this->anexo2;
    }

    function getAnexo3() {
        return $this->anexo3;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

    function setAnexo3($anexo3) {
        $this->anexo3 = $anexo3;
    }

    function getReplibobs() {
        return $this->replibobs;
    }

    function setReplibobs($replibobs) {
        $this->replibobs = $replibobs;
    }

    function getQuant_pc() {
        return $this->quant_pc;
    }

    function setQuant_pc($quant_pc) {
        $this->quant_pc = $quant_pc;
    }

    function getDesc_novo_prod() {
        return $this->desc_novo_prod;
    }

    function setDesc_novo_prod($desc_novo_prod) {
        $this->desc_novo_prod = $desc_novo_prod;
    }

    function getContato() {
        return $this->contato;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function getEmailCli() {
        return $this->emailCli;
    }

    function setEmailCli($emailCli) {
        $this->emailCli = $emailCli;
    }

    function getRepnome() {
        return $this->repnome;
    }

    function setRepnome($repnome) {
        $this->repnome = $repnome;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficedes() {
        return $this->officedes;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficedes($officedes) {
        $this->officedes = $officedes;
    }

    function getSitproj() {
        return $this->sitproj;
    }

    function getSitgeralproj() {
        return $this->sitgeralproj;
    }

    function setSitproj($sitproj) {
        $this->sitproj = $sitproj;
    }

    function setSitgeralproj($sitgeralproj) {
        $this->sitgeralproj = $sitgeralproj;
    }

    function getEmpRex() {
        if (!isset($this->EmpRex)) {
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }

        return $this->EmpRex;
    }

    function getNr() {
        return $this->nr;
    }

    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function getResp_proj_cod() {
        return $this->resp_proj_cod;
    }

    function getResp_proj_nome() {
        return $this->resp_proj_nome;
    }

    function getDtimp() {
        return $this->dtimp;
    }

    function getHoraimp() {
        return $this->horaimp;
    }

    function getResp_venda_cod() {
        return $this->resp_venda_cod;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function setResp_proj_cod($resp_proj_cod) {
        $this->resp_proj_cod = $resp_proj_cod;
    }

    function setResp_proj_nome($resp_proj_nome) {
        $this->resp_proj_nome = $resp_proj_nome;
    }

    function setDtimp($dtimp) {
        $this->dtimp = $dtimp;
    }

    function setHoraimp($horaimp) {
        $this->horaimp = $horaimp;
    }

    function setResp_venda_cod($resp_venda_cod) {
        $this->resp_venda_cod = $resp_venda_cod;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

}
