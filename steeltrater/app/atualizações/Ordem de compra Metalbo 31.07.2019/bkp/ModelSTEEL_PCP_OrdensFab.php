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
    private $retrabalho;
    private $op_retrabalho;
    
    private $durezaNucMin;
    private $durezaNucMax;
    private $NucEscala;
    private $durezaSuperfMin;
    private $durezaSuperfMax;
    private $superEscala;
    private $expCamadaMin;
    private $expCamadaMax;
    private $tratrevencomp;
    
    private $tipoOrdem;
    
    private $fioDurezaSol;
    private $fioEsferio;
    private $fioDescarbonetaTotal;
    private $fioDescarbonetaParcial;
    private $DiamFinalMin;
    private $DiamFinalMax;
    
    private $prodFinal;
    private $prodesFinal;
    
    private $vlrNfEnt;
    
    private $vlrNfEntUnit;
    
    private $nrCarga;
    
    private $referencia;
    
    private $xPed;
    
    private $nItemPed;
    
    private $nrcert;
    private $pendencias;
    private $pendenciasobs;
    
    private $rnc;
    
    private $opantes;
    
    
    function getOpantes() {
        return $this->opantes;
    }

    function setOpantes($opantes) {
        $this->opantes = $opantes;
    }

                    
    function getRnc() {
        return $this->rnc;
    }

    function setRnc($rnc) {
        $this->rnc = $rnc;
    }

        
    function getPendencias() {
        return $this->pendencias;
    }

    function getPendenciasobs() {
        return $this->pendenciasobs;
    }

    function setPendencias($pendencias) {
        $this->pendencias = $pendencias;
    }

    function setPendenciasobs($pendenciasobs) {
        $this->pendenciasobs = $pendenciasobs;
    }

        
    function getNrcert() {
        return $this->nrcert;
    }

    function setNrcert($nrcert) {
        $this->nrcert = $nrcert;
    }

        
    function getNItemPed() {
        return $this->nItemPed;
    }

    function setNItemPed($nItemPed) {
        $this->nItemPed = $nItemPed;
    }

        
    function getXPed() {
        return $this->xPed;
    }

    function setXPed($xPed) {
        $this->xPed = $xPed;
    }

        
    function getReferencia() {
        return $this->referencia;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

        
    function getNrCarga() {
        return $this->nrCarga;
    }

    function setNrCarga($nrCarga) {
        $this->nrCarga = $nrCarga;
    }

        
    function getVlrNfEntUnit() {
        return $this->vlrNfEntUnit;
    }

    function setVlrNfEntUnit($vlrNfEntUnit) {
        $this->vlrNfEntUnit = $vlrNfEntUnit;
    }

        
    function getVlrNfEnt() {
        return $this->vlrNfEnt;
    }

    function setVlrNfEnt($vlrNfEnt) {
        $this->vlrNfEnt = $vlrNfEnt;
    }

       
    function getProdFinal() {
        return $this->prodFinal;
    }

    function getProdesFinal() {
        return $this->prodesFinal;
    }

    function setProdFinal($prodFinal) {
        $this->prodFinal = $prodFinal;
    }

    function setProdesFinal($prodesFinal) {
        $this->prodesFinal = $prodesFinal;
    }

        
    function getDiamFinalMax() {
        return $this->DiamFinalMax;
    }

    function setDiamFinalMax($DiamFinalMax) {
        $this->DiamFinalMax = $DiamFinalMax;
    }

        
    function getDiamFinalMin() {
        return $this->DiamFinalMin;
    }

    function setDiamFinalMin($DiamFinalMin) {
        $this->DiamFinalMin = $DiamFinalMin;
    }

        
   function getFioDescarbonetaParcial() {
       return $this->fioDescarbonetaParcial;
   }

   function setFioDescarbonetaParcial($fioDescarbonetaParcial) {
       $this->fioDescarbonetaParcial = $fioDescarbonetaParcial;
   }

       
 function getFioDescarbonetaTotal() {
     return $this->fioDescarbonetaTotal;
 }

 function setFioDescarbonetaTotal($fioDescarbonetaTotal) {
     $this->fioDescarbonetaTotal = $fioDescarbonetaTotal;
 }

     
 function getFioEsferio() {
     return $this->fioEsferio;
 }

 function setFioEsferio($fioEsferio) {
     $this->fioEsferio = $fioEsferio;
 }

     
 function getFioDurezaSol() {
     return $this->fioDurezaSol;
 }

 function setFioDurezaSol($fioDurezaSol) {
     $this->fioDurezaSol = $fioDurezaSol;
 }

         
    function getTipoOrdem() {
        return $this->tipoOrdem;
    }

    function setTipoOrdem($tipoOrdem) {
        $this->tipoOrdem = $tipoOrdem;
    }

        
    
    function getDurezaNucMin() {
        return $this->durezaNucMin;
    }

    function getDurezaNucMax() {
        return $this->durezaNucMax;
    }

    function getNucEscala() {
        return $this->NucEscala;
    }

    function getDurezaSuperfMin() {
        return $this->durezaSuperfMin;
    }

    function getDurezaSuperfMax() {
        return $this->durezaSuperfMax;
    }

    function getSuperEscala() {
        return $this->superEscala;
    }

    function getExpCamadaMin() {
        return $this->expCamadaMin;
    }

    function getExpCamadaMax() {
        return $this->expCamadaMax;
    }

    function getTratrevencomp() {
        return $this->tratrevencomp;
    }

    function setDurezaNucMin($durezaNucMin) {
        $this->durezaNucMin = $durezaNucMin;
    }

    function setDurezaNucMax($durezaNucMax) {
        $this->durezaNucMax = $durezaNucMax;
    }

    function setNucEscala($NucEscala) {
        $this->NucEscala = $NucEscala;
    }

    function setDurezaSuperfMin($durezaSuperfMin) {
        $this->durezaSuperfMin = $durezaSuperfMin;
    }

    function setDurezaSuperfMax($durezaSuperfMax) {
        $this->durezaSuperfMax = $durezaSuperfMax;
    }

    function setSuperEscala($superEscala) {
        $this->superEscala = $superEscala;
    }

    function setExpCamadaMin($expCamadaMin) {
        $this->expCamadaMin = $expCamadaMin;
    }

    function setExpCamadaMax($expCamadaMax) {
        $this->expCamadaMax = $expCamadaMax;
    }

    function setTratrevencomp($tratrevencomp) {
        $this->tratrevencomp = $tratrevencomp;
    }

        
    function getOp_retrabalho() {
        return $this->op_retrabalho;
    }

    function setOp_retrabalho($op_retrabalho) {
        $this->op_retrabalho = $op_retrabalho;
    }

        
    function getRetrabalho() {
        return $this->retrabalho;
    }

    function setRetrabalho($retrabalho) {
        $this->retrabalho = $retrabalho;
    }

    

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

   
}

