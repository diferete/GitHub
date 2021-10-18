<?php 
 /*
 * Implementa a classe model MET_MANUT_OSServico
 * @author Cleverton Hoffmann
 * @since 06/10/2021
 */
 
class ModelMET_MANUT_OSServico {

    private $fil_codigo;
    private $tipcod;
    private $codserv;
    private $servico;
    private $ciclo;
    private $resp;
    private $usercad;
    private $data;
    private $hora;
    private $sit;
    private $codsetor;
    private $MET_CAD_Setores;
    
    function getMET_CAD_Setores() {
        if(!isset($this->MET_CAD_Setores)){
            $this->MET_CAD_Setores = Fabrica::FabricarModel('MET_CAD_Setores');
        }
        return $this->MET_CAD_Setores;
    }

    function setMET_CAD_Setores($MET_CAD_Setores) {
        $this->MET_CAD_Setores = $MET_CAD_Setores;
    }

    function getFil_codigo(){
       return $this->fil_codigo;
    }
    function setFil_codigo($fil_codigo){
       $this->fil_codigo = $fil_codigo;
    }
    function getTipcod(){
       return $this->tipcod;
    }
    function setTipcod($tipcod){
       $this->tipcod = $tipcod;
    }
    function getCodserv(){
       return $this->codserv;
    }
    function setCodserv($codserv){
       $this->codserv = $codserv;
    }
    function getServico(){
       return $this->servico;
    }
    function setServico($servico){
       $this->servico = $servico;
    }
    function getCiclo(){
       return $this->ciclo;
    }
    function setCiclo($ciclo){
       $this->ciclo = $ciclo;
    }
    function getResp(){
       return $this->resp;
    }
    function setResp($resp){
       $this->resp = $resp;
    }
    function getUsercad(){
       return $this->usercad;
    }
    function setUsercad($usercad){
       $this->usercad = $usercad;
    }
    function getData(){
       return $this->data;
    }
    function setData($data){
       $this->data = $data;
    }
    function getHora(){
       return $this->hora;
    }
    function setHora($hora){
       $this->hora = $hora;
    }
    function getSit(){
       return $this->sit;
    }
    function setSit($sit){
       $this->sit = $sit;
    }
    function getCodsetor(){
       return $this->codsetor;
    }
    function setCodsetor($codsetor){
       $this->codsetor = $codsetor;
    }
}