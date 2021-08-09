<?php 
 /*
 * Implementa a classe model MET_RedeMetalbo
 * @author Cleverton Hoffmann
 * @since 29/10/2020
 */ 
class ModelMET_RedeMetalbo {
    private $cod;
    private $hostname;
    private $ip;
    private $obs;
    private $mac;
    private $tipo;

    function getCod(){
       return $this->cod;
    }
    function setCod($cod){
       $this->cod = $cod;
    }
    function getHostname(){
       return $this->hostname;
    }
    function setHostname($hostname){
       $this->hostname = $hostname;
    }
    function getIp(){
       return $this->ip;
    }
    function setIp($ip){
       $this->ip = $ip;
    }
    function getObs(){
       return $this->obs;
    }
    function setObs($obs){
       $this->obs = $obs;
    }
    function getMac(){
       return $this->mac;
    }
    function setMac($mac){
       $this->mac = $mac;
    }
    function getTipo(){
       return $this->tipo;
    }
    function setTipo($tipo){
       $this->tipo = $tipo;
    }
}