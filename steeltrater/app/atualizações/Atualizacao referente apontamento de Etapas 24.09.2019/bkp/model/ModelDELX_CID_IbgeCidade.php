<?php

/*
 * Classe que implementa os models da DELX_CID_IbgeCidade
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ModelDELX_CID_IbgeCidade {

    private $cid_ibgecidadecodigo;
    private $cid_ibgecidadedescricao;

    function getCid_ibgecidadecodigo() {
        return $this->cid_ibgecidadecodigo;
    }

    function getCid_ibgecidadedescricao() {
        return $this->cid_ibgecidadedescricao;
    }

    function setCid_ibgecidadecodigo($cid_ibgecidadecodigo) {
        $this->cid_ibgecidadecodigo = $cid_ibgecidadecodigo;
    }

    function setCid_ibgecidadedescricao($cid_ibgecidadedescricao) {
        $this->cid_ibgecidadedescricao = $cid_ibgecidadedescricao;
    }
}
