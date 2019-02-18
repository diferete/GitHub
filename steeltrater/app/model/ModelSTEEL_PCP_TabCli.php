<?php

/*
 * Classe que implementa os models da STEEL_PCP_TabCli
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class ModelSTEEL_PCP_TabCli{
    
    private $cod;
    private $emp_codigo;
    private $tab_preco;
    
    function getCod() {
        return $this->cod;
    }

    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getTab_preco() {
        return $this->tab_preco;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setTab_preco($tab_preco) {
        $this->tab_preco = $tab_preco;
    }

}