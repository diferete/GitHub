<?php

/*
 * 
 * @author Alexandre W de Souza
 * @sice 25/09/2018 
 */

class ModelDELX_PRO_Produtotipograde {

    private $pro_codigo;
    private $pro_tipogradecodigo;
    private $pro_produtotipogradedtbloq;
    private $pro_produtotipogradeobrigatori;

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getPro_tipogradecodigo() {
        return $this->pro_tipogradecodigo;
    }

    function getPro_produtotipogradedtbloq() {
        return $this->pro_produtotipogradedtbloq;
    }

    function getPro_produtotipogradeobrigatori() {
        return $this->pro_produtotipogradeobrigatori;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setPro_tipogradecodigo($pro_tipogradecodigo) {
        $this->pro_tipogradecodigo = $pro_tipogradecodigo;
    }

    function setPro_produtotipogradedtbloq($pro_produtotipogradedtbloq) {
        $this->pro_produtotipogradedtbloq = $pro_produtotipogradedtbloq;
    }

    function setPro_produtotipogradeobrigatori($pro_produtotipogradeobrigatori) {
        $this->pro_produtotipogradeobrigatori = $pro_produtotipogradeobrigatori;
    }

}
