<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelChamadoTi {
    private $id;
    private $ChamadoSit;
    private $tipo;
    private $MetSisMetalbo;
    private $datacad;
    private $horacad;
    private $User;
    private $probl;
    private $atendeti;

    function getAtendeti() {
        return $this->atendeti;
    }

    function setAtendeti($atendeti) {
        $this->atendeti = $atendeti;
    }

            
    function getProbl() {
        return $this->probl;
    }

    function setProbl($probl) {
        $this->probl = $probl;
    }

        
    function getUser() {
        if(!isset($this->User)){
            $this->User = Fabrica::FabricarModel('User');
        }
        return $this->User;
    }

    function setUser($User) {
        $this->User = $User;
    }

        
    function getDatacad() {
        return $this->datacad;
    }

    function getHoracad() {
        return $this->horacad;
    }

    function setDatacad($datacad) {
        $this->datacad = $datacad;
    }

    function setHoracad($horacad) {
        $this->horacad = $horacad;
    }

        
    function getMetSisMetalbo() {
        if(!isset($this->MetSisMetalbo)){
            $this->MetSisMetalbo = Fabrica::FabricarModel('MetSisMetalbo');
        }
        return $this->MetSisMetalbo;
    }

    function setMetSisMetalbo($MetSisMetalbo) {
        $this->MetSisMetalbo = $MetSisMetalbo;
    }

        
    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

        function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getChamadoSit() {
        if(!isset($this->ChamadoSit)){
            $this->ChamadoSit = Fabrica::FabricarModel('ChamadoSit');
        }
        return $this->ChamadoSit;
    }

    function setChamadoSit($ChamadoSit) {
        $this->ChamadoSit = $ChamadoSit;
    }


}