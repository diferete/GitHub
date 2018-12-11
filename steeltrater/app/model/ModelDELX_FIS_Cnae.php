<?php

/*
 * Classe que implementa os models da DELX_FIS_Cnae
 * 
 * @author Cleverton Hoffmann
 * @since 26/10/2018
 */

class ModelDELX_FIS_Cnae {

    private $FIS_CNAECodigo;
    private $FIS_CNAEDescricao;
    private $FIS_CNAERetencao;
    
    function getFIS_CNAECodigo() {
        return $this->FIS_CNAECodigo;
    }

    function getFIS_CNAEDescricao() {
        return $this->FIS_CNAEDescricao;
    }

    function getFIS_CNAERetencao() {
        return $this->FIS_CNAERetencao;
    }

    function setFIS_CNAECodigo($FIS_CNAECodigo) {
        $this->FIS_CNAECodigo = $FIS_CNAECodigo;
    }

    function setFIS_CNAEDescricao($FIS_CNAEDescricao) {
        $this->FIS_CNAEDescricao = $FIS_CNAEDescricao;
    }

    function setFIS_CNAERetencao($FIS_CNAERetencao) {
        $this->FIS_CNAERetencao = $FIS_CNAERetencao;
    }
    
}