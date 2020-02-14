<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelPoliManut {
    private $nr;
    private $data;
    private $hora;
    private $usuario;
    private $PoliCadMaq;
    private $problema;
    private $situaca; 
    private $solucao;
    private $mecanico;
    private $consumo;
    private $previsao;
    
    function getPrevisao() {
        return $this->previsao;
    }

    function setPrevisao($previsao) {
        $this->previsao = $previsao;
    }

        
    function getConsumo() {
        return $this->consumo;
    }

    function setConsumo($consumo) {
        $this->consumo = $consumo;
    }

        
    function getMecanico() {
        return $this->mecanico;
    }

    function setMecanico($mecanico) {
        $this->mecanico = $mecanico;
    }

        
    function getSolucao() {
        return $this->solucao;
    }

    function setSolucao($solucao) {
        $this->solucao = $solucao;
    }

        
    function getSituaca() {
        return $this->situaca;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

        
    function getProblema() {
        return $this->problema;
    }

    function setProblema($problema) {
        $this->problema = $problema;
    }

        
    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

        function getNr() {
        return $this->nr;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    

    function getPoliCadMaq() {
        if(!isset($this->PoliCadMaq)){
            $this->PoliCadMaq = Fabrica::FabricarModel('PoliCadMaq');
        }
        return $this->PoliCadMaq;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

  

    function setPoliCadMaq($PoliCadMaq) {
        $this->PoliCadMaq = $PoliCadMaq;
    }


}