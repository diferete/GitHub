<?php

/*
 * Classe que implementa a aponta lista
 * 
 * @author Cleverton Hoffmann
 * @since 31/07/2018
 */

class ModelSTEEL_PCP_OrdensFabApontLista {

    private $STEEL_PCP_ordensFabLista;
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
    private $referencia;
    private $tratrevencomp;
    
    function getTratrevencomp() {
        return $this->tratrevencomp;
    }

    function setTratrevencomp($tratrevencomp) {
        $this->tratrevencomp = $tratrevencomp;
    }

        
    function getReferencia() {
        return $this->referencia;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

        
    function getOp() {
        return $this->op;
    }

    function setOp($op) {
        $this->op = $op;
    }

        
    function getSTEEL_PCP_ordensFabLista() {
        if(!isset($this->STEEL_PCP_ordensFabLista)){
            $this->STEEL_PCP_ordensFabLista = Fabrica::FabricarModel('STEEL_PCP_ordensFabLista');
        }
        return $this->STEEL_PCP_ordensFabLista;
    }

    function setSTEEL_PCP_ordensFabLista($STEEL_PCP_ordensFabLista) {
        $this->STEEL_PCP_ordensFabLista = $STEEL_PCP_ordensFabLista;
    }

    function getTemprev() {
        return $this->temprev;
    }

    function setTemprev($temprev) {
        $this->temprev = $temprev;
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

}
