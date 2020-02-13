<?php

/* 
 * Classe que implementa os models da DELX_CAD_Pessoa
 * 
 * @author Avanei Martendal
 * @since 11/06/2018
 */

class ModelDELX_CAD_Pessoa{
    private $emp_codigo;
    private $emp_razaosocial;
    private $emp_fantasia; 
    private $emp_cadastrodata; 
    private $emp_cadastrousuario;
    
    function getEmp_cadastrousuario() {
        return $this->emp_cadastrousuario;
    }

    function setEmp_cadastrousuario($emp_cadastrousuario) {
        $this->emp_cadastrousuario = $emp_cadastrousuario;
    }


    function getEmp_cadastrodata() {
        return $this->emp_cadastrodata;
    }

    function setEmp_cadastrodata($emp_cadastrodata) {
        $this->emp_cadastrodata = $emp_cadastrodata;
    }
    
                
    function getEmp_fantasia() {
        return $this->emp_fantasia;
    }

    function setEmp_fantasia($emp_fantasia) {
        $this->emp_fantasia = $emp_fantasia;
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


}
