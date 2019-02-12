<?php

/*
 * Classe que implementa os models 
 * 
 * @author Cleverton Hoffmann
 * @since 30/01/2019
 */

class ModelSTEEL_PCP_PedidoParcela {

    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $pdv_pedidoparcelaseq;
    private $PDV_PedidoParcelaVencimento;
    private $PDV_PedidoParcelaValor;
    private $PDV_PedidoParcelaPercentual;
    private $PDV_PedidoParcelaAntecipada;
    private $PDV_PedidoParcelaDias;
    private $PDV_PedidoParcelaObs;
    private $PDV_PedidoParcelaAdiantamento;
    private $PDV_PedidoParcelaAlteradaManua;
    private $PDV_PedidoParcelaMoedaPadrao;
    private $PDV_PedidoParcelaMoedaCodigo;
    private $PDV_PedidoParcelaMoedaData;
    private $PDV_PedidoParcelaMoedaValorCot;
    private $PDV_PedidoParcelaMoedaVlrCotNe;
    private $PDV_PedidoParcelaMoedaValor;
    private $PDV_PedidoParcelaValorImposto;
    private $PDV_PedidoParcelaValorFrete;
    
    function getPdv_pedidofilial() {
        return $this->pdv_pedidofilial;
    }

    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function getPdv_pedidoparcelaseq() {
        return $this->pdv_pedidoparcelaseq;
    }

    function getPDV_PedidoParcelaVencimento() {
        return $this->PDV_PedidoParcelaVencimento;
    }

    function getPDV_PedidoParcelaValor() {
        return $this->PDV_PedidoParcelaValor;
    }

    function getPDV_PedidoParcelaPercentual() {
        return $this->PDV_PedidoParcelaPercentual;
    }

    function getPDV_PedidoParcelaAntecipada() {
        return $this->PDV_PedidoParcelaAntecipada;
    }

    function getPDV_PedidoParcelaDias() {
        return $this->PDV_PedidoParcelaDias;
    }

    function getPDV_PedidoParcelaObs() {
        return $this->PDV_PedidoParcelaObs;
    }

    function getPDV_PedidoParcelaAdiantamento() {
        return $this->PDV_PedidoParcelaAdiantamento;
    }

    function getPDV_PedidoParcelaAlteradaManua() {
        return $this->PDV_PedidoParcelaAlteradaManua;
    }

    function getPDV_PedidoParcelaMoedaPadrao() {
        return $this->PDV_PedidoParcelaMoedaPadrao;
    }

    function getPDV_PedidoParcelaMoedaCodigo() {
        return $this->PDV_PedidoParcelaMoedaCodigo;
    }

    function getPDV_PedidoParcelaMoedaData() {
        return $this->PDV_PedidoParcelaMoedaData;
    }

    function getPDV_PedidoParcelaMoedaValorCot() {
        return $this->PDV_PedidoParcelaMoedaValorCot;
    }

    function getPDV_PedidoParcelaMoedaVlrCotNe() {
        return $this->PDV_PedidoParcelaMoedaVlrCotNe;
    }

    function getPDV_PedidoParcelaMoedaValor() {
        return $this->PDV_PedidoParcelaMoedaValor;
    }

    function getPDV_PedidoParcelaValorImposto() {
        return $this->PDV_PedidoParcelaValorImposto;
    }

    function getPDV_PedidoParcelaValorFrete() {
        return $this->PDV_PedidoParcelaValorFrete;
    }

    function setPdv_pedidofilial($pdv_pedidofilial) {
        $this->pdv_pedidofilial = $pdv_pedidofilial;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

    function setPdv_pedidoparcelaseq($pdv_pedidoparcelaseq) {
        $this->pdv_pedidoparcelaseq = $pdv_pedidoparcelaseq;
    }

    function setPDV_PedidoParcelaVencimento($PDV_PedidoParcelaVencimento) {
        $this->PDV_PedidoParcelaVencimento = $PDV_PedidoParcelaVencimento;
    }

    function setPDV_PedidoParcelaValor($PDV_PedidoParcelaValor) {
        $this->PDV_PedidoParcelaValor = $PDV_PedidoParcelaValor;
    }

    function setPDV_PedidoParcelaPercentual($PDV_PedidoParcelaPercentual) {
        $this->PDV_PedidoParcelaPercentual = $PDV_PedidoParcelaPercentual;
    }

    function setPDV_PedidoParcelaAntecipada($PDV_PedidoParcelaAntecipada) {
        $this->PDV_PedidoParcelaAntecipada = $PDV_PedidoParcelaAntecipada;
    }

    function setPDV_PedidoParcelaDias($PDV_PedidoParcelaDias) {
        $this->PDV_PedidoParcelaDias = $PDV_PedidoParcelaDias;
    }

    function setPDV_PedidoParcelaObs($PDV_PedidoParcelaObs) {
        $this->PDV_PedidoParcelaObs = $PDV_PedidoParcelaObs;
    }

    function setPDV_PedidoParcelaAdiantamento($PDV_PedidoParcelaAdiantamento) {
        $this->PDV_PedidoParcelaAdiantamento = $PDV_PedidoParcelaAdiantamento;
    }

    function setPDV_PedidoParcelaAlteradaManua($PDV_PedidoParcelaAlteradaManua) {
        $this->PDV_PedidoParcelaAlteradaManua = $PDV_PedidoParcelaAlteradaManua;
    }

    function setPDV_PedidoParcelaMoedaPadrao($PDV_PedidoParcelaMoedaPadrao) {
        $this->PDV_PedidoParcelaMoedaPadrao = $PDV_PedidoParcelaMoedaPadrao;
    }

    function setPDV_PedidoParcelaMoedaCodigo($PDV_PedidoParcelaMoedaCodigo) {
        $this->PDV_PedidoParcelaMoedaCodigo = $PDV_PedidoParcelaMoedaCodigo;
    }

    function setPDV_PedidoParcelaMoedaData($PDV_PedidoParcelaMoedaData) {
        $this->PDV_PedidoParcelaMoedaData = $PDV_PedidoParcelaMoedaData;
    }

    function setPDV_PedidoParcelaMoedaValorCot($PDV_PedidoParcelaMoedaValorCot) {
        $this->PDV_PedidoParcelaMoedaValorCot = $PDV_PedidoParcelaMoedaValorCot;
    }

    function setPDV_PedidoParcelaMoedaVlrCotNe($PDV_PedidoParcelaMoedaVlrCotNe) {
        $this->PDV_PedidoParcelaMoedaVlrCotNe = $PDV_PedidoParcelaMoedaVlrCotNe;
    }

    function setPDV_PedidoParcelaMoedaValor($PDV_PedidoParcelaMoedaValor) {
        $this->PDV_PedidoParcelaMoedaValor = $PDV_PedidoParcelaMoedaValor;
    }

    function setPDV_PedidoParcelaValorImposto($PDV_PedidoParcelaValorImposto) {
        $this->PDV_PedidoParcelaValorImposto = $PDV_PedidoParcelaValorImposto;
    }

    function setPDV_PedidoParcelaValorFrete($PDV_PedidoParcelaValorFrete) {
        $this->PDV_PedidoParcelaValorFrete = $PDV_PedidoParcelaValorFrete;
    }
    
}