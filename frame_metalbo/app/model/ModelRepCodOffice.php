<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelRepCodOffice {
    private $filcgc;
    private $officecod;
    private $officeseq;
    private $repcod;
    
    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

        
    function getFilcgc() {
        return $this->filcgc;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficeseq() {
        return $this->officeseq;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficeseq($officeseq) {
        $this->officeseq = $officeseq;
    }


    
}