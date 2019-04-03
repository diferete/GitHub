<?php

/* 
 * Classe que implementa o model da pesquisa da sitisfacao
 * 
 * @author Avanei Martendal
 * @since 14/01/2018
 */

class ModelSatisCliente {
    private $filcgc;
    private $nr;
    private $data;
    private $titulo;
    private $periodo; 
    private $obs;
    
    function getFilcgc() {
        return $this->filcgc;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getData() {
        return $this->data;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getObs() {
        return $this->obs;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }


    
}