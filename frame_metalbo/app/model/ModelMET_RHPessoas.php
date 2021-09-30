<?php

/*
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 16/03/2020
 */

class ModelMET_RHPessoas {
    
    private $seq;
    private $numcad;
    private $datadm;
    private $nome;
    private $sit;
    private $funcao;
    private $escala;
    private $setor;
    private $contexp;
    private $salini;
    private $cursos;
    private $banco;
    private $agb;
    private $contac;
    private $anexo;
        
    function getSeq() {
        return $this->seq;
    }

    function getNumcad() {
        return $this->numcad;
    }

    function getDatadm() {
        return $this->datadm;
    }

    function getNome() {
        return $this->nome;
    }

    function getSit() {
        return $this->sit;
    }

    function getFuncao() {
        return $this->funcao;
    }

    function getEscala() {
        return $this->escala;
    }

    function getSetor() {
        return $this->setor;
    }

    function getContexp() {
        return $this->contexp;
    }

    function getSalini() {
        return $this->salini;
    }

    function getCursos() {
        return $this->cursos;
    }

    function getBanco() {
        return $this->banco;
    }

    function getAgb() {
        return $this->agb;
    }

    function getContac() {
        return $this->contac;
    }

    function getAnexo() {
        return $this->anexo;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setNumcad($numcad) {
        $this->numcad = $numcad;
    }

    function setDatadm($datadm) {
        $this->datadm = $datadm;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setEscala($escala) {
        $this->escala = $escala;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }

    function setContexp($contexp) {
        $this->contexp = $contexp;
    }

    function setSalini($salini) {
        $this->salini = $salini;
    }

    function setCursos($cursos) {
        $this->cursos = $cursos;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setAgb($agb) {
        $this->agb = $agb;
    }

    function setContac($contac) {
        $this->contac = $contac;
    }

    function setAnexo($anexo) {
        $this->anexo = $anexo;
    }
    
}
