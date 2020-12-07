<?php 
 /*
 * Implementa a classe model STEEL_PCP_ParMotivo
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */ 
class ModelSTEEL_PCP_ParMotivo {
    private $codmotivo;
    private $descricao;

    function getCodmotivo(){
       return $this->codmotivo;
    }
    function setCodmotivo($codmotivo){
       $this->codmotivo = $codmotivo;
    }
    function getDescricao(){
       return $this->descricao;
    }
    function setDescricao($descricao){
       $this->descricao = $descricao;
    }
}