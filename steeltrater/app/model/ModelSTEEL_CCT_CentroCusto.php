<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelSTEEL_CCT_CentroCusto
 *
 * @author Alexandre
 */
class ModelSTEEL_CCT_CentroCusto {

    private $cct_codigo;
    private $cct_descricao;
    private $STEEL_CCT_CentroCustoFilial;
    private $CCT_Classificacao;
    private $CCT_Tipo;
    private $CCT_VigenciaInicial;
    private $CCT_VigenciaFinal;
    private $CCT_QtdMesesMedia;
    /**/
    private $CCT_Produtivo;
    private $PEO_CentroCustoORC;
    private $PEO_CentroCustoDRT;
    private $PEO_CentroCustoPEO;
    private $PEO_CentroCustoBLV;
    private $MNT_CentroCustoAbreOS;
    private $MNT_CentroCustoApontaOS;
    private $PEO_CentroCustoOCE;
    private $MNT_CentroCustoCriticidade;
    private $MNT_CentroCustoArea;
    private $MNT_CentroCustoTipoAprovacao;
    private $MNT_CentroCustoAprovAutomatica;
    private $ESP_HolambraCCTFilialDestino;
    private $ESP_HolambraCCTPlanoDestino;
    private $ESP_HolambraCCTContaDestino;

    function getSTEEL_CCT_CentroCustoFilial() {
        if (!isset($this->STEEL_CCT_CentroCustoFilial)) {
            $this->STEEL_CCT_CentroCustoFilial = Fabrica::FabricarModel('STEEL_CCT_CentroCustoFilial');
        }
        return $this->STEEL_CCT_CentroCustoFilial;
    }

    function setSTEEL_CCT_CentroCustoFilial($STEEL_CCT_CentroCustoFilial) {
        $this->STEEL_CCT_CentroCustoFilial = $STEEL_CCT_CentroCustoFilial;
    }

    function getCCT_Classificacao() {
        return $this->CCT_Classificacao;
    }

    function getCCT_Tipo() {
        return $this->CCT_Tipo;
    }

    function getCCT_VigenciaInicial() {
        return $this->CCT_VigenciaInicial;
    }

    function getCCT_VigenciaFinal() {
        return $this->CCT_VigenciaFinal;
    }

    function getCCT_QtdMesesMedia() {
        return $this->CCT_QtdMesesMedia;
    }

    function getCCT_Produtivo() {
        return $this->CCT_Produtivo;
    }

    function getPEO_CentroCustoORC() {
        return $this->PEO_CentroCustoORC;
    }

    function getPEO_CentroCustoDRT() {
        return $this->PEO_CentroCustoDRT;
    }

    function getPEO_CentroCustoPEO() {
        return $this->PEO_CentroCustoPEO;
    }

    function getPEO_CentroCustoBLV() {
        return $this->PEO_CentroCustoBLV;
    }

    function getMNT_CentroCustoAbreOS() {
        return $this->MNT_CentroCustoAbreOS;
    }

    function getMNT_CentroCustoApontaOS() {
        return $this->MNT_CentroCustoApontaOS;
    }

    function getPEO_CentroCustoOCE() {
        return $this->PEO_CentroCustoOCE;
    }

    function getMNT_CentroCustoCriticidade() {
        return $this->MNT_CentroCustoCriticidade;
    }

    function getMNT_CentroCustoArea() {
        return $this->MNT_CentroCustoArea;
    }

    function getMNT_CentroCustoTipoAprovacao() {
        return $this->MNT_CentroCustoTipoAprovacao;
    }

    function getMNT_CentroCustoAprovAutomatica() {
        return $this->MNT_CentroCustoAprovAutomatica;
    }

    function getESP_HolambraCCTFilialDestino() {
        return $this->ESP_HolambraCCTFilialDestino;
    }

    function getESP_HolambraCCTPlanoDestino() {
        return $this->ESP_HolambraCCTPlanoDestino;
    }

    function getESP_HolambraCCTContaDestino() {
        return $this->ESP_HolambraCCTContaDestino;
    }

