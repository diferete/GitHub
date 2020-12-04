<?php

/* 
 * Implementando classe model tratamentos produção steel
 * 
 * @author Avanei Martendal
 * 
 * @since 31/05/2018
 */

class ModelSTEEL_PCP_Tratamentos {
    private $tratcod;
    private $tratdes;
    private $tratrevencomp;
    private $tratdesrel;
    
    function getTratdesrel() {
        return $this->tratdesrel;
    }

    function setTratdesrel($tratdesrel) {
        $this->tratdesrel = $tratdesrel;
    }

        
    function getTratrevencomp() {
        return $this->tratrevencomp;
    }

    function setTratrevencomp($tratrevencomp) {
        $this->tratrevencomp = $tratrevencomp;
    }

        
    function getTratcod() {
        return $this->tratcod;
    }

    function getTratdes() {
        return $this->tratdes;
    }

    function setTratcod($tratcod) {
        $this->tratcod = $tratcod;
    }

    function setTratdes($tratdes) {
        $this->tratdes = $tratdes;
    }


   
    
}