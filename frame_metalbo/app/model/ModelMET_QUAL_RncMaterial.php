<?php 
 /*
 * Implementa a classe model MET_QUAL_RncMaterial
 * @author Cleverton Hoffmann
 * @since 25/08/2020
 */ 
class ModelMET_QUAL_RncMaterial {
    private $cod;
    private $corrida;

    function getCod(){
       return $this->cod;
    }
    function setCod($cod){
       $this->cod = $cod;
    }
    function getCorrida(){
       return $this->corrida;
    }
    function setCorrida($corrida){
       $this->corrida = $corrida;
    }
}