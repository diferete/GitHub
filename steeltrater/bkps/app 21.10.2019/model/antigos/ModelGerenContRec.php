<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelGerenContRec {
    private $empcnpj;
    private $Pessoa;
    private $recdocto;
    private $recparc;
    private $recparcvlr;
    private $recparcvenc;
    private $recobs;
    private $recsit;
    private $recdatapag;
    private $recobspag;
    private $recuserapont;
    
    function getRecuserapont() {
        return $this->recuserapont;
    }

    function setRecuserapont($recuserapont) {
        $this->recuserapont = $recuserapont;
    }

        
    function getRecobspag() {
        return $this->recobspag;
    }

    function setRecobspag($recobspag) {
        $this->recobspag = $recobspag;
    }

        
    function getRecdatapag() {
        return $this->recdatapag;
    }

    function setRecdatapag($recdatapag) {
        $this->recdatapag = $recdatapag;
    }

        
    function getRecsit() {
        return $this->recsit;
    }

    function setRecsit($recsit) {
        $this->recsit = $recsit;
    }

        
    function getPessoa() {
        if(!isset($this->Pessoa)){
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

        
    function getRecobs() {
        return $this->recobs;
    }

    function setRecobs($recobs) {
        $this->recobs = $recobs;
    }

        
    
    
    function getEmpcnpj() {
        return $this->empcnpj;
    }

   
    function getRecdocto() {
        return $this->recdocto;
    }

    function getRecparc() {
        return $this->recparc;
    }

    function getRecparcvlr() {
        return $this->recparcvlr;
    }

    function getRecparcvenc() {
        return $this->recparcvenc;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

   

    function setRecdocto($recdocto) {
        $this->recdocto = $recdocto;
    }

    function setRecparc($recparc) {
        $this->recparc = $recparc;
    }

    function setRecparcvlr($recparcvlr) {
        $this->recparcvlr = $recparcvlr;
    }

    function setRecparcvenc($recparcvenc) {
        $this->recparcvenc = $recparcvenc;
    }

 
    
    
    
}
