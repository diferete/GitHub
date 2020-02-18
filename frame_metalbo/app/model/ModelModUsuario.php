<?php

class ModelModUsuario {

    private $User;
    private $Modulo;
    private $modordem;

    function getModulo() {
        if (!isset($this->Modulo)) {
            $this->Modulo = Fabrica::FabricarModel('Modulo');
        }
        return $this->Modulo;
    }

    function setModulo($Modulo) {
        $this->Modulo = $Modulo;
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

    function getUser() {
        if (!isset($this->User)) {
            $this->User = Fabrica::FabricarModel('User');
        }
        return $this->User;
    }

    function setUser($User) {
        $this->User = $User;
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

