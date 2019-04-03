<?php

/* 
 * Classe que implementa o model da classe SatisClientePesq
 * @author Avanei Martendal 
 * @since 15/01/2018
 */

class ModelSatisClientePesqShow{
    private $filcgc;
    private $nr;
    private $seq;
    private $empcod;
    private $empdes;
    
    private $comercial;
    private $prodrequisito;
    private $prodembalagem;
    private $prodprazo;
    private $geralexpectativa;
    private $geralindica; 
    private $obs;
    private $contato;
    private $email;
    private $emailenv;
    
    function getEmailenv() {
        return $this->emailenv;
    }

    function setEmailenv($emailenv) {
        $this->emailenv = $emailenv;
    }

                
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

        
    function getContato() {
        return $this->contato;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

        
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

                
    function getComercial() {
        return $this->comercial;
    }

    function getProdrequisito() {
        return $this->prodrequisito;
    }

    function getProdembalagem() {
        return $this->prodembalagem;
    }

    function getProdprazo() {
        return $this->prodprazo;
    }

    function getGeralexpectativa() {
        return $this->geralexpectativa;
    }

    function getGeralindica() {
        return $this->geralindica;
    }

    function setComercial($comercial) {
        $this->comercial = $comercial;
    }

    function setProdrequisito($prodrequisito) {
        $this->prodrequisito = $prodrequisito;
    }

    function setProdembalagem($prodembalagem) {
        $this->prodembalagem = $prodembalagem;
    }

    function setProdprazo($prodprazo) {
        $this->prodprazo = $prodprazo;
    }

    function setGeralexpectativa($geralexpectativa) {
        $this->geralexpectativa = $geralexpectativa;
    }

    function setGeralindica($geralindica) {
        $this->geralindica = $geralindica;
    }

    
        
    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }


}

