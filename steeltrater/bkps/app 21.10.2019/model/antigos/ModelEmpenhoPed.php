<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelEmpenhoPed {
    private $pdvnro;
    private $empcod;
    private $total;
    private $pdvdtentre;
    private $pdvemissao;
    private $situaca;
    private $empdes;
    
    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

        
    function getPdvdtentre() {
        return $this->pdvdtentre;
    }

    function setPdvdtentre($pdvdtentre) {
        $this->pdvdtentre = $pdvdtentre;
    }

        
    function getPdvnro() {
        return $this->pdvnro;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getTotal() {
        return $this->total;
    }

   
    function getPdvemissao() {
        return $this->pdvemissao;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function setPdvnro($pdvnro) {
        $this->pdvnro = $pdvnro;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    

    function setPdvemissao($pdvemissao) {
        $this->pdvemissao = $pdvemissao;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

}
