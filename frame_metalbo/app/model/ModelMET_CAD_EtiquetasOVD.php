<?php 
 /*
 * Implementa a classe model MET_CAD_EtiquetasOVD
 * @author Cleverton Hoffmann
 * @since 08/07/2020
 */ 
class ModelMET_CAD_EtiquetasOVD {
    private $procod;
    private $codovd;
    private $descovd;
    private $descricao;
    private $descricao2;
    private $medida;
    private $ean;
    private $pecas;
    private $centosnormal;
    private $centosmaster;
    private $unmaster;
    private $unnormal;
    private $imagem;
    private $unmed;
    private $descesp;
    private $rosca;
    private $tipo;

    function getProcod(){
       return $this->procod;
    }
    function setProcod($procod){
       $this->procod = $procod;
    }
    function getCodovd(){
       return $this->codovd;
    }
    function setCodovd($codovd){
       $this->codovd = $codovd;
    }
    function getDescovd(){
       return $this->descovd;
    }
    function setDescovd($descovd){
       $this->descovd = $descovd;
    }
    function getDescricao(){
       return $this->descricao;
    }
    function setDescricao($descricao){
       $this->descricao = $descricao;
    }
    function getDescricao2(){
       return $this->descricao2;
    }
    function setDescricao2($descricao2){
       $this->descricao2 = $descricao2;
    }
    function getMedida(){
       return $this->medida;
    }
    function setMedida($medida){
       $this->medida = $medida;
    }
    function getEan(){
       return $this->ean;
    }
    function setEan($ean){
       $this->ean = $ean;
    }
    function getPecas(){
       return $this->pecas;
    }
    function setPecas($pecas){
       $this->pecas = $pecas;
    }
    function getCentosnormal(){
       return $this->centosnormal;
    }
    function setCentosnormal($centosnormal){
       $this->centosnormal = $centosnormal;
    }
    function getCentosmaster(){
       return $this->centosmaster;
    }
    function setCentosmaster($centosmaster){
       $this->centosmaster = $centosmaster;
    }
    function getUnmaster(){
       return $this->unmaster;
    }
    function setUnmaster($unmaster){
       $this->unmaster = $unmaster;
    }
    function getUnnormal(){
       return $this->unnormal;
    }
    function setUnnormal($unnormal){
       $this->unnormal = $unnormal;
    }
    function getImagem(){
       return $this->imagem;
    }
    function setImagem($imagem){
       $this->imagem = $imagem;
    }
    function getUnmed(){
       return $this->unmed;
    }
    function setUnmed($unmed){
       $this->unmed = $unmed;
    }
    function getDescesp(){
       return $this->descesp;
    }
    function setDescesp($descesp){
       $this->descesp = $descesp;
    }
    function getRosca(){
       return $this->rosca;
    }
    function setRosca($rosca){
       $this->rosca = $rosca;
    }
    function getTipo(){
       return $this->tipo;
    }
    function setTipo($tipo){
       $this->tipo = $tipo;
    }
}