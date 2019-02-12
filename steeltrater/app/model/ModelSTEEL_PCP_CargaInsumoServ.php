<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_CargaInsumoServ
 * 
 * @author Avanei Martendal
 * @since 10/01/2019
 */

class ModelSTEEL_PCP_CargaInsumoServ {
    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $pdv_pedidoitemseq;
    private $pdv_insserv;
    private $op;
    
    function getOp() {
        return $this->op;
    }

    function setOp($op) {
        $this->op = $op;
    }

        
    function getPdv_pedidofilial() {
        return $this->pdv_pedidofilial;
    }

    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function getPdv_pedidoitemseq() {
        return $this->pdv_pedidoitemseq;
    }

    function getPdv_insserv() {
        return $this->pdv_insserv;
    }

    function setPdv_pedidofilial($pdv_pedidofilial) {
        $this->pdv_pedidofilial = $pdv_pedidofilial;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

    function setPdv_pedidoitemseq($pdv_pedidoitemseq) {
        $this->pdv_pedidoitemseq = $pdv_pedidoitemseq;
    }

    function setPdv_insserv($pdv_insserv) {
        $this->pdv_insserv = $pdv_insserv;
    }


    
}