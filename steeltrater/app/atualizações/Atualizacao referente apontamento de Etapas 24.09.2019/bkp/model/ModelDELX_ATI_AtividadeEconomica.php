<?php

/*
 * Classe que implementa os models da ATI_AtividadeEconomica
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class ModelDELX_ATI_AtividadeEconomica {

    private $ati_codigo;
    private $ati_descricao;
    private $ati_atividadeeconomicacodclass;

    function getAti_codigo() {
        return $this->ati_codigo;
    }

    function getAti_descricao() {
        return $this->ati_descricao;
    }

    function getAti_atividadeeconomicacodclass() {
        return $this->ati_atividadeeconomicacodclass;
    }

    function setAti_codigo($ati_codigo) {
        $this->ati_codigo = $ati_codigo;
    }

    function setAti_descricao($ati_descricao) {
        $this->ati_descricao = $ati_descricao;
    }

    function setAti_atividadeeconomicacodclass($ati_atividadeeconomicacodclass) {
        $this->ati_atividadeeconomicacodclass = $ati_atividadeeconomicacodclass;
    }

}
