<?php 
 /*
 * Implementa a classe model MET_CAD_MaquinasImagens
 * @author Cleverton Hoffmann
 * @since 03/08/2021
 */
 
class ModelMET_CAD_MaquinasImagens {

    private $fil_codigo;
    private $cod;
    private $seq;
    private $obs;
    private $endimagem;
    private $data;
    private $coduser;
    private $MET_CAD_Maquinas;
    private $DELX_FIL_Empresa;
    private $MET_TEC_USUARIO;
    
    function getDELX_FIL_Empresa() {
        if(!isset($this->DELX_FIL_Empresa)){
            $this->DELX_FIL_Empresa = Fabrica::FabricarModel('DELX_FIL_Empresa');
        }
        return $this->DELX_FIL_Empresa;
    }
    
    function setDELX_FIL_Empresa($DELX_FIL_Empresa) {
        $this->DELX_FIL_Empresa = $DELX_FIL_Empresa;
    }
    
    function getMET_CAD_Maquinas() {
        if(!isset($this->MET_CAD_Maquinas)){
            $this->MET_CAD_Maquinas = Fabrica::FabricarModel('MET_CAD_Maquinas');
        }
        return $this->MET_CAD_Maquinas;
    }
    
    function setMET_CAD_Maquinas($MET_CAD_Maquinas) {
        $this->MET_CAD_Maquinas = $MET_CAD_Maquinas;
    }
    
    function getMET_TEC_USUARIO() {
        if(!isset($this->MET_TEC_USUARIO)){
            $this->MET_TEC_USUARIO = Fabrica::FabricarModel('MET_TEC_USUARIO');
        }
        return $this->MET_TEC_USUARIO;
    }
    
    function setMET_TEC_USUARIO($MET_TEC_USUARIO) {
        $this->MET_TEC_USUARIO = $MET_TEC_USUARIO;
    }

    function getFil_codigo(){
       return $this->fil_codigo;
    }
    function setFil_codigo($fil_codigo){
       $this->fil_codigo = $fil_codigo;
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
    function getObs(){
       return $this->obs;
    }
    function setObs($obs){
       $this->obs = $obs;
    }
    function getData(){
       return $this->data;
    }
    function setData($data){
       $this->data = $data;
    }
    function getCoduser(){
       return $this->coduser;
    }
    function setCoduser($coduser){
       $this->coduser = $coduser;
    }
    function getEndimagem() {
        return $this->endimagem;
    }

    function setEndimagem($endimagem) {
        $this->endimagem = $endimagem;
    }
}