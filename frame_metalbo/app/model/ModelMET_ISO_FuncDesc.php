<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_ISO_FuncDesc {

    private $filcgc;
    private $nr;
    private $seq;
    private $usuario;
    private $descricao;
    private $data_revisao;
    private $revisao;
    private $observacao;
    private $esc_exigida;
    private $esc_recomendada;
    private $arquivo;

    function getEsc_exigida() {
        return $this->esc_exigida;
    }

    function getEsc_recomendada() {
        return $this->esc_recomendada;
    }

    function setEsc_exigida($esc_exigida) {
        $this->esc_exigida = $esc_exigida;
    }

    function setEsc_recomendada($esc_recomendada) {
        $this->esc_recomendada = $esc_recomendada;
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

    function getUsuario() {
        return $this->usuario;
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

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
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

}
