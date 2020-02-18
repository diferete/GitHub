<?php

/* 
 * Implementando classe model tratamentos produção steel
 * 
 * @author Avanei Martendal
 * 
 * @since 31/05/2018
 */

class ModelSTEEL_CAD_tratamentos {
    private $tratcod;
    private $tratdes;
    
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