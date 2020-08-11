<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class ModelQualAq {
    private $nr;
    private $titulo;
    private $dtimp;
    private $horimp;
    private $userimp;
    private $EmpRex;
    private $usucodigo;
    private $usunome;
    private $dataini;
    private $datafim;
    private $equipe;
    private $tipoacao;
    private $origem;
    private $tipmelhoria;
    private $problema;
    private $objetivo;
    private $causaprov;
    private $pq1;
    private $pq2;
    private $pq3;
    private $pq4;
    private $pq5;
    private $sit;
    private $userfech;
    private $datafech;
    private $horafech;
    private $anexo1;
    private $anexo2;
    private $certificacao;
    private $acao;
    
    function getAcao() {
        return $this->acao;
    }

    function setAcao($acao) {
        $this->acao = $acao;
    }

                
    function getCertificacao() {
        return $this->certificacao;
    }

    function setCertificacao($certificacao) {
        $this->certificacao = $certificacao;
    }

        
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

        
    function getAnexo2() {
        return $this->anexo2;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

        
    function getAnexo1() {
        return $this->anexo1;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

        
    function getHorafech() {
        return $this->horafech;
    }

    function setHorafech($horafech) {
        $this->horafech = $horafech;
    }

        
    function getUserfech() {
        return $this->userfech;
    }

    function getDatafech() {
        return $this->datafech;
    }

   

    function setUserfech($userfech) {
        $this->userfech = $userfech;
    }

    function setDatafech($datafech) {
        $this->datafech = $datafech;
    }

   
        
    
    function getSit() {
        return $this->sit;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

        
    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

        
    function getPq2() {
        return $this->pq2;
    }

    function getPq3() {
        return $this->pq3;
    }

    function getPq4() {
        return $this->pq4;
    }

    function getPq5() {
        return $this->pq5;
    }

    function setPq2($pq2) {
        $this->pq2 = $pq2;
    }

    function setPq3($pq3) {
        $this->pq3 = $pq3;
    }

    function setPq4($pq4) {
        $this->pq4 = $pq4;
    }

    function setPq5($pq5) {
        $this->pq5 = $pq5;
    }

        
    function getPq1() {
        return $this->pq1;
    }

    function setPq1($pq1) {
        $this->pq1 = $pq1;
    }

        
    function getCausaprov() {
        return $this->causaprov;
    }

    function setCausaprov($causaprov) {
        $this->causaprov = $causaprov;
    }

        
   

        
    function getObjetivo() {
        return $this->objetivo;
    }

    function setObjetivo($objetivo) {
        $this->objetivo = $objetivo;
    }

        
    function getProblema() {
        return $this->problema;
    }

    function setProblema($problema) {
        $this->problema = $problema;
    }

        
    function getTipmelhoria() {
        return $this->tipmelhoria;
    }

    function setTipmelhoria($tipmelhoria) {
        $this->tipmelhoria = $tipmelhoria;
    }

                
    function getOrigem() {
        return $this->origem;
    }

    function setOrigem($origem) {
        $this->origem = $origem;
    }

        
    function getTipoacao() {
        return $this->tipoacao;
    }

    function setTipoacao($tipoacao) {
        $this->tipoacao = $tipoacao;
    }

        
    function getEquipe() {
        return $this->equipe;
    }

    function setEquipe($equipe) {
        $this->equipe = $equipe;
    }

        
    function getDatafim() {
        return $this->datafim;
    }

    function setDatafim($datafim) {
        $this->datafim = $datafim;
    }

        
    function getDataini() {
        return $this->dataini;
    }

    function setDataini($dataini) {
        $this->dataini = $dataini;
    }

        
   
        
    function getEmpRex() {
        if(!isset($this->EmpRex)){
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }
        return $this->EmpRex;
    }
    

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

            
    function getNr() {
        return $this->nr;
    }

    function getDtimp() {
        return $this->dtimp;
    }

    function getHorimp() {
        return $this->horimp;
    }

    function getUserimp() {
        return $this->userimp;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setDtimp($dtimp) {
        $this->dtimp = $dtimp;
    }

    function setHorimp($horimp) {
        $this->horimp = $horimp;
    }

    function setUserimp($userimp) {
        $this->userimp = $userimp;
    }


}
