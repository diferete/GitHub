<?php

/*
 * Classe que implementa os models da STEEL_PCP_TabCabPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2018
 */

class ModelSTEEL_PCP_TabCabPreco{
    
    private $nr;
    private $emp_codigo;
    private $nometabela;
    private $DELX_CAD_Pessoa;
    private $usuarioCadastro;
    private $data;
    private $sit;
    private $concatena;
    
    function getConcatena() {
        return $this->concatena;
    }

    function setConcatena($concatena) {
        $this->concatena = $concatena;
    }

        
    function getSit() {
        return $this->sit;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

        
    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

        
    function getUsuarioCadastro() {
        return $this->usuarioCadastro;
    }

    function setUsuarioCadastro($usuarioCadastro) {
        $this->usuarioCadastro = $usuarioCadastro;
    }
    
    function getDELX_CAD_Pessoa() {
        if(!isset($this->DELX_CAD_Pessoa)){
            $this->DELX_CAD_Pessoa = Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa;
    }

    function setDELX_CAD_Pessoa($DELX_CAD_Pessoa) {
        $this->DELX_CAD_Pessoa = $DELX_CAD_Pessoa;
    }

           
    function getNr() {
        return $this->nr;
    }

    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getNometabela() {
        return $this->nometabela;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setNometabela($nometabela) {
        $this->nometabela = $nometabela;
    }
    
}