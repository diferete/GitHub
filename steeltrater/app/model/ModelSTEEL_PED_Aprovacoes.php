<?php

/*
 * Implementa a classe model STEEL_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ModelSTEEL_PED_Aprovacoes {

    private $fil_codigo;
    private $sup_pedidoseq;
    private $sup_pedidofornecedor;
    private $sup_pedidorepresentante;
    private $sup_pedidonegociador;
    private $sup_pedidotransportador;
    private $sup_pedidosituacao;
    private $sup_pedidoobservacao;
    private $sup_pedidomoeda;
    private $sup_pedidomoedadata;
    private $sup_pedidomoedavalor;
    private $sup_pedidotipo;
    private $sup_pedidotipofrete;
    private $sup_pedidovlrfrete;
    private $sup_pedidovlrdespesa;
    private $sup_pedidovlrseguro;
    private $sup_pedidovlrdesconto;
    private $sup_pedidoperdesconto;
    private $sup_pedidocontrato;
    private $sup_pedidonotaaviso;
    private $sup_pedidodata;
    private $sup_pedidousuario;
    private $sup_pedidotipomovimento;
    private $sup_pedidohora;
    private $sup_pedidocontato;
    private $sup_pedidocondicaopag;
    private $sup_pedidodestino;
    private $sup_pedidotipodesconto;
    private $sup_pedidovalorproduto;
    private $sup_pedidovalorservico;
    private $sup_pedidovalortotal;
    private $sup_pedidoidentificador;
    private $sup_pedidovalordescontoservico;
    private $sup_pedidoseqaprovacao;
    private $sup_pedidovalortotaldesconto;
    private $sup_pedidomrp;
    private $sup_pedidomoedavalorneg;
    private $sup_pedidopessoaentrega;
    private $sup_pedidopessoaentregaend;
    private $sup_pedidoentregaobs;
    private $sup_pedidositenvemailforn;
    private $sup_pedidopessoafaturamento;
    private $sup_pedidopessoafaturamentoend;
    private $sup_pedidofaturamentoobs;
    private $sup_pedidocontratoentregafutur;
    private $sup_pedidousunegacao;
    private $sup_pedidodatahoranegacao;
    private $sup_pedidocctcod;
    private $sup_pedidofornecedorend;
    private $sup_pedidoliberadoaprovacao;
    private $sup_pedidofornecedorassociado;
    private $sup_pedidochassi;
    private $sup_pedidokm;
    private $sup_pedidonsg;
    private $sup_pedidotipocontrole;
    private $sup_pedidotipopec;
    private $sup_pedidovia;
    private $sup_pedidovlracrescimo;
    private $sup_pedidodatavalidade;
    private $sup_pedidobxprevisao;
    private $DELX_CAD_Pessoa;

    function getDELX_CAD_Pessoa() {
        if (!isset($this->DELX_CAD_Pessoa)) {
            $this->DELX_CAD_Pessoa = Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa;
    }

    function setDELX_CAD_Pessoa($DELX_CAD_Pessoa) {
        $this->DELX_CAD_Pessoa = $DELX_CAD_Pessoa;
    }

    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

    function getSup_pedidoseq() {
        return $this->sup_pedidoseq;
    }

    function setSup_pedidoseq($sup_pedidoseq) {
        $this->sup_pedidoseq = $sup_pedidoseq;
    }

    function getSup_pedidofornecedor() {
        return $this->sup_pedidofornecedor;
    }

    function setSup_pedidofornecedor($sup_pedidofornecedor) {
        $this->sup_pedidofornecedor = $sup_pedidofornecedor;
    }

    function getSup_pedidorepresentante() {
        return $this->sup_pedidorepresentante;
    }

    function setSup_pedidorepresentante($sup_pedidorepresentante) {
        $this->sup_pedidorepresentante = $sup_pedidorepresentante;
    }

    function getSup_pedidonegociador() {
        return $this->sup_pedidonegociador;
    }

    function setSup_pedidonegociador($sup_pedidonegociador) {
        $this->sup_pedidonegociador = $sup_pedidonegociador;
    }

    function getSup_pedidotransportador() {
        return $this->sup_pedidotransportador;
    }

    function setSup_pedidotransportador($sup_pedidotransportador) {
        $this->sup_pedidotransportador = $sup_pedidotransportador;
    }

    function getSup_pedidosituacao() {
        return $this->sup_pedidosituacao;
    }

    function setSup_pedidosituacao($sup_pedidosituacao) {
        $this->sup_pedidosituacao = $sup_pedidosituacao;
    }

    function getSup_pedidoobservacao() {
        return $this->sup_pedidoobservacao;
    }

    function setSup_pedidoobservacao($sup_pedidoobservacao) {
        $this->sup_pedidoobservacao = $sup_pedidoobservacao;
    }

    function getSup_pedidomoeda() {
        return $this->sup_pedidomoeda;
    }

    function setSup_pedidomoeda($sup_pedidomoeda) {
        $this->sup_pedidomoeda = $sup_pedidomoeda;
    }

    function getSup_pedidomoedadata() {
        return $this->sup_pedidomoedadata;
    }

    function setSup_pedidomoedadata($sup_pedidomoedadata) {
        $this->sup_pedidomoedadata = $sup_pedidomoedadata;
    }

    function getSup_pedidomoedavalor() {
        return $this->sup_pedidomoedavalor;
    }

    function setSup_pedidomoedavalor($sup_pedidomoedavalor) {
        $this->sup_pedidomoedavalor = $sup_pedidomoedavalor;
    }

    function getSup_pedidotipo() {
        return $this->sup_pedidotipo;
    }

    function setSup_pedidotipo($sup_pedidotipo) {
        $this->sup_pedidotipo = $sup_pedidotipo;
    }

    function getSup_pedidotipofrete() {
        return $this->sup_pedidotipofrete;
    }

    function setSup_pedidotipofrete($sup_pedidotipofrete) {
        $this->sup_pedidotipofrete = $sup_pedidotipofrete;
    }

    function getSup_pedidovlrfrete() {
        return $this->sup_pedidovlrfrete;
    }

    function setSup_pedidovlrfrete($sup_pedidovlrfrete) {
        $this->sup_pedidovlrfrete = $sup_pedidovlrfrete;
    }

    function getSup_pedidovlrdespesa() {
        return $this->sup_pedidovlrdespesa;
    }

    function setSup_pedidovlrdespesa($sup_pedidovlrdespesa) {
        $this->sup_pedidovlrdespesa = $sup_pedidovlrdespesa;
    }

    function getSup_pedidovlrseguro() {
        return $this->sup_pedidovlrseguro;
    }

    function setSup_pedidovlrseguro($sup_pedidovlrseguro) {
        $this->sup_pedidovlrseguro = $sup_pedidovlrseguro;
    }

    function getSup_pedidovlrdesconto() {
        return $this->sup_pedidovlrdesconto;
    }

    function setSup_pedidovlrdesconto($sup_pedidovlrdesconto) {
        $this->sup_pedidovlrdesconto = $sup_pedidovlrdesconto;
    }

    function getSup_pedidoperdesconto() {
        return $this->sup_pedidoperdesconto;
    }

    function setSup_pedidoperdesconto($sup_pedidoperdesconto) {
        $this->sup_pedidoperdesconto = $sup_pedidoperdesconto;
    }

    function getSup_pedidocontrato() {
        return $this->sup_pedidocontrato;
    }

    function setSup_pedidocontrato($sup_pedidocontrato) {
        $this->sup_pedidocontrato = $sup_pedidocontrato;
    }

    function getSup_pedidonotaaviso() {
        return $this->sup_pedidonotaaviso;
    }

    function setSup_pedidonotaaviso($sup_pedidonotaaviso) {
        $this->sup_pedidonotaaviso = $sup_pedidonotaaviso;
    }

    function getSup_pedidodata() {
        return $this->sup_pedidodata;
    }

    function setSup_pedidodata($sup_pedidodata) {
        $this->sup_pedidodata = $sup_pedidodata;
    }

    function getSup_pedidousuario() {
        return $this->sup_pedidousuario;
    }

    function setSup_pedidousuario($sup_pedidousuario) {
        $this->sup_pedidousuario = $sup_pedidousuario;
    }

    function getSup_pedidotipomovimento() {
        return $this->sup_pedidotipomovimento;
    }

    function setSup_pedidotipomovimento($sup_pedidotipomovimento) {
        $this->sup_pedidotipomovimento = $sup_pedidotipomovimento;
    }

    function getSup_pedidohora() {
        return $this->sup_pedidohora;
    }

    function setSup_pedidohora($sup_pedidohora) {
        $this->sup_pedidohora = $sup_pedidohora;
    }

    function getSup_pedidocontato() {
        return $this->sup_pedidocontato;
    }

    function setSup_pedidocontato($sup_pedidocontato) {
        $this->sup_pedidocontato = $sup_pedidocontato;
    }

    function getSup_pedidocondicaopag() {
        return $this->sup_pedidocondicaopag;
    }

    function setSup_pedidocondicaopag($sup_pedidocondicaopag) {
        $this->sup_pedidocondicaopag = $sup_pedidocondicaopag;
    }

    function getSup_pedidodestino() {
        return $this->sup_pedidodestino;
    }

    function setSup_pedidodestino($sup_pedidodestino) {
        $this->sup_pedidodestino = $sup_pedidodestino;
    }

    function getSup_pedidotipodesconto() {
        return $this->sup_pedidotipodesconto;
    }

    function setSup_pedidotipodesconto($sup_pedidotipodesconto) {
        $this->sup_pedidotipodesconto = $sup_pedidotipodesconto;
    }

    function getSup_pedidovalorproduto() {
        return $this->sup_pedidovalorproduto;
    }

    function setSup_pedidovalorproduto($sup_pedidovalorproduto) {
        $this->sup_pedidovalorproduto = $sup_pedidovalorproduto;
    }

    function getSup_pedidovalorservico() {
        return $this->sup_pedidovalorservico;
    }

    function setSup_pedidovalorservico($sup_pedidovalorservico) {
        $this->sup_pedidovalorservico = $sup_pedidovalorservico;
    }

    function getSup_pedidovalortotal() {
        return $this->sup_pedidovalortotal;
    }

    function setSup_pedidovalortotal($sup_pedidovalortotal) {
        $this->sup_pedidovalortotal = $sup_pedidovalortotal;
    }

    function getSup_pedidoidentificador() {
        return $this->sup_pedidoidentificador;
    }

    function setSup_pedidoidentificador($sup_pedidoidentificador) {
        $this->sup_pedidoidentificador = $sup_pedidoidentificador;
    }

    function getSup_pedidovalordescontoservico() {
        return $this->sup_pedidovalordescontoservico;
    }

    function setSup_pedidovalordescontoservico($sup_pedidovalordescontoservico) {
        $this->sup_pedidovalordescontoservico = $sup_pedidovalordescontoservico;
    }

    function getSup_pedidoseqaprovacao() {
        return $this->sup_pedidoseqaprovacao;
    }

    function setSup_pedidoseqaprovacao($sup_pedidoseqaprovacao) {
        $this->sup_pedidoseqaprovacao = $sup_pedidoseqaprovacao;
    }

    function getSup_pedidovalortotaldesconto() {
        return $this->sup_pedidovalortotaldesconto;
    }

    function setSup_pedidovalortotaldesconto($sup_pedidovalortotaldesconto) {
        $this->sup_pedidovalortotaldesconto = $sup_pedidovalortotaldesconto;
    }

    function getSup_pedidomrp() {
        return $this->sup_pedidomrp;
    }

    function setSup_pedidomrp($sup_pedidomrp) {
        $this->sup_pedidomrp = $sup_pedidomrp;
    }

    function getSup_pedidomoedavalorneg() {
        return $this->sup_pedidomoedavalorneg;
    }

    function setSup_pedidomoedavalorneg($sup_pedidomoedavalorneg) {
        $this->sup_pedidomoedavalorneg = $sup_pedidomoedavalorneg;
    }

    function getSup_pedidopessoaentrega() {
        return $this->sup_pedidopessoaentrega;
    }

    function setSup_pedidopessoaentrega($sup_pedidopessoaentrega) {
        $this->sup_pedidopessoaentrega = $sup_pedidopessoaentrega;
    }

    function getSup_pedidopessoaentregaend() {
        return $this->sup_pedidopessoaentregaend;
    }

    function setSup_pedidopessoaentregaend($sup_pedidopessoaentregaend) {
        $this->sup_pedidopessoaentregaend = $sup_pedidopessoaentregaend;
    }

    function getSup_pedidoentregaobs() {
        return $this->sup_pedidoentregaobs;
    }

    function setSup_pedidoentregaobs($sup_pedidoentregaobs) {
        $this->sup_pedidoentregaobs = $sup_pedidoentregaobs;
    }

    function getSup_pedidositenvemailforn() {
        return $this->sup_pedidositenvemailforn;
    }

    function setSup_pedidositenvemailforn($sup_pedidositenvemailforn) {
        $this->sup_pedidositenvemailforn = $sup_pedidositenvemailforn;
    }

    function getSup_pedidopessoafaturamento() {
        return $this->sup_pedidopessoafaturamento;
    }

    function setSup_pedidopessoafaturamento($sup_pedidopessoafaturamento) {
        $this->sup_pedidopessoafaturamento = $sup_pedidopessoafaturamento;
    }

    function getSup_pedidopessoafaturamentoend() {
        return $this->sup_pedidopessoafaturamentoend;
    }

    function setSup_pedidopessoafaturamentoend($sup_pedidopessoafaturamentoend) {
        $this->sup_pedidopessoafaturamentoend = $sup_pedidopessoafaturamentoend;
    }

    function getSup_pedidofaturamentoobs() {
        return $this->sup_pedidofaturamentoobs;
    }

    function setSup_pedidofaturamentoobs($sup_pedidofaturamentoobs) {
        $this->sup_pedidofaturamentoobs = $sup_pedidofaturamentoobs;
    }

    function getSup_pedidocontratoentregafutur() {
        return $this->sup_pedidocontratoentregafutur;
    }

    function setSup_pedidocontratoentregafutur($sup_pedidocontratoentregafutur) {
        $this->sup_pedidocontratoentregafutur = $sup_pedidocontratoentregafutur;
    }

    function getSup_pedidousunegacao() {
        return $this->sup_pedidousunegacao;
    }

    function setSup_pedidousunegacao($sup_pedidousunegacao) {
        $this->sup_pedidousunegacao = $sup_pedidousunegacao;
    }

    function getSup_pedidodatahoranegacao() {
        return $this->sup_pedidodatahoranegacao;
    }

    function setSup_pedidodatahoranegacao($sup_pedidodatahoranegacao) {
        $this->sup_pedidodatahoranegacao = $sup_pedidodatahoranegacao;
    }

    function getSup_pedidocctcod() {
        return $this->sup_pedidocctcod;
    }

    function setSup_pedidocctcod($sup_pedidocctcod) {
        $this->sup_pedidocctcod = $sup_pedidocctcod;
    }

    function getSup_pedidofornecedorend() {
        return $this->sup_pedidofornecedorend;
    }

    function setSup_pedidofornecedorend($sup_pedidofornecedorend) {
        $this->sup_pedidofornecedorend = $sup_pedidofornecedorend;
    }

    function getSup_pedidoliberadoaprovacao() {
        return $this->sup_pedidoliberadoaprovacao;
    }

    function setSup_pedidoliberadoaprovacao($sup_pedidoliberadoaprovacao) {
        $this->sup_pedidoliberadoaprovacao = $sup_pedidoliberadoaprovacao;
    }

    function getSup_pedidofornecedorassociado() {
        return $this->sup_pedidofornecedorassociado;
    }

    function setSup_pedidofornecedorassociado($sup_pedidofornecedorassociado) {
        $this->sup_pedidofornecedorassociado = $sup_pedidofornecedorassociado;
    }

    function getSup_pedidochassi() {
        return $this->sup_pedidochassi;
    }

    function setSup_pedidochassi($sup_pedidochassi) {
        $this->sup_pedidochassi = $sup_pedidochassi;
    }

    function getSup_pedidokm() {
        return $this->sup_pedidokm;
    }

    function setSup_pedidokm($sup_pedidokm) {
        $this->sup_pedidokm = $sup_pedidokm;
    }

    function getSup_pedidonsg() {
        return $this->sup_pedidonsg;
    }

    function setSup_pedidonsg($sup_pedidonsg) {
        $this->sup_pedidonsg = $sup_pedidonsg;
    }

    function getSup_pedidotipocontrole() {
        return $this->sup_pedidotipocontrole;
    }

    function setSup_pedidotipocontrole($sup_pedidotipocontrole) {
        $this->sup_pedidotipocontrole = $sup_pedidotipocontrole;
    }

    function getSup_pedidotipopec() {
        return $this->sup_pedidotipopec;
    }

    function setSup_pedidotipopec($sup_pedidotipopec) {
        $this->sup_pedidotipopec = $sup_pedidotipopec;
    }

    function getSup_pedidovia() {
        return $this->sup_pedidovia;
    }

    function setSup_pedidovia($sup_pedidovia) {
        $this->sup_pedidovia = $sup_pedidovia;
    }

    function getSup_pedidovlracrescimo() {
        return $this->sup_pedidovlracrescimo;
    }

    function setSup_pedidovlracrescimo($sup_pedidovlracrescimo) {
        $this->sup_pedidovlracrescimo = $sup_pedidovlracrescimo;
    }

    function getSup_pedidodatavalidade() {
        return $this->sup_pedidodatavalidade;
    }

    function setSup_pedidodatavalidade($sup_pedidodatavalidade) {
        $this->sup_pedidodatavalidade = $sup_pedidodatavalidade;
    }

    function getSup_pedidobxprevisao() {
        return $this->sup_pedidobxprevisao;
    }

    function setSup_pedidobxprevisao($sup_pedidobxprevisao) {
        $this->sup_pedidobxprevisao = $sup_pedidobxprevisao;
    }

}
