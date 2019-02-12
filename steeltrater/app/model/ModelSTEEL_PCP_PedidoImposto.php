<?php

/*
 * Classe que implementa os models da STEEL_PCP_PedidoImposto
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class ModelSTEEL_PCP_PedidoImposto {

    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $pdv_pedidoimpostocodigo;
    private $PDV_PedidoImpostoBCalculo;
    private $PDV_PedidoImpostoValor;
    private $PDV_PedidoImpostoFiscal;
    private $PDV_PedidoImpostoClasseNF;
    private $PDV_PedidoImpostoClasseFN;
    private $PDV_PedidoImpostoFatura;
    private $PDV_PedidoImpostoParcela;
    
    function getPdv_pedidofilial() {
        return $this->pdv_pedidofilial;
    }

    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function getPdv_pedidoimpostocodigo() {
        return $this->pdv_pedidoimpostocodigo;
    }

    function getPDV_PedidoImpostoBCalculo() {
        return $this->PDV_PedidoImpostoBCalculo;
    }

    function getPDV_PedidoImpostoValor() {
        return $this->PDV_PedidoImpostoValor;
    }

    function getPDV_PedidoImpostoFiscal() {
        return $this->PDV_PedidoImpostoFiscal;
    }

    function getPDV_PedidoImpostoClasseNF() {
        return $this->PDV_PedidoImpostoClasseNF;
    }

    function getPDV_PedidoImpostoClasseFN() {
        return $this->PDV_PedidoImpostoClasseFN;
    }

    function getPDV_PedidoImpostoFatura() {
        return $this->PDV_PedidoImpostoFatura;
    }

    function getPDV_PedidoImpostoParcela() {
        return $this->PDV_PedidoImpostoParcela;
    }

    function setPdv_pedidofilial($pdv_pedidofilial) {
        $this->pdv_pedidofilial = $pdv_pedidofilial;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

    function setPdv_pedidoimpostocodigo($pdv_pedidoimpostocodigo) {
        $this->pdv_pedidoimpostocodigo = $pdv_pedidoimpostocodigo;
    }

    function setPDV_PedidoImpostoBCalculo($PDV_PedidoImpostoBCalculo) {
        $this->PDV_PedidoImpostoBCalculo = $PDV_PedidoImpostoBCalculo;
    }

    function setPDV_PedidoImpostoValor($PDV_PedidoImpostoValor) {
        $this->PDV_PedidoImpostoValor = $PDV_PedidoImpostoValor;
    }

    function setPDV_PedidoImpostoFiscal($PDV_PedidoImpostoFiscal) {
        $this->PDV_PedidoImpostoFiscal = $PDV_PedidoImpostoFiscal;
    }

    function setPDV_PedidoImpostoClasseNF($PDV_PedidoImpostoClasseNF) {
        $this->PDV_PedidoImpostoClasseNF = $PDV_PedidoImpostoClasseNF;
    }

    function setPDV_PedidoImpostoClasseFN($PDV_PedidoImpostoClasseFN) {
        $this->PDV_PedidoImpostoClasseFN = $PDV_PedidoImpostoClasseFN;
    }

    function setPDV_PedidoImpostoFatura($PDV_PedidoImpostoFatura) {
        $this->PDV_PedidoImpostoFatura = $PDV_PedidoImpostoFatura;
    }

    function setPDV_PedidoImpostoParcela($PDV_PedidoImpostoParcela) {
        $this->PDV_PedidoImpostoParcela = $PDV_PedidoImpostoParcela;
    }
            
}