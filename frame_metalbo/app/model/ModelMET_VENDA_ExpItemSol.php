<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_VENDA_ExpItemSol {

    private $nr;
    private $seq;
    private $codigo;
    private $descricao;
    private $quant;
    private $vlrunit;
    private $desconto;
    private $vlrtot;
    private $data;
    private $hora;
    private $desctrat;
    private $descextra1;
    private $descextra2;
    private $prcbruto;
    private $obsprod;
    private $odprod;
    private $seqod;
    private $qtcaixa;
    private $diver;
    private $qtsug;
    private $pdfdisp;

    function getPdfdisp() {
        return $this->pdfdisp;
    }

    function setPdfdisp($pdfdisp) {
        $this->pdfdisp = $pdfdisp;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getQuant() {
        return $this->quant;
    }

    function getVlrunit() {
        return $this->vlrunit;
    }

    function getDesconto() {
        return $this->desconto;
    }

    function getVlrtot() {
        return $this->vlrtot;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getDesctrat() {
        return $this->desctrat;
    }

    function getDescextra1() {
        return $this->descextra1;
    }

    function getDescextra2() {
        return $this->descextra2;
    }

    function getPrcbruto() {
        return $this->prcbruto;
    }

    function getObsprod() {
        return $this->obsprod;
    }

    function getOdprod() {
        return $this->odprod;
    }

    function getSeqod() {
        return $this->seqod;
    }

    function getQtcaixa() {
        return $this->qtcaixa;
    }

    function getDiver() {
        return $this->diver;
    }

    function getQtsug() {
        return $this->qtsug;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setQuant($quant) {
        $this->quant = $quant;
    }

    function setVlrunit($vlrunit) {
        $this->vlrunit = $vlrunit;
    }

    function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    function setVlrtot($vlrtot) {
        $this->vlrtot = $vlrtot;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setDesctrat($desctrat) {
        $this->desctrat = $desctrat;
    }

    function setDescextra1($descextra1) {
        $this->descextra1 = $descextra1;
    }

    function setDescextra2($descextra2) {
        $this->descextra2 = $descextra2;
    }

    function setPrcbruto($prcbruto) {
        $this->prcbruto = $prcbruto;
    }

    function setObsprod($obsprod) {
        $this->obsprod = $obsprod;
    }

    function setOdprod($odprod) {
        $this->odprod = $odprod;
    }

    function setSeqod($seqod) {
        $this->seqod = $seqod;
    }

    function setQtcaixa($qtcaixa) {
        $this->qtcaixa = $qtcaixa;
    }

    function setDiver($diver) {
        $this->diver = $diver;
    }

    function setQtsug($qtsug) {
        $this->qtsug = $qtsug;
    }

}
