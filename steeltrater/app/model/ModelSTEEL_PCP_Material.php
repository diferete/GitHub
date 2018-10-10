<?php

/*
 * Classe que implementa os models da DELX_CID_Cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/09/2018
 */

class ModelSTEEL_PCP_Material {
    
    private $matcod;
    private $matdes;
    
    function getMatcod() {
        return $this->matcod;
    }

    function getMatdes() {
        return $this->matdes;
    }

    function setMatcod($matcod) {
        $this->matcod = $matcod;
    }

    function setMatdes($matdes) {
        $this->matdes = $matdes;
    }
    
}