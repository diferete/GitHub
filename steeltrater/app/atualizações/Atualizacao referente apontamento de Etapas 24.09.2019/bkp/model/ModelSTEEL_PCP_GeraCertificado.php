<?php

/* 
 * Classe que implementa a model para geração de certificado de uma ordem de produção
 * 
 * @author Cleverton Hoffmann
 * @since 08/10/2018
 */

class ModelSTEEL_PCP_GeraCertificado {
    
    private $op;
    private $emp_codigo;
    private $emp_razaosocial;
    
    private $origem;
    private $documento; 
    private $prod;
    private $prodes; 
    private $receita; 
    private $receita_des; 
    private $quant;
    private $peso; 
    private $opcliente; 
    private $data;
    private $hora; 
    private $usuario;
    private $obs;
    private $seqprodnf;
    private $dataprev;
    private $situacao;
    private $temprev;
    
    private $seqmat;
    
    private $matcod;
    private $matdes;
    private $retrabalho;
    private $op_retrabalho;
    
    private $nrcert;
    
    function getNrcert() {
        return $this->nrcert;
    }

    function setNrcert($nrcert) {
        $this->nrcert = $nrcert;
    }

        
    function getOp() {
        return $this->op;
    }

    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getEmp_razaosocial() {
        return $this->emp_razaosocial;
    }

    function getOrigem() {
        return $this->origem;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getProd() {
        return $this->prod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getReceita() {
        return $this->receita;
    }

    function getReceita_des() {
        return $this->receita_des;
    }

    function getQuant() {
        return $this->quant;
    }

    function getPeso() {
        return $this->peso;
    }

    function getOpcliente() {
        return $this->opcliente;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getObs() {
        return $this->obs;
    }

    function getSeqprodnf() {
        return $this->seqprodnf;
    }

    function getDataprev() {
        return $this->dataprev;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getTemprev() {
        return $this->temprev;
    }

    function getSeqmat() {
        return $this->seqmat;
    }

    function getMatcod() {
        return $this->matcod;
    }

    function getMatdes() {
        return $this->matdes;
    }

    function getRetrabalho() {
        return $this->retrabalho;
    }

    function getOp_retrabalho() {
        return $this->op_retrabalho;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setEmp_razaosocial($emp_razaosocial) {
        $this->emp_razaosocial = $emp_razaosocial;
    }

    function setOrigem($origem) {
        $this->origem = $origem;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setProd($prod) {
        $this->prod = $prod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setReceita($receita) {
        $this->receita = $receita;
    }

    function setReceita_des($receita_des) {
        $this->receita_des = $receita_des;
    }

    function setQuant($quant) {
        $this->quant = $quant;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setOpcliente($opcliente) {
        $this->opcliente = $opcliente;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setSeqprodnf($seqprodnf) {
        $this->seqprodnf = $seqprodnf;
    }

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setTemprev($temprev) {
        $this->temprev = $temprev;
    }

    function setSeqmat($seqmat) {
        $this->seqmat = $seqmat;
    }

    function setMatcod($matcod) {
        $this->matcod = $matcod;
    }

    function setMatdes($matdes) {
        $this->matdes = $matdes;
    }

    function setRetrabalho($retrabalho) {
        $this->retrabalho = $retrabalho;
    }

    function setOp_retrabalho($op_retrabalho) {
        $this->op_retrabalho = $op_retrabalho;
    }    
}