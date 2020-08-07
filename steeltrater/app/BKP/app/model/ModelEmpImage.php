<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelEmpImage {
    private $filcgc;
    private $fillogo;
    
    function getFilcgc() {
        return $this->filcgc;
    }

   
    function getFillogo() {
        return $this->fillogo;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

  
    function setFillogo($fillogo) {
        $this->fillogo = $fillogo;
    }


}