<?php

/*
 * Classe que implementa os models da DELX_NFS_NotaFiscalItem
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class ModelDELX_NFS_NotaFiscalItem {

    private $nfs_notafiscalfilial;
    private $nfs_notafiscalseq;
    private $nfs_notafiscalitemseq;
    private $nfs_notafiscalitemproduto;
    private $nfs_notafiscalitemprodutonomem;
    private $nfs_notafiscalitemprodutounman;
    private $nfs_notafiscalitemquantidade;
    private $nfs_notafiscalitemvalorunitari;
    private $nfs_notafiscalitemvalortotal;
    private $nfs_notafiscalitempesoliquido;
    private $nfs_notafiscalitempesobruto;

    function getNfs_notafiscalfilial() {
        return $this->nfs_notafiscalfilial;
    }

    function getNfs_notafiscalseq() {
        return $this->nfs_notafiscalseq;
    }

    function getNfs_notafiscalitemseq() {
        return $this->nfs_notafiscalitemseq;
    }

    function getNfs_notafiscalitemproduto() {
        return $this->nfs_notafiscalitemproduto;
    }

    function getNfs_notafiscalitemprodutonomem() {
        return $this->nfs_notafiscalitemprodutonomem;
    }

    function getNfs_notafiscalitemprodutounman() {
        return $this->nfs_notafiscalitemprodutounman;
    }

    function getNfs_notafiscalitemquantidade() {
        return $this->nfs_notafiscalitemquantidade;
    }

    function getNfs_notafiscalitemvalorunitari() {
        return $this->nfs_notafiscalitemvalorunitari;
    }

    function getNfs_notafiscalitemvalortotal() {
        return $this->nfs_notafiscalitemvalortotal;
    }

    function getNfs_notafiscalitempesoliquido() {
        return $this->nfs_notafiscalitempesoliquido;
    }

    function getNfs_notafiscalitempesobruto() {
        return $this->nfs_notafiscalitempesobruto;
    }

    function setNfs_notafiscalfilial($nfs_notafiscalfilial) {
        $this->nfs_notafiscalfilial = $nfs_notafiscalfilial;
    }

    function setNfs_notafiscalseq($nfs_notafiscalseq) {
        $this->nfs_notafiscalseq = $nfs_notafiscalseq;
    }

    function setNfs_notafiscalitemseq($nfs_notafiscalitemseq) {
        $this->nfs_notafiscalitemseq = $nfs_notafiscalitemseq;
    }

    function setNfs_notafiscalitemproduto($nfs_notafiscalitemproduto) {
        $this->nfs_notafiscalitemproduto = $nfs_notafiscalitemproduto;
    }

    function setNfs_notafiscalitemprodutonomem($nfs_notafiscalitemprodutonomem) {
        $this->nfs_notafiscalitemprodutonomem = $nfs_notafiscalitemprodutonomem;
    }

    function setNfs_notafiscalitemprodutounman($nfs_notafiscalitemprodutounman) {
        $this->nfs_notafiscalitemprodutounman = $nfs_notafiscalitemprodutounman;
    }

    function setNfs_notafiscalitemquantidade($nfs_notafiscalitemquantidade) {
        $this->nfs_notafiscalitemquantidade = $nfs_notafiscalitemquantidade;
    }

    function setNfs_notafiscalitemvalorunitari($nfs_notafiscalitemvalorunitari) {
        $this->nfs_notafiscalitemvalorunitari = $nfs_notafiscalitemvalorunitari;
    }

    function setNfs_notafiscalitemvalortotal($nfs_notafiscalitemvalortotal) {
        $this->nfs_notafiscalitemvalortotal = $nfs_notafiscalitemvalortotal;
    }

    function setNfs_notafiscalitempesoliquido($nfs_notafiscalitempesoliquido) {
        $this->nfs_notafiscalitempesoliquido = $nfs_notafiscalitempesoliquido;
    }

    function setNfs_notafiscalitempesobruto($nfs_notafiscalitempesobruto) {
        $this->nfs_notafiscalitempesobruto = $nfs_notafiscalitempesobruto;
    }

}
