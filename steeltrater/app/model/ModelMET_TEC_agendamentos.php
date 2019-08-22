<?php

/* 
 * Implemententa a classe Model dos agendamentos
 */

class ModelMET_TEC_agendamentos {
    private $nr;
    private $titulo;
    private $classe;
    private $metodo;
    private $data;
    private $hora;
    private $parametros;
    private $obs;
    private $agendamento;
    private $intervalominuto;
    
    function getIntervalominuto() {
        return $this->intervalominuto;
    }

    function setIntervalominuto($intervalominuto) {
        $this->intervalominuto = $intervalominuto;
    }

        
    function getAgendamento() {
        return $this->agendamento;
    }

    function setAgendamento($agendamento) {
        $this->agendamento = $agendamento;
    }

                
    function getNr() {
        return $this->nr;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getClasse() {
        return $this->classe;
    }

    function getMetodo() {
        return $this->metodo;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getParametros() {
        return $this->parametros;
    }

    function getObs() {
        return $this->obs;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

    function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }


}