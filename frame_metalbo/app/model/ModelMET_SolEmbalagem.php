<?php 
 /*
 * Implementa a classe model MET_SolEmbalagem
 * @author Cleverton Hoffmann
 * @since 24/07/2020
 */ 
class ModelMET_SolEmbalagem {
    private $id;
    private $nr;
    private $tipo;
    private $empcod;

    function getId(){
       return $this->id;
    }
    function setId($id){
       $this->id = $id;
    }
    function getNr(){
       return $this->nr;
    }
    function setNr($nr){
       $this->nr = $nr;
    }
    function getTipo(){
       return $this->tipo;
    }
    function setTipo($tipo){
       $this->tipo = $tipo;
    }
    function getEmpcod(){
       return $this->empcod;
    }
    function setEmpcod($empcod){
       $this->empcod = $empcod;
    }
}