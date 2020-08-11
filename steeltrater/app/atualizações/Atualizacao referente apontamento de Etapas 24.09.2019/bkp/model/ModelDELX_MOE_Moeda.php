<?php

/*
 * Classe que implementa os models da DELX_MOE_Moeda
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ModelDELX_MOE_Moeda {

    private $moe_codigo;
    private $moe_descricao;
    private $moe_padrao;
    private $moe_simbolo;
    private $moe_descricaosingular;
    private $moe_descricaoplural;

    function getMoe_codigo() {
        return $this->moe_codigo;
    }

    function getMoe_descricao() {
        return $this->moe_descricao;
    }

    function getMoe_padrao() {
        return $this->moe_padrao;
    }

    function getMoe_simbolo() {
        return $this->moe_simbolo;
    }

    function getMoe_descricaosingular() {
        return $this->moe_descricaosingular;
    }

    function getMoe_descricaoplural() {
        return $this->moe_descricaoplural;
    }

    function setMoe_codigo($moe_codigo) {
        $this->moe_codigo = $moe_codigo;
    }

    function setMoe_descricao($moe_descricao) {
        $this->moe_descricao = $moe_descricao;
    }

    function setMoe_padrao($moe_padrao) {
        $this->moe_padrao = $moe_padrao;
    }

    function setMoe_simbolo($moe_simbolo) {
        $this->moe_simbolo = $moe_simbolo;
    }

    function setMoe_descricaosingular($moe_descricaosingular) {
        $this->moe_descricaosingular = $moe_descricaosingular;
    }

    function setMoe_descricaoplural($moe_descricaoplural) {
        $this->moe_descricaoplural = $moe_descricaoplural;
    }

}
