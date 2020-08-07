<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelAdm{
    private $data;
    private $vlrliquido;
    private $vlripi;
    private $exportacao;
    private $sucata;
    private $devolucao;
    private $pesodev;
    private $pesoliquido;
    private $mediaSipi;
    private $mediaCipi;
    
    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

        
    
    function getVlrliquido() {
        return $this->vlrliquido;
    }

    function getVlripi() {
        return $this->vlripi;
    }

    function getExportacao() {
        return $this->exportacao;
    }

    function getSucata() {
        return $this->sucata;
    }

    function getDevolucao() {
        return $this->devolucao;
    }

    function getPesodev() {
        return $this->pesodev;
    }

    function getPesoliquido() {
        return $this->pesoliquido;
    }

    function getMediaSipi() {
        return $this->mediaSipi;
    }

    function getMediaCipi() {
        return $this->mediaCipi;
    }

    function setVlrliquido($vlrliquido) {
        $this->vlrliquido = $vlrliquido;
    }

    function setVlripi($vlripi) {
        $this->vlripi = $vlripi;
    }

    function setExportacao($exportacao) {
        $this->exportacao = $exportacao;
    }

    function setSucata($sucata) {
        $this->sucata = $sucata;
    }

    function setDevolucao($devolucao) {
        $this->devolucao = $devolucao;
    }

    function setPesodev($pesodev) {
        $this->pesodev = $pesodev;
    }

    function setPesoliquido($pesoliquido) {
        $this->pesoliquido = $pesoliquido;
    }

    function setMediaSipi($mediaSipi) {
        $this->mediaSipi = $mediaSipi;
    }

    function setMediaCipi($mediaCipi) {
        $this->mediaCipi = $mediaCipi;
    }


    
}