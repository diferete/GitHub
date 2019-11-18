<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_ISO_DocRevisao {

    private $nr;
    private $filcgc;
    private $seq;
    private $descricao;
    private $data_revisao;
    private $revisao;
    private $observacao;
    private $arquivo;
    private $usuario;

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getSeq() {
        return $this->seq;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getData_revisao() {
        return $this->data_revisao;
    }

    function getRevisao() {
        return $this->revisao;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setData_revisao($data_revisao) {
        $this->data_revisao = $data_revisao;
    }

    function setRevisao($revisao) {
        $this->revisao = $revisao;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

}
