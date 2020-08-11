<?php

class ModelImagemTeste{
    private $id;
    private $caminho;
    private $data;
    private $hora;
    
    function getId() {
        return $this->id;
    }

    function getCaminho() {
        return $this->caminho;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }


}