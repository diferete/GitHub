<?php 
 /*
 * Implementa a classe model MET_MANUT_OS
 * @author Cleverton Hoffmann
 * @since 21/07/2021
 */
 
class ModelMET_MANUT_OS {

    private $fil_codigo;
    private $nr;
    private $cod;
    private $usuariocad;
    private $datacad;
    private $codserv;
    private $horacad;
    private $userenc;
    private $consumo;
    private $problema;
    private $solucao;
    private $previsao;
    private $responsavel;
    private $dataenc;
    private $horaenc;
    private $tipomanut;
    private $dias;
    private $codsetor;
    private $obs;
    private $situacao;
    private $oqfazer;
    private $fezmanut;
    private $matnecessario;
    private $MET_CAD_Maquinas;
    private $DELX_FIL_Empresa;
    private $MET_TEC_USUARIO;
    private $MET_MANUT_OSServico;
    
    function getMET_MANUT_OSServico() {
        if(!isset($this->MET_MANUT_OSServico)){
            $this->MET_MANUT_OSServico = Fabrica::FabricarModel('MET_MANUT_OSServico');
        }
        return $this->MET_MANUT_OSServico;
    }
    
    function setMET_MANUT_OSServico($MET_MANUT_OSServico) {
        $this->MET_MANUT_OSServico = $MET_MANUT_OSServico;
    }
    
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
    
    function getMatnecessario() {
        return $this->matnecessario;
    }

    function setMatnecessario($matnecessario) {
        $this->matnecessario = $matnecessario;
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
    function getUsuariocad(){
       return $this->usuariocad;
    }
    function setUsuariocad($usuariocad){
       $this->usuariocad = $usuariocad;
    }
    function getDatacad(){
       return $this->datacad;
    }
    function setDatacad($datacad){
       $this->datacad = $datacad;
    }
    function getCodserv(){
       return $this->codserv;
    }
    function setCodserv($codserv){
       $this->codserv = $codserv;
    }
    function getHoracad(){
       return $this->horacad;
    }
    function setHoracad($horacad){
       $this->horacad = $horacad;
    }
    function getUserenc(){
       return $this->userenc;
    }
    function setUserenc($userenc){
       $this->userenc = $userenc;
    }
    function getConsumo(){
       return $this->consumo;
    }
    function setConsumo($consumo){
       $this->consumo = $consumo;
    }
    function getProblema(){
       return $this->problema;
    }
    function setProblema($problema){
       $this->problema = $problema;
    }
    function getSolucao(){
       return $this->solucao;
    }
    function setSolucao($solucao){
       $this->solucao = $solucao;
    }
    function getPrevisao(){
       return $this->previsao;
    }
    function setPrevisao($previsao){
       $this->previsao = $previsao;
    }
    function getResponsavel(){
       return $this->responsavel;
    }
    function setResponsavel($responsavel){
       $this->responsavel = $responsavel;
    }
    function getDataenc(){
       return $this->dataenc;
    }
    function setDataenc($dataenc){
       $this->dataenc = $dataenc;
    }
    function getHoraenc(){
       return $this->horaenc;
    }
    function setHoraenc($horaenc){
       $this->horaenc = $horaenc;
    }
    function getTipomanut(){
       return $this->tipomanut;
    }
    function setTipomanut($tipomanut){
       $this->tipomanut = $tipomanut;
    }
    function getDias(){
       return $this->dias;
    }
    function setDias($dias){
       $this->dias = $dias;
    }
    function getCodsetor(){
       return $this->codsetor;
    }
    function setCodsetor($codsetor){
       $this->codsetor = $codsetor;
    }
    function getObs(){
       return $this->obs;
    }
    function setObs($obs){
       $this->obs = $obs;
    }
    function getSituacao(){
       return $this->situacao;
    }
    function setSituacao($situacao){
       $this->situacao = $situacao;
    }
    function getOqfazer(){
       return $this->oqfazer;
    }
    function setOqfazer($oqfazer){
       $this->oqfazer = $oqfazer;
    }
    function getFezmanut(){
       return $this->fezmanut;
    }
    function setFezmanut($fezmanut){
       $this->fezmanut = $fezmanut;
    }
}