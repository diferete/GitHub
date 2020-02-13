<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_QUAL_Ata {
    private $filcgc;
    private $nr;
    private $seq;
    private $titulo;
    private $data;
    private $hora;
    private $anexo;
    private $obs;
    
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

        
    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

        
    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }


    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getAnexo() {
        return $this->anexo;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setAnexo($anexo) {
        $this->anexo = $anexo;
    }

    







    /* $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('seq','seq',true,true,true);
        $this->adicionaRelacionamento('documento','documento');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('anexo','anexo');*/
}