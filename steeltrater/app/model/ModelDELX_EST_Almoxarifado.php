<?php

/* 
 * Classe que implementa os models da DELX_EST_Almoxarifado
 * 
 * @author  Cleverton Hoffmann
 * @since 23/10/2018
 */

class ModelDELX_EST_Almoxarifado{
    
    private $est_almoxarifadocodigo;
    private $est_almoxarifadodescricao;
    
    function getEst_almoxarifadocodigo() {
        return $this->est_almoxarifadocodigo;
    }

    function getEst_almoxarifadodescricao() {
        return $this->est_almoxarifadodescricao;
    }

    function setEst_almoxarifadocodigo($est_almoxarifadocodigo) {
        $this->est_almoxarifadocodigo = $est_almoxarifadocodigo;
    }

    function setEst_almoxarifadodescricao($est_almoxarifadodescricao) {
        $this->est_almoxarifadodescricao = $est_almoxarifadodescricao;
    }

}