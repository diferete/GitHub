<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_SUP_Solicitacao {

    private $FIL_Codigo;
    private $SUP_SolicitacaoSeq;
    private $SUP_SolicitacaoDataHora;
    private $DELX_FIL_Empresa;
    private $SUP_SolicitacaoObservacao;
    private $SUP_SolicitacaoUsuCadastro;
    private $SUP_SolicitacaoObsEntrega;
    private $SUP_SolicitacaoTipo;
    private $SUP_SolicitacaoSituacao;
    private $SUP_SolicitacaoFaseApr;
    private $SUP_SolicitacaoMRP;
    private $SUP_SolicitacaoUsuAprovador;
    private $SUP_SolicitacaoCCTCod;
    private $SUP_SolicitacaoDataCanc;
    private $SUP_SolicitacaoUsuCanc;

    function getFIL_Codigo() {
        return $this->FIL_Codigo;
    }

    function getSUP_SolicitacaoSeq() {
        return $this->SUP_SolicitacaoSeq;
    }

    function getSUP_SolicitacaoDataHora() {
        return $this->SUP_SolicitacaoDataHora;
    }

    function getDELX_FIL_Empresa() {
        if (!isset($this->DELX_FIL_Empresa)) {
            $this->DELX_FIL_Empresa = Fabrica::FabricarModel('DELX_FIL_Empresa');
        }
        return $this->DELX_FIL_Empresa;
    }

    function getSUP_SolicitacaoObservacao() {
        return $this->SUP_SolicitacaoObservacao;
    }

    function getSUP_SolicitacaoUsuCadastro() {
        return $this->SUP_SolicitacaoUsuCadastro;
    }

    function getSUP_SolicitacaoObsEntrega() {
        return $this->SUP_SolicitacaoObsEntrega;
    }

    function getSUP_SolicitacaoTipo() {
        return $this->SUP_SolicitacaoTipo;
    }

    function getSUP_SolicitacaoSituacao() {
        return $this->SUP_SolicitacaoSituacao;
    }

    function getSUP_SolicitacaoFaseApr() {
        return $this->SUP_SolicitacaoFaseApr;
    }

    function getSUP_SolicitacaoMRP() {
        return $this->SUP_SolicitacaoMRP;
    }

    function getSUP_SolicitacaoUsuAprovador() {
        return $this->SUP_SolicitacaoUsuAprovador;
    }

    function getSUP_SolicitacaoCCTCod() {
        return $this->SUP_SolicitacaoCCTCod;
    }

    function getSUP_SolicitacaoDataCanc() {
        return $this->SUP_SolicitacaoDataCanc;
    }

    function getSUP_SolicitacaoUsuCanc() {
        return $this->SUP_SolicitacaoUsuCanc;
    }

    function setFIL_Codigo($FIL_Codigo) {
        $this->FIL_Codigo = $FIL_Codigo;
    }

    function setSUP_SolicitacaoSeq($SUP_SolicitacaoSeq) {
        $this->SUP_SolicitacaoSeq = $SUP_SolicitacaoSeq;
    }

    function setSUP_SolicitacaoDataHora($SUP_SolicitacaoDataHora) {
        $this->SUP_SolicitacaoDataHora = $SUP_SolicitacaoDataHora;
    }

    function setDELX_FIL_Empresa($DELX_FIL_Empresa) {
        $this->DELX_FIL_Empresa = $DELX_FIL_Empresa;
    }

    function setSUP_SolicitacaoObservacao($SUP_SolicitacaoObservacao) {
        $this->SUP_SolicitacaoObservacao = $SUP_SolicitacaoObservacao;
    }

    function setSUP_SolicitacaoUsuCadastro($SUP_SolicitacaoUsuCadastro) {
        $this->SUP_SolicitacaoUsuCadastro = $SUP_SolicitacaoUsuCadastro;
    }

    function setSUP_SolicitacaoObsEntrega($SUP_SolicitacaoObsEntrega) {
        $this->SUP_SolicitacaoObsEntrega = $SUP_SolicitacaoObsEntrega;
    }

    function setSUP_SolicitacaoTipo($SUP_SolicitacaoTipo) {
        $this->SUP_SolicitacaoTipo = $SUP_SolicitacaoTipo;
    }

    function setSUP_SolicitacaoSituacao($SUP_SolicitacaoSituacao) {
        $this->SUP_SolicitacaoSituacao = $SUP_SolicitacaoSituacao;
    }

    function setSUP_SolicitacaoFaseApr($SUP_SolicitacaoFaseApr) {
        $this->SUP_SolicitacaoFaseApr = $SUP_SolicitacaoFaseApr;
    }

    function setSUP_SolicitacaoMRP($SUP_SolicitacaoMRP) {
        $this->SUP_SolicitacaoMRP = $SUP_SolicitacaoMRP;
    }

    function setSUP_SolicitacaoUsuAprovador($SUP_SolicitacaoUsuAprovador) {
        $this->SUP_SolicitacaoUsuAprovador = $SUP_SolicitacaoUsuAprovador;
    }

    function setSUP_SolicitacaoCCTCod($SUP_SolicitacaoCCTCod) {
        $this->SUP_SolicitacaoCCTCod = $SUP_SolicitacaoCCTCod;
    }

    function setSUP_SolicitacaoDataCanc($SUP_SolicitacaoDataCanc) {
        $this->SUP_SolicitacaoDataCanc = $SUP_SolicitacaoDataCanc;
    }

    function setSUP_SolicitacaoUsuCanc($SUP_SolicitacaoUsuCanc) {
        $this->SUP_SolicitacaoUsuCanc = $SUP_SolicitacaoUsuCanc;
    }

}
