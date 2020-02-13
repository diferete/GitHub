<?php

/* 
 *Gerencia o model dos escritórios de representantes
 */

class ModelMET_COM_Repoffice{
    private $filcgc;
    private $officecod;
    private $officedes;
    private $officedir;
    private $officecabsol;
    private $officecabsoliten;
    private $officecabcot;
    private $officecabcotiten;
    private $officeimgrel;
    private $officesolrel;
    private $officecotrel;
    private $officealm;
    private $officeResp;
    
    function getFilcgc() {
        return $this->filcgc;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

        
    function getOfficeResp() {
        return $this->officeResp;
    }

    function setOfficeResp($officeResp) {
        $this->officeResp = $officeResp;
    }

        
    function getOfficealm() {
        return $this->officealm;
    }

    function setOfficealm($officealm) {
        $this->officealm = $officealm;
    }

                
    function getOfficecotrel() {
        return $this->officecotrel;
    }

    function setOfficecotrel($officecotrel) {
        $this->officecotrel = $officecotrel;
    }

        
    function getOfficesolrel() {
        return $this->officesolrel;
    }

    function setOfficesolrel($officesolrel) {
        $this->officesolrel = $officesolrel;
    }

        
    function getOfficeimgrel() {
        return $this->officeimgrel;
    }

    function setOfficeimgrel($officeimgrel) {
        $this->officeimgrel = $officeimgrel;
    }

        
    function getOfficecabcotiten() {
        return $this->officecabcotiten;
    }

    function setOfficecabcotiten($officecabcotiten) {
        $this->officecabcotiten = $officecabcotiten;
    }

        
    function getOfficecabcot() {
        return $this->officecabcot;
    }

    function setOfficecabcot($officecabcot) {
        $this->officecabcot = $officecabcot;
    }

        
    function getOfficecabsoliten() {
        return $this->officecabsoliten;
    }

    function setOfficecabsoliten($officecabsoliten) {
        $this->officecabsoliten = $officecabsoliten;
    }

       
    function getOfficecabsol() {
        return $this->officecabsol;
    }

    function setOfficecabsol($officecabsol) {
        $this->officecabsol = $officecabsol;
    }

            
    function getOfficedir() {
        return $this->officedir;
    }

    function setOfficedir($officedir) {
        $this->officedir = $officedir;
    }

        
    
    
    
    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficedes() {
        return $this->officedes;
    }

  

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficedes($officedes) {
        $this->officedes = $officedes;
    }


}