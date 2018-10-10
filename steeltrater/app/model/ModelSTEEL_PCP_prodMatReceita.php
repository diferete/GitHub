<?php

/*
 * Classe que implementa os models da DELX_CID_Cidade
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ModelSTEEL_PCP_prodMatReceita {
    
    private $DELX_PRO_Produtos;
    private $STEEL_PCP_material;
    private $STEEL_PCP_receitas;
    private $prod;
    private $matcod;
    private $cod;
    private $durezaNuc;
    private $durezaSuperf;
    private $expeCamada;
    private $seqmat;
    
    function getExpeCamada() {
        return $this->expeCamada;
    }

    function setExpeCamada($expeCamada) {
        $this->expeCamada = $expeCamada;
    }

        
    function getSeqmat() {
        return $this->seqmat;
    }

    function setSeqmat($seqmat) {
        $this->seqmat = $seqmat;
    }
    
    function getDurezaNuc() {
        return $this->durezaNuc;
    }

    function getDurezaSuperf() {
        return $this->durezaSuperf;
    }

   

    function setDurezaNuc($durezaNuc) {
        $this->durezaNuc = $durezaNuc;
    }

    function setDurezaSuperf($durezaSuperf) {
        $this->durezaSuperf = $durezaSuperf;
    }

    function getProd() {
        return $this->prod;
    }

    function setProd($prod) {
        $this->prod = $prod;
    }
    
        
    function getDELX_PRO_Produtos() {
        if(!isset($this->DELX_PRO_Produtos)){
            $this->DELX_PRO_Produtos = Fabrica::FabricarModel('DELX_PRO_Produtos');
        }
        return $this->DELX_PRO_Produtos;
    }

    function setDELX_PRO_Produtos($DELX_PRO_Produtos) {
        $this->DELX_PRO_Produtos = $DELX_PRO_Produtos;
    }

    function getSTEEL_PCP_material() {
        if(!isset($this->STEEL_PCP_material)){
            $this->STEEL_PCP_material = Fabrica::FabricarModel('STEEL_PCP_material');
        }
        return $this->STEEL_PCP_material;
    }

    function setSTEEL_PCP_material($STEEL_PCP_material) {
        $this->STEEL_PCP_material = $STEEL_PCP_material;
    }
    
     function getSTEEL_PCP_receitas() {
        if(!isset($this->STEEL_PCP_receitas)){
            $this->STEEL_PCP_receitas = Fabrica::FabricarModel('STEEL_PCP_receitas');
        }
        return $this->STEEL_PCP_receitas;
    }

    function setSTEEL_PCP_receitas($STEEL_PCP_receitas) {
        $this->STEEL_PCP_receitas = $STEEL_PCP_receitas;
    }
    
    function getMatcod() {
        return $this->matcod;
    }

    function getCod() {
        return $this->cod;
    }

    

    function setMatcod($matcod) {
        $this->matcod = $matcod;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }
    
}
    