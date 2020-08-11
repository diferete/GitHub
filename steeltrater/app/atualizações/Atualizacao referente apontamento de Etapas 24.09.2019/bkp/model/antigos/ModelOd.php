<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelOd {
   
    private $odnr;
    private $oddata;
    private $odhora;
    private $odusuario;
    private $empcnpj;
    private $Pessoa;
    private $odtipo;
    private $odsit;
    private $odser_equip;
    private $odser_problema;
    private $odcontato;
    private $odser_sol;
    private $CondPag;
    
    function getCondPag() {
        if(!isset($this->CondPag)){
            $this->CondPag=  Fabrica::FabricarModel('CondPag');
        }
        return $this->CondPag;
    }

    function setCondPag($CondPag) {
        $this->CondPag = $CondPag;
    }

        
    function getOdser_sol() {
        return $this->odser_sol;
    }

    function setOdser_sol($odser_sol) {
        $this->odser_sol = $odser_sol;
    }

        
    function getOdcontato() {
        return $this->odcontato;
    }

    function setOdcontato($odcontato) {
        $this->odcontato = $odcontato;
    }

        
    function getOdser_problema() {
        return $this->odser_problema;
    }

    function setOdser_problema($odser_problema) {
        $this->odser_problema = $odser_problema;
    }

                
    function getOdser_equip() {
        return $this->odser_equip;
    }

    function setOdser_equip($odser_equip) {
        $this->odser_equip = $odser_equip;
    }

        
    function getOdsit() {
        return $this->odsit;
    }

    function setOdsit($odsit) {
        $this->odsit = $odsit;
    }

        
    function getOdtipo() {
        return $this->odtipo;
    }

    function setOdtipo($odtipo) {
        $this->odtipo = $odtipo;
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

        
    
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    
    function getOdnr() {
        return $this->odnr;
    }

    function getOddata() {
        return $this->oddata;
    }

    function getOdhora() {
        return $this->odhora;
    }

    function getOdusuario() {
        return $this->odusuario;
    }

   

    function setOdnr($odnr) {
        $this->odnr = $odnr;
    }

    function setOddata($oddata) {
        $this->oddata = $oddata;
    }

    function setOdhora($odhora) {
        $this->odhora = $odhora;
    }

    function setOdusuario($odusuario) {
        $this->odusuario = $odusuario;
    }


}
