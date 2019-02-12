<?php

/*
 * Classe que implementa os models 
 * 
 * @author Cleverton Hoffmann
 * @since 29/11/2018
 */

class ModelSTEEL_PCP_PedidoObs {

    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $pdv_pedidoobscodigo;
    private $pdv_pedidoobsdescricao;
    
    function getPdv_pedidofilial() {
        return $this->pdv_pedidofilial;
    }

    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function getPdv_pedidoobscodigo() {
        return $this->pdv_pedidoobscodigo;
    }

    function getPdv_pedidoobsdescricao() {
        return $this->pdv_pedidoobsdescricao;
    }

    function setPdv_pedidofilial($pdv_pedidofilial) {
        $this->pdv_pedidofilial = $pdv_pedidofilial;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

    function setPdv_pedidoobscodigo($pdv_pedidoobscodigo) {
        $this->pdv_pedidoobscodigo = $pdv_pedidoobscodigo;
    }

    function setPdv_pedidoobsdescricao($pdv_pedidoobsdescricao) {
        $this->pdv_pedidoobsdescricao = $pdv_pedidoobsdescricao;
    }   
}