    function setCCT_Classificacao($CCT_Classificacao) {
        $this->CCT_Classificacao = $CCT_Classificacao;
    }

    function setCCT_Tipo($CCT_Tipo) {
        $this->CCT_Tipo = $CCT_Tipo;
    }

    function setCCT_VigenciaInicial($CCT_VigenciaInicial) {
        $this->CCT_VigenciaInicial = $CCT_VigenciaInicial;
    }

    function setCCT_VigenciaFinal($CCT_VigenciaFinal) {
        $this->CCT_VigenciaFinal = $CCT_VigenciaFinal;
    }

    function setCCT_QtdMesesMedia($CCT_QtdMesesMedia) {
        $this->CCT_QtdMesesMedia = $CCT_QtdMesesMedia;
    }

    function setCCT_Produtivo($CCT_Produtivo) {
        $this->CCT_Produtivo = $CCT_Produtivo;
    }

    function setPEO_CentroCustoORC($PEO_CentroCustoORC) {
        $this->PEO_CentroCustoORC = $PEO_CentroCustoORC;
    }

    function setPEO_CentroCustoDRT($PEO_CentroCustoDRT) {
        $this->PEO_CentroCustoDRT = $PEO_CentroCustoDRT;
    }

    function setPEO_CentroCustoPEO($PEO_CentroCustoPEO) {
        $this->PEO_CentroCustoPEO = $PEO_CentroCustoPEO;
    }

    function setPEO_CentroCustoBLV($PEO_CentroCustoBLV) {
        $this->PEO_CentroCustoBLV = $PEO_CentroCustoBLV;
    }

    function setMNT_CentroCustoAbreOS($MNT_CentroCustoAbreOS) {
        $this->MNT_CentroCustoAbreOS = $MNT_CentroCustoAbreOS;
    }

    function setMNT_CentroCustoApontaOS($MNT_CentroCustoApontaOS) {
        $this->MNT_CentroCustoApontaOS = $MNT_CentroCustoApontaOS;
    }

    function setPEO_CentroCustoOCE($PEO_CentroCustoOCE) {
        $this->PEO_CentroCustoOCE = $PEO_CentroCustoOCE;
    }

    function setMNT_CentroCustoCriticidade($MNT_CentroCustoCriticidade) {
        $this->MNT_CentroCustoCriticidade = $MNT_CentroCustoCriticidade;
    }

    function setMNT_CentroCustoArea($MNT_CentroCustoArea) {
        $this->MNT_CentroCustoArea = $MNT_CentroCustoArea;
    }

    function setMNT_CentroCustoTipoAprovacao($MNT_CentroCustoTipoAprovacao) {
        $this->MNT_CentroCustoTipoAprovacao = $MNT_CentroCustoTipoAprovacao;
    }

    function setMNT_CentroCustoAprovAutomatica($MNT_CentroCustoAprovAutomatica) {
        $this->MNT_CentroCustoAprovAutomatica = $MNT_CentroCustoAprovAutomatica;
    }

    function setESP_HolambraCCTFilialDestino($ESP_HolambraCCTFilialDestino) {
        $this->ESP_HolambraCCTFilialDestino = $ESP_HolambraCCTFilialDestino;
    }

    function setESP_HolambraCCTPlanoDestino($ESP_HolambraCCTPlanoDestino) {
        $this->ESP_HolambraCCTPlanoDestino = $ESP_HolambraCCTPlanoDestino;
    }

    function setESP_HolambraCCTContaDestino($ESP_HolambraCCTContaDestino) {
        $this->ESP_HolambraCCTContaDestino = $ESP_HolambraCCTContaDestino;
    }

    function getCct_codigo() {
        return $this->cct_codigo;
    }

    function getCct_descricao() {
        return $this->cct_descricao;
    }

    function setCct_codigo($cct_codigo) {
        $this->cct_codigo = $cct_codigo;
    }

    function setCct_descricao($cct_descricao) {
        $this->cct_descricao = $cct_descricao;
    }

}
