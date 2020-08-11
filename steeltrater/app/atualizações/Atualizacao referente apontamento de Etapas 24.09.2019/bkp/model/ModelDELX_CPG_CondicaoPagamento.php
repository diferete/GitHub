<?php

/*
 * Classe que implementa os models da DELX_CPG_CondicaoPagamento
 * 
 * @author Cleverton Hoffmann
 * @since 21/06/2018
 */

class ModelDELX_CPG_CondicaoPagamento {

    private $cpg_codigo;
    private $cpg_descricao;
    private $cpg_numeroparcelas;
    private $cpg_taxaacrescimo;
    private $cpg_taxatabelapedidos;
    private $cpg_tipocondicao;
    private $cpg_acaoparaferiado;
    private $cpg_diapagtoaposvencto;
    private $cpg_textoparcelaavista;
    private $cpg_percentualdesconto;
    private $cpg_databasevencto;
    private $cpg_prazomediocondpagto;
    private $cpg_tipovenctoprincipal;
    private $cpg_margemdecontribuicao;
    private $cpg_diafixovencimento;
    private $cpg_cupom;
    private $cpg_datafixavencimento;
    private $cpg_tipovenctoprincpedcompra;
    private $cpg_valorminimoparcela;

    function getCpg_codigo() {
        return $this->cpg_codigo;
    }

    function getCpg_descricao() {
        return $this->cpg_descricao;
    }

    function getCpg_numeroparcelas() {
        return $this->cpg_numeroparcelas;
    }

    function getCpg_taxaacrescimo() {
        return $this->cpg_taxaacrescimo;
    }

    function getCpg_taxatabelapedidos() {
        return $this->cpg_taxatabelapedidos;
    }

    function getCpg_tipocondicao() {
        return $this->cpg_tipocondicao;
    }

    function getCpg_acaoparaferiado() {
        return $this->cpg_acaoparaferiado;
    }

    function getCpg_diapagtoaposvencto() {
        return $this->cpg_diapagtoaposvencto;
    }

    function getCpg_textoparcelaavista() {
        return $this->cpg_textoparcelaavista;
    }

    function getCpg_percentualdesconto() {
        return $this->cpg_percentualdesconto;
    }

    function getCpg_databasevencto() {
        return $this->cpg_databasevencto;
    }

    function getCpg_prazomediocondpagto() {
        return $this->cpg_prazomediocondpagto;
    }

    function getCpg_tipovenctoprincipal() {
        return $this->cpg_tipovenctoprincipal;
    }

    function getCpg_margemdecontribuicao() {
        return $this->cpg_margemdecontribuicao;
    }

    function getCpg_diafixovencimento() {
        return $this->cpg_diafixovencimento;
    }

    function getCpg_cupom() {
        return $this->cpg_cupom;
    }

    function getCpg_datafixavencimento() {
        return $this->cpg_datafixavencimento;
    }

    function getCpg_tipovenctoprincpedcompra() {
        return $this->cpg_tipovenctoprincpedcompra;
    }

    function getCpg_valorminimoparcela() {
        return $this->cpg_valorminimoparcela;
    }

    function setCpg_codigo($cpg_codigo) {
        $this->cpg_codigo = $cpg_codigo;
    }

    function setCpg_descricao($cpg_descricao) {
        $this->cpg_descricao = $cpg_descricao;
    }

    function setCpg_numeroparcelas($cpg_numeroparcelas) {
        $this->cpg_numeroparcelas = $cpg_numeroparcelas;
    }

    function setCpg_taxaacrescimo($cpg_taxaacrescimo) {
        $this->cpg_taxaacrescimo = $cpg_taxaacrescimo;
    }

    function setCpg_taxatabelapedidos($cpg_taxatabelapedidos) {
        $this->cpg_taxatabelapedidos = $cpg_taxatabelapedidos;
    }

    function setCpg_tipocondicao($cpg_tipocondicao) {
        $this->cpg_tipocondicao = $cpg_tipocondicao;
    }

    function setCpg_acaoparaferiado($cpg_acaoparaferiado) {
        $this->cpg_acaoparaferiado = $cpg_acaoparaferiado;
    }

    function setCpg_diapagtoaposvencto($cpg_diapagtoaposvencto) {
        $this->cpg_diapagtoaposvencto = $cpg_diapagtoaposvencto;
    }

    function setCpg_textoparcelaavista($cpg_textoparcelaavista) {
        $this->cpg_textoparcelaavista = $cpg_textoparcelaavista;
    }

    function setCpg_percentualdesconto($cpg_percentualdesconto) {
        $this->cpg_percentualdesconto = $cpg_percentualdesconto;
    }

    function setCpg_databasevencto($cpg_databasevencto) {
        $this->cpg_databasevencto = $cpg_databasevencto;
    }

    function setCpg_prazomediocondpagto($cpg_prazomediocondpagto) {
        $this->cpg_prazomediocondpagto = $cpg_prazomediocondpagto;
    }

    function setCpg_tipovenctoprincipal($cpg_tipovenctoprincipal) {
        $this->cpg_tipovenctoprincipal = $cpg_tipovenctoprincipal;
    }

    function setCpg_margemdecontribuicao($cpg_margemdecontribuicao) {
        $this->cpg_margemdecontribuicao = $cpg_margemdecontribuicao;
    }

    function setCpg_diafixovencimento($cpg_diafixovencimento) {
        $this->cpg_diafixovencimento = $cpg_diafixovencimento;
    }

    function setCpg_cupom($cpg_cupom) {
        $this->cpg_cupom = $cpg_cupom;
    }

    function setCpg_datafixavencimento($cpg_datafixavencimento) {
        $this->cpg_datafixavencimento = $cpg_datafixavencimento;
    }

    function setCpg_tipovenctoprincpedcompra($cpg_tipovenctoprincpedcompra) {
        $this->cpg_tipovenctoprincpedcompra = $cpg_tipovenctoprincpedcompra;
    }

    function setCpg_valorminimoparcela($cpg_valorminimoparcela) {
        $this->cpg_valorminimoparcela = $cpg_valorminimoparcela;
    }

}
