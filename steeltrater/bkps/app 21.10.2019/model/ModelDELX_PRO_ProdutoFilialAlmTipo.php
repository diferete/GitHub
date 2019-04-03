<?php

/*
 * Classe que implementa os models da DELX_PRO_ProdutoFilialAlmTipo
 * 
 * @author Cleverton Hoffmann
 * @since 24/09/2018
 */

class ModelDELX_PRO_ProdutoFilialAlmTipo {

    private $est_almoxarifadocodigo;
    private $est_almoxarifadodescricao;
    private $est_almoxarifadosigla;
    private $est_almoxarifadotipo;
 
    function getEst_almoxarifadocodigo() {
        return $this->est_almoxarifadocodigo;
    }

    function getEst_almoxarifadodescricao() {
        return $this->est_almoxarifadodescricao;
    }

    function getEst_almoxarifadosigla() {
        return $this->est_almoxarifadosigla;
    }

    function getEst_almoxarifadotipo() {
        return $this->est_almoxarifadotipo;
    }

    function setEst_almoxarifadocodigo($est_almoxarifadocodigo) {
        $this->est_almoxarifadocodigo = $est_almoxarifadocodigo;
    }

    function setEst_almoxarifadodescricao($est_almoxarifadodescricao) {
        $this->est_almoxarifadodescricao = $est_almoxarifadodescricao;
    }

    function setEst_almoxarifadosigla($est_almoxarifadosigla) {
        $this->est_almoxarifadosigla = $est_almoxarifadosigla;
    }

    function setEst_almoxarifadotipo($est_almoxarifadotipo) {
        $this->est_almoxarifadotipo = $est_almoxarifadotipo;
    }
}
