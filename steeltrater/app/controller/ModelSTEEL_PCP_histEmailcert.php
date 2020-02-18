<?php

class ModelSTEEL_PCP_histEmailcert{
    
    private $id;
    private $nrcert;
    private $userEmail;
    private $data;
    private $hora;
    private $destinatario;
    private $sitenv;
    
    function getId() {
        return $this->id;
    }

    function getNrcert() {
        return $this->nrcert;
    }

    function getUserEmail() {
        return $this->userEmail;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getDestinatario() {
        return $this->destinatario;
    }

    function getSitenv() {
        return $this->sitenv;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNrcert($nrcert) {
        $this->nrcert = $nrcert;
    }

    function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
    }

    function setSitenv($sitenv) {
        $this->sitenv = $sitenv;
    }

    



   
}

