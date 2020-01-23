<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelSTEEL_PCP_ServicoEquip{
    private $tratcod;
    private $fornocod;
    private $STEEL_PCP_Tratamentos;
    private $STEEL_PCP_Forno;
    
    function getSTEEL_PCP_Forno() {
        if(!isset($this->STEEL_PCP_Forno)){
            $this->STEEL_PCP_Forno = Fabrica::FabricarModel('STEEL_PCP_Forno');
        }
        return $this->STEEL_PCP_Forno;
    }

    function setSTEEL_PCP_Forno($STEEL_PCP_Forno) {
        $this->STEEL_PCP_Forno = $STEEL_PCP_Forno;
    }

        
    function getSTEEL_PCP_Tratamentos() {
        if(!isset($this->STEEL_PCP_Tratamentos)){
            $this->STEEL_PCP_Tratamentos = Fabrica::FabricarModel('STEEL_PCP_Tratamentos');
        }
        return $this->STEEL_PCP_Tratamentos;
    }

    function setSTEEL_PCP_Tratamentos($STEEL_PCP_Tratamentos) {
        $this->STEEL_PCP_Tratamentos = $STEEL_PCP_Tratamentos;
    }

                
    function getTratcod() {
        return $this->tratcod;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function setTratcod($tratcod) {
        $this->tratcod = $tratcod;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }


}