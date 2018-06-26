<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelEmpRex{
    private $filcgc;
    private $fildes;
    
    function getFilcgc() {
        return $this->filcgc;
    }

    function getFildes() {
        return $this->fildes;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setFildes($fildes) {
        $this->fildes = $fildes;
    }


}