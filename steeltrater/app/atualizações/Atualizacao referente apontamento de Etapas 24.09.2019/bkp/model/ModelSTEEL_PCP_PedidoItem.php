<?php

/*
 * Classe que implementa os models da STEEL_PCP_PedidoItem
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class ModelSTEEL_PCP_PedidoItem {
    
    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $pdv_pedidoitemseq;
    private $pdv_pedidoitemiimposto;
    private $PDV_PedidoItemIRegra;
    private $PDV_PedidoItemIFormula;
    private $PDV_PedidoItemICFOP;
    private $PDV_PedidoItemICST;
    private $PDV_PedidoItemIBCalculo;
    private $PDV_PedidoItemIAliquota;
    private $PDV_PedidoItemIValor;
    private $PDV_PedidoItemIIsentas;
    private $PDV_PedidoItemIOutras;
    private $PDV_PedidoItemIRegraBase;
    private $PDV_PedidoItemIImpostoFiscal;
    private $PDV_PedidoItemIRegraReducao;
    private $PDV_PedidoItemIClasseNF;
    private $PDV_PedidoItemIClasseFN;
    private $PDV_PedidoItemIFatura;
    private $PDV_PedidoItemIParcela;
    private $PDV_PedidoItemIMVA;
    private $PDV_PedidoItemIValorUnidade;
    private $PDV_PedidoItemIRegraRedAliq;

    function getPdv_pedidofilial() {
        return $this->pdv_pedidofilial;
    }

    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function getPdv_pedidoitemseq() {
        return $this->pdv_pedidoitemseq;
    }

    function getPdv_pedidoitemiimposto() {
        return $this->pdv_pedidoitemiimposto;
    }

    function getPDV_PedidoItemIRegra() {
        return $this->PDV_PedidoItemIRegra;
    }

    function getPDV_PedidoItemIFormula() {
        return $this->PDV_PedidoItemIFormula;
    }

    function getPDV_PedidoItemICFOP() {
        return $this->PDV_PedidoItemICFOP;
    }

    function getPDV_PedidoItemICST() {
        return $this->PDV_PedidoItemICST;
    }

    function getPDV_PedidoItemIBCalculo() {
        return $this->PDV_PedidoItemIBCalculo;
    }

    function getPDV_PedidoItemIAliquota() {
        return $this->PDV_PedidoItemIAliquota;
    }

    function getPDV_PedidoItemIValor() {
        return $this->PDV_PedidoItemIValor;
    }

    function getPDV_PedidoItemIIsentas() {
        return $this->PDV_PedidoItemIIsentas;
    }

    function getPDV_PedidoItemIOutras() {
        return $this->PDV_PedidoItemIOutras;
    }

    function getPDV_PedidoItemIRegraBase() {
        return $this->PDV_PedidoItemIRegraBase;
    }

    function getPDV_PedidoItemIImpostoFiscal() {
        return $this->PDV_PedidoItemIImpostoFiscal;
    }

    function getPDV_PedidoItemIRegraReducao() {
        return $this->PDV_PedidoItemIRegraReducao;
    }

    function getPDV_PedidoItemIClasseNF() {
        return $this->PDV_PedidoItemIClasseNF;
    }

    function getPDV_PedidoItemIClasseFN() {
        return $this->PDV_PedidoItemIClasseFN;
    }

    function getPDV_PedidoItemIFatura() {
        return $this->PDV_PedidoItemIFatura;
    }

    function getPDV_PedidoItemIParcela() {
        return $this->PDV_PedidoItemIParcela;
    }

    function getPDV_PedidoItemIMVA() {
        return $this->PDV_PedidoItemIMVA;
    }

    function getPDV_PedidoItemIValorUnidade() {
        return $this->PDV_PedidoItemIValorUnidade;
    }

    function getPDV_PedidoItemIRegraRedAliq() {
        return $this->PDV_PedidoItemIRegraRedAliq;
    }

    function setPdv_pedidofilial($pdv_pedidofilial) {
        $this->pdv_pedidofilial = $pdv_pedidofilial;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

    function setPdv_pedidoitemseq($pdv_pedidoitemseq) {
        $this->pdv_pedidoitemseq = $pdv_pedidoitemseq;
    }

    function setPdv_pedidoitemiimposto($pdv_pedidoitemiimposto) {
        $this->pdv_pedidoitemiimposto = $pdv_pedidoitemiimposto;
    }

    function setPDV_PedidoItemIRegra($PDV_PedidoItemIRegra) {
        $this->PDV_PedidoItemIRegra = $PDV_PedidoItemIRegra;
    }

    function setPDV_PedidoItemIFormula($PDV_PedidoItemIFormula) {
        $this->PDV_PedidoItemIFormula = $PDV_PedidoItemIFormula;
    }

    function setPDV_PedidoItemICFOP($PDV_PedidoItemICFOP) {
        $this->PDV_PedidoItemICFOP = $PDV_PedidoItemICFOP;
    }

    function setPDV_PedidoItemICST($PDV_PedidoItemICST) {
        $this->PDV_PedidoItemICST = $PDV_PedidoItemICST;
    }

    function setPDV_PedidoItemIBCalculo($PDV_PedidoItemIBCalculo) {
        $this->PDV_PedidoItemIBCalculo = $PDV_PedidoItemIBCalculo;
    }

    function setPDV_PedidoItemIAliquota($PDV_PedidoItemIAliquota) {
        $this->PDV_PedidoItemIAliquota = $PDV_PedidoItemIAliquota;
    }

    function setPDV_PedidoItemIValor($PDV_PedidoItemIValor) {
        $this->PDV_PedidoItemIValor = $PDV_PedidoItemIValor;
    }

    function setPDV_PedidoItemIIsentas($PDV_PedidoItemIIsentas) {
        $this->PDV_PedidoItemIIsentas = $PDV_PedidoItemIIsentas;
    }

    function setPDV_PedidoItemIOutras($PDV_PedidoItemIOutras) {
        $this->PDV_PedidoItemIOutras = $PDV_PedidoItemIOutras;
    }

    function setPDV_PedidoItemIRegraBase($PDV_PedidoItemIRegraBase) {
        $this->PDV_PedidoItemIRegraBase = $PDV_PedidoItemIRegraBase;
    }

    function setPDV_PedidoItemIImpostoFiscal($PDV_PedidoItemIImpostoFiscal) {
        $this->PDV_PedidoItemIImpostoFiscal = $PDV_PedidoItemIImpostoFiscal;
    }

    function setPDV_PedidoItemIRegraReducao($PDV_PedidoItemIRegraReducao) {
        $this->PDV_PedidoItemIRegraReducao = $PDV_PedidoItemIRegraReducao;
    }

    function setPDV_PedidoItemIClasseNF($PDV_PedidoItemIClasseNF) {
        $this->PDV_PedidoItemIClasseNF = $PDV_PedidoItemIClasseNF;
    }

    function setPDV_PedidoItemIClasseFN($PDV_PedidoItemIClasseFN) {
        $this->PDV_PedidoItemIClasseFN = $PDV_PedidoItemIClasseFN;
    }

    function setPDV_PedidoItemIFatura($PDV_PedidoItemIFatura) {
        $this->PDV_PedidoItemIFatura = $PDV_PedidoItemIFatura;
    }

    function setPDV_PedidoItemIParcela($PDV_PedidoItemIParcela) {
        $this->PDV_PedidoItemIParcela = $PDV_PedidoItemIParcela;
    }

    function setPDV_PedidoItemIMVA($PDV_PedidoItemIMVA) {
        $this->PDV_PedidoItemIMVA = $PDV_PedidoItemIMVA;
    }

    function setPDV_PedidoItemIValorUnidade($PDV_PedidoItemIValorUnidade) {
        $this->PDV_PedidoItemIValorUnidade = $PDV_PedidoItemIValorUnidade;
    }

    function setPDV_PedidoItemIRegraRedAliq($PDV_PedidoItemIRegraRedAliq) {
        $this->PDV_PedidoItemIRegraRedAliq = $PDV_PedidoItemIRegraRedAliq;
    }
    
}