<?php

/*
 * Classe que implementa os models da STEEL_PCP_Preco
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class ModelSTEEL_PCP_Preco{
    
    private $tpv_codigo;
    private $CID_RegiaoCodigo;
    private $CPG_Codigo;
    private $MOE_Codigo;
    private $TPV_Descricao;
    private $TPV_Ativa;
    private $TPV_ClienteCodigo;
    private $TPV_DataInicio;
    private $TPV_Comissao;
    private $TPV_ComissaoInclusa;
    private $TPV_Markup;
    private $TPV_MargemNegociacao;
    private $TPV_Desconto;
    private $TPV_ArredondaPreco;
    private $TPV_ICMSIncluso;
    private $TPV_DataBase;
    private $FRE_TipoFreteCodigo;
    private $TPV_Cupom;
    private $TPV_LimiteDesconto;
    private $TPV_DataValidade;
    private $TPV_ConverteMoedaDigitacaoPedi;
    private $TPV_TabelaPrecoAVPIndice;
    private $TPV_TabelaPrecoAssociado;
    private $TPV_TabelaPrecoFormula;
    private $TPV_TabelaPrecoUsaVctoFixo;
    private $TPV_ValorFreteTon;
    
    function getTpv_codigo() {
        return $this->tpv_codigo;
    }

    function getCID_RegiaoCodigo() {
        return $this->CID_RegiaoCodigo;
    }

    function getCPG_Codigo() {
        return $this->CPG_Codigo;
    }

    function getMOE_Codigo() {
        return $this->MOE_Codigo;
    }

    function getTPV_Descricao() {
        return $this->TPV_Descricao;
    }

    function getTPV_Ativa() {
        return $this->TPV_Ativa;
    }

    function getTPV_ClienteCodigo() {
        return $this->TPV_ClienteCodigo;
    }

    function getTPV_DataInicio() {
        return $this->TPV_DataInicio;
    }

    function getTPV_Comissao() {
        return $this->TPV_Comissao;
    }

    function getTPV_ComissaoInclusa() {
        return $this->TPV_ComissaoInclusa;
    }

    function getTPV_Markup() {
        return $this->TPV_Markup;
    }

    function getTPV_MargemNegociacao() {
        return $this->TPV_MargemNegociacao;
    }

    function getTPV_Desconto() {
        return $this->TPV_Desconto;
    }

    function getTPV_ArredondaPreco() {
        return $this->TPV_ArredondaPreco;
    }

    function getTPV_ICMSIncluso() {
        return $this->TPV_ICMSIncluso;
    }

    function getTPV_DataBase() {
        return $this->TPV_DataBase;
    }

    function getFRE_TipoFreteCodigo() {
        return $this->FRE_TipoFreteCodigo;
    }

    function getTPV_Cupom() {
        return $this->TPV_Cupom;
    }

    function getTPV_LimiteDesconto() {
        return $this->TPV_LimiteDesconto;
    }

    function getTPV_DataValidade() {
        return $this->TPV_DataValidade;
    }

    function getTPV_ConverteMoedaDigitacaoPedi() {
        return $this->TPV_ConverteMoedaDigitacaoPedi;
    }

    function getTPV_TabelaPrecoAVPIndice() {
        return $this->TPV_TabelaPrecoAVPIndice;
    }

    function getTPV_TabelaPrecoAssociado() {
        return $this->TPV_TabelaPrecoAssociado;
    }

    function getTPV_TabelaPrecoFormula() {
        return $this->TPV_TabelaPrecoFormula;
    }

    function getTPV_TabelaPrecoUsaVctoFixo() {
        return $this->TPV_TabelaPrecoUsaVctoFixo;
    }

    function getTPV_ValorFreteTon() {
        return $this->TPV_ValorFreteTon;
    }

    function setTpv_codigo($tpv_codigo) {
        $this->tpv_codigo = $tpv_codigo;
    }

    function setCID_RegiaoCodigo($CID_RegiaoCodigo) {
        $this->CID_RegiaoCodigo = $CID_RegiaoCodigo;
    }

    function setCPG_Codigo($CPG_Codigo) {
        $this->CPG_Codigo = $CPG_Codigo;
    }

    function setMOE_Codigo($MOE_Codigo) {
        $this->MOE_Codigo = $MOE_Codigo;
    }

    function setTPV_Descricao($TPV_Descricao) {
        $this->TPV_Descricao = $TPV_Descricao;
    }

    function setTPV_Ativa($TPV_Ativa) {
        $this->TPV_Ativa = $TPV_Ativa;
    }

    function setTPV_ClienteCodigo($TPV_ClienteCodigo) {
        $this->TPV_ClienteCodigo = $TPV_ClienteCodigo;
    }

    function setTPV_DataInicio($TPV_DataInicio) {
        $this->TPV_DataInicio = $TPV_DataInicio;
    }

    function setTPV_Comissao($TPV_Comissao) {
        $this->TPV_Comissao = $TPV_Comissao;
    }

    function setTPV_ComissaoInclusa($TPV_ComissaoInclusa) {
        $this->TPV_ComissaoInclusa = $TPV_ComissaoInclusa;
    }

    function setTPV_Markup($TPV_Markup) {
        $this->TPV_Markup = $TPV_Markup;
    }

    function setTPV_MargemNegociacao($TPV_MargemNegociacao) {
        $this->TPV_MargemNegociacao = $TPV_MargemNegociacao;
    }

    function setTPV_Desconto($TPV_Desconto) {
        $this->TPV_Desconto = $TPV_Desconto;
    }

    function setTPV_ArredondaPreco($TPV_ArredondaPreco) {
        $this->TPV_ArredondaPreco = $TPV_ArredondaPreco;
    }

    function setTPV_ICMSIncluso($TPV_ICMSIncluso) {
        $this->TPV_ICMSIncluso = $TPV_ICMSIncluso;
    }

    function setTPV_DataBase($TPV_DataBase) {
        $this->TPV_DataBase = $TPV_DataBase;
    }

    function setFRE_TipoFreteCodigo($FRE_TipoFreteCodigo) {
        $this->FRE_TipoFreteCodigo = $FRE_TipoFreteCodigo;
    }

    function setTPV_Cupom($TPV_Cupom) {
        $this->TPV_Cupom = $TPV_Cupom;
    }

    function setTPV_LimiteDesconto($TPV_LimiteDesconto) {
        $this->TPV_LimiteDesconto = $TPV_LimiteDesconto;
    }

    function setTPV_DataValidade($TPV_DataValidade) {
        $this->TPV_DataValidade = $TPV_DataValidade;
    }

    function setTPV_ConverteMoedaDigitacaoPedi($TPV_ConverteMoedaDigitacaoPedi) {
        $this->TPV_ConverteMoedaDigitacaoPedi = $TPV_ConverteMoedaDigitacaoPedi;
    }

    function setTPV_TabelaPrecoAVPIndice($TPV_TabelaPrecoAVPIndice) {
        $this->TPV_TabelaPrecoAVPIndice = $TPV_TabelaPrecoAVPIndice;
    }

    function setTPV_TabelaPrecoAssociado($TPV_TabelaPrecoAssociado) {
        $this->TPV_TabelaPrecoAssociado = $TPV_TabelaPrecoAssociado;
    }

    function setTPV_TabelaPrecoFormula($TPV_TabelaPrecoFormula) {
        $this->TPV_TabelaPrecoFormula = $TPV_TabelaPrecoFormula;
    }

    function setTPV_TabelaPrecoUsaVctoFixo($TPV_TabelaPrecoUsaVctoFixo) {
        $this->TPV_TabelaPrecoUsaVctoFixo = $TPV_TabelaPrecoUsaVctoFixo;
    }

    function setTPV_ValorFreteTon($TPV_ValorFreteTon) {
        $this->TPV_ValorFreteTon = $TPV_ValorFreteTon;
    }
    
}