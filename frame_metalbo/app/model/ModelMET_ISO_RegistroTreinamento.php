<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_ISO_RegistroTreinamento {

    private $nr;
    private $filcgc;
    private $seq;
    private $usuario;
    private $data_treinamento;
    private $cod_treinamento;
    private $titulo_treinamento;
    private $revisao;
    private $anexo_treinamento;
    private $observacao;

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getSeq() {
        return $this->seq;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getData_treinamento() {
        return $this->data_treinamento;
    }

    function getCod_treinamento() {
        return $this->cod_treinamento;
    }

    function getTitulo_treinamento() {
        return $this->titulo_treinamento;
    }

    function getRevisao() {
        return $this->revisao;
    }

    function getAnexo_treinamento() {
        return $this->anexo_treinamento;
    }

    function getObservacao() {
        return $this->observacao;
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

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setData_treinamento($data_treinamento) {
        $this->data_treinamento = $data_treinamento;
    }

    function setCod_treinamento($cod_treinamento) {
        $this->cod_treinamento = $cod_treinamento;
    }

    function setTitulo_treinamento($titulo_treinamento) {
        $this->titulo_treinamento = $titulo_treinamento;
    }

    function setRevisao($revisao) {
        $this->revisao = $revisao;
    }

    function setAnexo_treinamento($anexo_treinamento) {
        $this->anexo_treinamento = $anexo_treinamento;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

}
