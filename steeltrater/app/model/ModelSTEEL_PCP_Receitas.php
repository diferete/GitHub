<?php

/* 
 * Classe que implementa model das receitas das ofs
 * 
 * @author Avanei Martendal
 * @since 15/16/2018
 * 
 */

class ModelSTEEL_PCP_Receitas {
    private $cod;
    private $data;
    private $peca;
    private $material;
    private $classe;
    private $dureza;
    private $bitola;
    private $metanol;
    private $oxigenio;
    private $nitrogenio;
    private $amonia;
    private $glp;
    private $co;
    private $carbono;
    private $imagem;
    private $temprev;
    
    function getTemprev() {
        return $this->temprev;
    }

    function setTemprev($temprev) {
        $this->temprev = $temprev;
    }

        
    function getCod() {
        return $this->cod;
    }

    function getData() {
        return $this->data;
    }

    function getPeca() {
        return $this->peca;
    }

    function getMaterial() {
        return $this->material;
    }

    function getClasse() {
        return $this->classe;
    }

    function getDureza() {
        return $this->dureza;
    }

    function getBitola() {
        return $this->bitola;
    }

    function getMetanol() {
        return $this->metanol;
    }

    function getOxigenio() {
        return $this->oxigenio;
    }

    function getNitrogenio() {
        return $this->nitrogenio;
    }

    function getAmonia() {
        return $this->amonia;
    }

    function getGlp() {
        return $this->glp;
    }

    function getCo() {
        return $this->co;
    }

    function getCarbono() {
        return $this->carbono;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setPeca($peca) {
        $this->peca = $peca;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

    function setDureza($dureza) {
        $this->dureza = $dureza;
    }

    function setBitola($bitola) {
        $this->bitola = $bitola;
    }

    function setMetanol($metanol) {
        $this->metanol = $metanol;
    }

    function setOxigenio($oxigenio) {
        $this->oxigenio = $oxigenio;
    }

    function setNitrogenio($nitrogenio) {
        $this->nitrogenio = $nitrogenio;
    }

    function setAmonia($amonia) {
        $this->amonia = $amonia;
    }

    function setGlp($glp) {
        $this->glp = $glp;
    }

    function setCo($co) {
        $this->co = $co;
    }

    function setCarbono($carbono) {
        $this->carbono = $carbono;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    


}