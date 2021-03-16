<?php 
 /*
 * Implementa a classe model STEEL_PCP_ParForno
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */ 
class ModelSTEEL_PCP_ParForno {
    private $cod;
    private $codmotivo;
    private $fornocod;
    private $datainicio;
    private $horainicio;
    private $coduseraberto;
    private $desuseraberto;
    private $coduserfechou;
    private $desuserfechou;
    private $datafim;
    private $horafim;
    private $obs;

    function getCod(){
       return $this->cod;
    }
    function setCod($cod){
       $this->cod = $cod;
    }
    function getCodmotivo(){
       return $this->codmotivo;
    }
    function setCodmotivo($codmotivo){
       $this->codmotivo = $codmotivo;
    }
    function getFornocod(){
       return $this->fornocod;
    }
    function setFornocod($fornocod){
       $this->fornocod = $fornocod;
    }
    function getDatainicio(){
       return $this->datainicio;
    }
    function setDatainicio($datainicio){
       $this->datainicio = $datainicio;
    }
    function getHorainicio(){
       return $this->horainicio;
    }
    function setHorainicio($horainicio){
       $this->horainicio = $horainicio;
    }
    function getCoduseraberto(){
       return $this->coduseraberto;
    }
    function setCoduseraberto($coduseraberto){
       $this->coduseraberto = $coduseraberto;
    }
    function getDesuseraberto(){
       return $this->desuseraberto;
    }
    function setDesuseraberto($desuseraberto){
       $this->desuseraberto = $desuseraberto;
    }
    function getCoduserfechou(){
       return $this->coduserfechou;
    }
    function setCoduserfechou($coduserfechou){
       $this->coduserfechou = $coduserfechou;
    }
    function getDesuserfechou(){
       return $this->desuserfechou;
    }
    function setDesuserfechou($desuserfechou){
       $this->desuserfechou = $desuserfechou;
    }
    function getDatafim(){
       return $this->datafim;
    }
    function setDatafim($datafim){
       $this->datafim = $datafim;
    }
    function getHorafim(){
       return $this->horafim;
    }
    function setHorafim($horafim){
       $this->horafim = $horafim;
    }
    function getObs(){
       return $this->obs;
    }
    function setObs($obs){
       $this->obs = $obs;
    }
}