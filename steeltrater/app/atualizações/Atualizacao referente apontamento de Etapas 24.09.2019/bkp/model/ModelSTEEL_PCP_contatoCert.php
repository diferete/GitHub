<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_PCP_contatoCert {
    private $emp_codigo;
    private $empcertemail;
    private $DELX_CAD_Pessoa;
    
    
    
    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

        
    function getDELX_CAD_Pessoa() {
        if(!isset($this->DELX_CAD_Pessoa)){
            $this->DELX_CAD_Pessoa=Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa;
    }

    function setDELX_CAD_Pessoa($DELX_CAD_Pessoa) {
        $this->DELX_CAD_Pessoa = $DELX_CAD_Pessoa;
    }

        
   

    function getEmpcertemail() {
        return $this->empcertemail;
    }

    

    function setEmpcertemail($empcertemail) {
        $this->empcertemail = $empcertemail;
    }


}