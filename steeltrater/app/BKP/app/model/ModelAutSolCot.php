<?php

/* 
 * Model da classe para liberar media de preço
 * @author Avanei Martendal
 * @since 25/07/2016
 */

class ModelAutSolCot {
    private $id;
    private $nr;
    private $tipo;
    private $Pessoa;
    private $media;
    private $codrep;
    
    function getPessoa() {
        if(!isset($this->Pessoa)){
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

        
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getTipo() {
        return $this->tipo;
    }

   

    function getMedia() {
        return $this->media;
    }

    function getCodrep() {
        return $this->codrep;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }


    function setMedia($media) {
        $this->media = $media;
    }

    function setCodrep($codrep) {
        $this->codrep = $codrep;
    }


}