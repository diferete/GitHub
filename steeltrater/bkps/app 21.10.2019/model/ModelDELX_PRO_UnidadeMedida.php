<?php

/*
 * Classe que implementa os models da DELX_PRO_UnidadeMedida
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ModelDELX_PRO_UnidadeMedida {

    private $pro_unidademedida;
    private $pro_unidademedidadescricao;
    private $pro_unidademedidarf;
    private $pro_unidademedidamercosul;
    private $pro_unidademedidatipocalc;
    private $pro_unidademedidacasasdec;

    function getPro_unidademedida() {
        return $this->pro_unidademedida;
    }

    function getPro_unidademedidadescricao() {
        return $this->pro_unidademedidadescricao;
    }

    function getPro_unidademedidarf() {
        return $this->pro_unidademedidarf;
    }

    function getPro_unidademedidamercosul() {
        return $this->pro_unidademedidamercosul;
    }

    function getPro_unidademedidatipocalc() {
        return $this->pro_unidademedidatipocalc;
    }

    function getPro_unidademedidacasasdec() {
        return $this->pro_unidademedidacasasdec;
    }

    function setPro_unidademedida($pro_unidademedida) {
        $this->pro_unidademedida = $pro_unidademedida;
    }

    function setPro_unidademedidadescricao($pro_unidademedidadescricao) {
        $this->pro_unidademedidadescricao = $pro_unidademedidadescricao;
    }

    function setPro_unidademedidarf($pro_unidademedidarf) {
        $this->pro_unidademedidarf = $pro_unidademedidarf;
    }

    function setPro_unidademedidamercosul($pro_unidademedidamercosul) {
        $this->pro_unidademedidamercosul = $pro_unidademedidamercosul;
    }

    function setPro_unidademedidatipocalc($pro_unidademedidatipocalc) {
        $this->pro_unidademedidatipocalc = $pro_unidademedidatipocalc;
    }

    function setPro_unidademedidacasasdec($pro_unidademedidacasasdec) {
        $this->pro_unidademedidacasasdec = $pro_unidademedidacasasdec;
    }

}
