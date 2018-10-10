<?php

/*
 * Classe que implementa os models da DELX_FRE_TipoFrete
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ModelDELX_FRE_TipoFrete {

    private $fre_tipofretecodigo;
    private $fre_tipofretedescricao;
    private $fre_tipofreteresponsavel;
    private $fre_tipofretepagamento;

    function getFre_tipofretecodigo() {
        return $this->fre_tipofretecodigo;
    }

    function getFre_tipofretedescricao() {
        return $this->fre_tipofretedescricao;
    }

    function getFre_tipofreteresponsavel() {
        return $this->fre_tipofreteresponsavel;
    }

    function getFre_tipofretepagamento() {
        return $this->fre_tipofretepagamento;
    }

    function setFre_tipofretecodigo($fre_tipofretecodigo) {
        $this->fre_tipofretecodigo = $fre_tipofretecodigo;
    }

    function setFre_tipofretedescricao($fre_tipofretedescricao) {
        $this->fre_tipofretedescricao = $fre_tipofretedescricao;
    }

    function setFre_tipofreteresponsavel($fre_tipofreteresponsavel) {
        $this->fre_tipofreteresponsavel = $fre_tipofreteresponsavel;
    }

    function setFre_tipofretepagamento($fre_tipofretepagamento) {
        $this->fre_tipofretepagamento = $fre_tipofretepagamento;
    }

}
