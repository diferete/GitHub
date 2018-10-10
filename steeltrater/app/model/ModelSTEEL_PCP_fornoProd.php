<?php

/* 
 * Classe que implementa o model da classe fornoProd
 * @author Avanei Martendal
 * @since 28/08/2018
 */

class ModelSTEEL_PCP_fornoProd {
    private $prod;
    private $fornocod;
    private $STEEL_PCP_Forno;
    
    function getFornocod() {
        return $this->fornocod;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

        
    function getSTEEL_PCP_Forno() {
        if(!isset($this->STEEL_PCP_Forno)){
            $this->STEEL_PCP_Forno = Fabrica::FabricarModel('STEEL_PCP_Forno');
        }
        return $this->STEEL_PCP_Forno;
    }

    function setSTEEL_PCP_Forno($STEEL_PCP_Forno) {
        $this->STEEL_PCP_Forno = $STEEL_PCP_Forno;
    }

        
    function getProd() {
        return $this->prod;
    }

   

    function setProd($prod) {
        $this->prod = $prod;
    }

    

}

