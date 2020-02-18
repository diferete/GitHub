<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelMET_TEC_FavMenu {
    private $usucodigo;
    private $favseq;
    private $favdescricao;
    private $favclasse;
    private $favmetodo;
    private $favordem;
    
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getFavseq() {
        return $this->favseq;
    }

    function getFavdescricao() {
        return $this->favdescricao;
    }

    function getFavclasse() {
        return $this->favclasse;
    }

    function getFavmetodo() {
        return $this->favmetodo;
    }

    function getFavordem() {
        return $this->favordem;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setFavseq($favseq) {
        $this->favseq = $favseq;
    }

    function setFavdescricao($favdescricao) {
        $this->favdescricao = $favdescricao;
    }

    function setFavclasse($favclasse) {
        $this->favclasse = $favclasse;
    }

    function setFavmetodo($favmetodo) {
        $this->favmetodo = $favmetodo;
    }

    function setFavordem($favordem) {
        $this->favordem = $favordem;
    }


}
