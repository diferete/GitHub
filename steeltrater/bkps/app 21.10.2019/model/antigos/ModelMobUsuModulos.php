<?php

class ModelMobUsuModulos{
    private $id;
    private $MobModulos;
    private $User;
    private $mobmodordem;
    
    
    function getMobModulos() {
        if(!isset($this->MobModulos)){
            $this->MobModulos = Fabrica::FabricarModel('MobModulos');
        }
        return $this->MobModulos;
    }

    function setMobModulos($MobModulos) {
        $this->MobModulos = $MobModulos;
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

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

        
    function getMobmodordem() {
        return $this->mobmodordem;
    }

    function setMobmodordem($mobmodordem) {
        $this->mobmodordem = $mobmodordem;
    }


    
}