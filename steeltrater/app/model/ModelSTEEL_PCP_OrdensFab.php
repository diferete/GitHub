<?php

/* 
 * Classe que implementa as ordens de fab steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ModelSTEEL_PCP_OrdensFab {
    
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
    
    /*$this->adicionaRelacionamento('matcod','matcod');
        $this->adicionaRelacionamento('matdes','matdes');*/
    
     function getMatcod() {
         return $this->matcod;
     }

     function getMatdes() {
         return $this->matdes;
     }

     function setMatcod($matcod) {
         $this->matcod = $matcod;
     }

     function setMatdes($matdes) {
         $this->matdes = $matdes;
     }

         
    function getSeqmat() {
        return $this->seqmat;
    }

    function setSeqmat($seqmat) {
        $this->seqmat = $seqmat;
    }

        
    function getTemprev() {
        return $this->temprev;
    }

    function setTemprev($temprev) {
        $this->temprev = $temprev;
    }

       
    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

        
    function getDataprev() {
        return $this->dataprev;
    }

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }

        
    function getSeqprodnf() {
        return $this->seqprodnf;
    }

    function setSeqprodnf($seqprodnf) {
        $this->seqprodnf = $seqprodnf;
    }

        
        
    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getEmp_razaosocial() {
        return $this->emp_razaosocial;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setEmp_razaosocial($emp_razaosocial) {
        $this->emp_razaosocial = $emp_razaosocial;
    }

        
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

                
    function getOp() {
        return $this->op;
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
        
        $this->prodes = str_replace("\n", " ",$this->prodes);                  
        $this->prodes = str_replace("'","\'",$this->prodes);                     
        $this->prodes = str_replace("\r", "",$this->prodes);
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

    function setOp($op) {
        $this->op = $op;
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

    

    /*op integer,
  origem varchar(50),
  documento varchar(50),
  prod varchar(30),
  prodes varchar(100),
  receita integer,
  receita_des varchar(100),
  quant money,
  peso money,
  opcliente varchar(50),
  data date,
  hora time,*/
}

