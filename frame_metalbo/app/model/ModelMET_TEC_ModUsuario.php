<?php
class ModelMET_TEC_ModUsuario{
    private $MET_TEC_Usuario;
    private $MET_TEC_Modulo;
    private $modordem;
    
    
    function getMET_TEC_Modulo() {
        if(!isset($this->MET_TEC_Modulo)){
            $this->MET_TEC_Modulo = Fabrica::FabricarModel('MET_TEC_Modulo');
        }
        return $this->MET_TEC_Modulo;
    }

    function setMET_TEC_Modulo($MET_TEC_Modulo) {
        $this->MET_TEC_Modulo = $MET_TEC_Modulo;
    }

       
    /*
     *   if(!isset($this->Grupo)){
            $this->Grupo = Fabrica::FabricarModel('Grupo');
        }
        return $this->Grupo;
     */

    function getModordem() {
        return $this->modordem;
    }

   
    

    function setModordem($modordem) {
        $this->modordem = $modordem;
    }

    function getMET_TEC_Usuario() {
        if(!isset($this->MET_TEC_Usuario)){
            $this->MET_TEC_Usuario = Fabrica::FabricarModel('MET_TEC_Usuario');
        }
        return $this->MET_TEC_Usuario;
    }

    function setMET_TEC_Usuario($MET_TEC_Usuario) {
        $this->MET_TEC_Usuario = $MET_TEC_Usuario;
    }



}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

