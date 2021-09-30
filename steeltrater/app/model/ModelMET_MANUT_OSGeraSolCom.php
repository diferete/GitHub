<?php 
 /*
 * Implementa a classe model MET_MANUT_OSGeraSolCom
 * @author Cleverton Hoffmann
 * @since 20/09/2021
 */
 
class ModelMET_MANUT_OSGeraSolCom {

    private $fil_codigo;
    private $nr;
    private $cod;
    private $seq;
    private $codmat;
    private $descricaomat;
    private $usermatcod;
    private $usermatdes;
    private $quantidade;
    private $obsmat;
    private $datamat;
    private $processoCompra;
    private $numero;
    private $quantMatSol;
    
    function getQuantMatSol() {
        return $this->quantMatSol;
    }

    function setQuantMatSol($quantMatSol) {
        $this->quantMatSol = $quantMatSol;
    }

    function getNumero() {
        return $this->numero;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function getProcessoCompra() {
        return $this->processoCompra;
    }

    function setProcessoCompra($processoCompra) {
        $this->processoCompra = $processoCompra;
    } 

    function getFil_codigo(){
       return $this->fil_codigo;
    }
    function setFil_codigo($fil_codigo){
       $this->fil_codigo = $fil_codigo;
    }
    function getNr(){
       return $this->nr;
    }
    function setNr($nr){
       $this->nr = $nr;
    }
    function getCod(){
       return $this->cod;
    }
    function setCod($cod){
       $this->cod = $cod;
    }
    function getSeq(){
       return $this->seq;
    }
    function setSeq($seq){
       $this->seq = $seq;
    }
    function getCodmat(){
       return $this->codmat;
    }
    function setCodmat($codmat){
       $this->codmat = $codmat;
    }
    function getDescricaomat(){
       return $this->descricaomat;
    }
    function setDescricaomat($descricaomat){
       $this->descricaomat = $descricaomat;
    }
    function getUsermatcod(){
       return $this->usermatcod;
    }
    function setUsermatcod($usermatcod){
       $this->usermatcod = $usermatcod;
    }
    function getUsermatdes(){
       return $this->usermatdes;
    }
    function setUsermatdes($usermatdes){
       $this->usermatdes = $usermatdes;
    }
    function getQuantidade(){
       return $this->quantidade;
    }
    function setQuantidade($quantidade){
       $this->quantidade = $quantidade;
    }
    function getObsmat(){
       return $this->obsmat;
    }
    function setObsmat($obsmat){
       $this->obsmat = $obsmat;
    }
    function getDatamat(){
       return $this->datamat;
    }
    function setDatamat($datamat){
       $this->datamat = $datamat;
    }
}