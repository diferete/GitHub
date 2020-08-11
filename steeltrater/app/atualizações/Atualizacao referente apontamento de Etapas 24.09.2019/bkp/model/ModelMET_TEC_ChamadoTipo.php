<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_ChamadoTipo {

    private $tipo;
    private $subtipo;
    private $subtipo_nome;

    function getTipo() {
        return $this->tipo;
    }

    function getSubtipo() {
        return $this->subtipo;
    }

    function getSubtipo_nome() {
        return $this->subtipo_nome;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setSubtipo($subtipo) {
        $this->subtipo = $subtipo;
    }

    function setSubtipo_nome($subtipo_nome) {
        $this->subtipo_nome = $subtipo_nome;
    }

}
