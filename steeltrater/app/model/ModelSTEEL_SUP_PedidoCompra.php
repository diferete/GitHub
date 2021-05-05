<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_SUP_PedidoCompra {

    private $FIL_Codigo;
    private $SUP_PedidoSeq;
    private $DELX_FIL_Empresa;
    private $SUP_PedidoFornecedor;
    private $SUP_PedidoRepresentante;
    private $SUP_PedidoNegociador;
    private $SUP_PedidoTransportador;
    private $SUP_PedidoSituacao;
    private $SUP_PedidoObservacao;
    private $SUP_PedidoMoeda;
    private $SUP_PedidoMoedaData;
    private $SUP_PedidoMoedaValor;
    private $SUP_PedidoTipo;
    private $SUP_PedidoTipoFrete;
    private $SUP_PedidoVlrFrete;
    private $SUP_PedidoVlrDespesa;
    private $SUP_PedidoVlrSeguro;
    private $SUP_PedidoVlrDesconto;
    private $SUP_PedidoPerDesconto;
    private $SUP_PedidoContrato;
    private $SUP_PedidoNotaAviso;
    private $SUP_PedidoData;
    private $SUP_PedidoUsuario;
    private $SUP_PedidoTipoMovimento;
    private $SUP_PedidoHora;
    private $SUP_PedidoContato;
    private $SUP_PedidoCondicaoPag;
    private $SUP_PedidoDestino;
    private $SUP_PedidoTipoDesconto;
    private $SUP_PedidoValorProduto;
    private $SUP_PedidoValorServico;
    private $SUP_PedidoValorTotal;
    private $SUP_PedidoIdentificador;
    private $SUP_PedidoValorDescontoServico;
    private $SUP_PedidoSeqAprovacao;
    private $SUP_PedidoValorTotalDesconto;
    private $SUP_PedidoMRP;
    private $SUP_PedidoMoedaValorNeg;
    private $SUP_PedidoPessoaEntrega;
    private $SUP_PedidoPessoaEntregaEnd;
    private $SUP_PedidoEntregaObs;
    private $SUP_PedidoSitEnvEmailForn;
    private $SUP_PedidoPessoaFaturamento;
    private $SUP_PedidoPessoaFaturamentoEnd;
    private $SUP_PedidoFaturamentoObs;
    private $SUP_PedidoContratoEntregaFutur;
    private $SUP_PedidoUsuNegacao;
    private $SUP_PedidoDataHoraNegacao;
    private $SUP_PedidoCCTCod;
    private $SUP_PedidoFornecedorEnd;
    private $SUP_PedidoLiberadoAprovacao;
    private $SUP_PedidoFornecedorAssociado;
    private $SUP_PedidoChassi;
    private $SUP_PedidoKM;
    private $SUP_PedidoNSG;
    private $SUP_PedidoTipoControle;
    private $SUP_PedidoTipoPEC;
    private $SUP_PedidoVia;
    private $SUP_PedidoVlrAcrescimo;
    private $SUP_PedidoDataValidade;
    private $SUP_PedidoBxPrevisao;

    /*     * ****************************
      private $SUP_PedidoOrcamento;
      private $SUP_PedidoEnvEmaForn;
      private $SUP_PedidoCondicaoPagDescritiv;
      private $FIN_FormaPagamentoCodigo;
      private $SUP_PedidoUsuarioAprovador;
      private $SUP_PedidoEquipamento;
      private $SUP_PedidoUsuarioResponsavel;
     * ************************************ */
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

    function getFIL_Codigo() {
        return $this->FIL_Codigo;
    }

    function getSUP_PedidoSeq() {
        return $this->SUP_PedidoSeq;
    }

    function getDELX_FIL_Empresa() {
        if (!isset($this->DELX_FIL_Empresa)) {
            $this->DELX_FIL_Empresa = Fabrica::FabricarModel('DELX_FIL_Empresa');
        }
        return $this->DELX_FIL_Empresa;
    }

    function getSUP_PedidoFornecedor() {
        return $this->SUP_PedidoFornecedor;
    }

    function getSUP_PedidoRepresentante() {
        return $this->SUP_PedidoRepresentante;
    }

    function getSUP_PedidoNegociador() {
        return $this->SUP_PedidoNegociador;
    }

    function getSUP_PedidoTransportador() {
        return $this->SUP_PedidoTransportador;
    }

    function getSUP_PedidoSituacao() {
        return $this->SUP_PedidoSituacao;
    }

    function getSUP_PedidoObservacao() {
        return $this->SUP_PedidoObservacao;
    }

    function getSUP_PedidoMoeda() {
        return $this->SUP_PedidoMoeda;
    }

    function getSUP_PedidoMoedaData() {
        return $this->SUP_PedidoMoedaData;
    }

    function getSUP_PedidoMoedaValor() {
        return $this->SUP_PedidoMoedaValor;
    }

    function getSUP_PedidoTipo() {
        return $this->SUP_PedidoTipo;
    }

    function getSUP_PedidoTipoFrete() {
        return $this->SUP_PedidoTipoFrete;
    }

    function getSUP_PedidoVlrFrete() {
        return $this->SUP_PedidoVlrFrete;
    }

    function getSUP_PedidoVlrDespesa() {
        return $this->SUP_PedidoVlrDespesa;
    }

    function getSUP_PedidoVlrSeguro() {
        return $this->SUP_PedidoVlrSeguro;
    }

    function getSUP_PedidoVlrDesconto() {
        return $this->SUP_PedidoVlrDesconto;
    }

    function getSUP_PedidoPerDesconto() {
        return $this->SUP_PedidoPerDesconto;
    }

    function getSUP_PedidoContrato() {
        return $this->SUP_PedidoContrato;
    }

    function getSUP_PedidoNotaAviso() {
        return $this->SUP_PedidoNotaAviso;
    }

    function getSUP_PedidoData() {
        return $this->SUP_PedidoData;
    }

    function getSUP_PedidoUsuario() {
        return $this->SUP_PedidoUsuario;
    }

    function getSUP_PedidoTipoMovimento() {
        return $this->SUP_PedidoTipoMovimento;
    }

    function getSUP_PedidoHora() {
        return $this->SUP_PedidoHora;
    }

    function getSUP_PedidoContato() {
        return $this->SUP_PedidoContato;
    }

    function getSUP_PedidoCondicaoPag() {
        return $this->SUP_PedidoCondicaoPag;
    }

    function getSUP_PedidoDestino() {
        return $this->SUP_PedidoDestino;
    }

    function getSUP_PedidoTipoDesconto() {
        return $this->SUP_PedidoTipoDesconto;
    }

    function getSUP_PedidoValorProduto() {
        return $this->SUP_PedidoValorProduto;
    }

    function getSUP_PedidoValorServico() {
        return $this->SUP_PedidoValorServico;
    }

    function getSUP_PedidoValorTotal() {
        return $this->SUP_PedidoValorTotal;
    }

    function getSUP_PedidoIdentificador() {
        return $this->SUP_PedidoIdentificador;
    }

    function getSUP_PedidoValorDescontoServico() {
        return $this->SUP_PedidoValorDescontoServico;
    }

    function getSUP_PedidoSeqAprovacao() {
        return $this->SUP_PedidoSeqAprovacao;
    }

    function getSUP_PedidoValorTotalDesconto() {
        return $this->SUP_PedidoValorTotalDesconto;
    }

    function getSUP_PedidoMRP() {
        return $this->SUP_PedidoMRP;
    }

    function getSUP_PedidoMoedaValorNeg() {
        return $this->SUP_PedidoMoedaValorNeg;
    }

    function getSUP_PedidoPessoaEntrega() {
        return $this->SUP_PedidoPessoaEntrega;
    }

    function getSUP_PedidoPessoaEntregaEnd() {
        return $this->SUP_PedidoPessoaEntregaEnd;
    }

    function getSUP_PedidoEntregaObs() {
        return $this->SUP_PedidoEntregaObs;
    }

    function getSUP_PedidoSitEnvEmailForn() {
        return $this->SUP_PedidoSitEnvEmailForn;
    }

    function getSUP_PedidoPessoaFaturamento() {
        return $this->SUP_PedidoPessoaFaturamento;
    }

    function getSUP_PedidoPessoaFaturamentoEnd() {
        return $this->SUP_PedidoPessoaFaturamentoEnd;
    }

    function getSUP_PedidoFaturamentoObs() {
        return $this->SUP_PedidoFaturamentoObs;
    }

    function getSUP_PedidoContratoEntregaFutur() {
        return $this->SUP_PedidoContratoEntregaFutur;
    }

    function getSUP_PedidoUsuNegacao() {
        return $this->SUP_PedidoUsuNegacao;
    }

    function getSUP_PedidoDataHoraNegacao() {
        return $this->SUP_PedidoDataHoraNegacao;
    }

    function getSUP_PedidoCCTCod() {
        return $this->SUP_PedidoCCTCod;
    }

    function getSUP_PedidoFornecedorEnd() {
        return $this->SUP_PedidoFornecedorEnd;
    }

    function getSUP_PedidoLiberadoAprovacao() {
        return $this->SUP_PedidoLiberadoAprovacao;
    }

    function getSUP_PedidoFornecedorAssociado() {
        return $this->SUP_PedidoFornecedorAssociado;
    }

    function getSUP_PedidoChassi() {
        return $this->SUP_PedidoChassi;
    }

    function getSUP_PedidoKM() {
        return $this->SUP_PedidoKM;
    }

    function getSUP_PedidoNSG() {
        return $this->SUP_PedidoNSG;
    }

    function getSUP_PedidoTipoControle() {
        return $this->SUP_PedidoTipoControle;
    }

    function getSUP_PedidoTipoPEC() {
        return $this->SUP_PedidoTipoPEC;
    }

    function getSUP_PedidoVia() {
        return $this->SUP_PedidoVia;
    }

    function getSUP_PedidoVlrAcrescimo() {
        return $this->SUP_PedidoVlrAcrescimo;
    }

    function getSUP_PedidoDataValidade() {
        return $this->SUP_PedidoDataValidade;
    }

    function getSUP_PedidoBxPrevisao() {
        return $this->SUP_PedidoBxPrevisao;
    }

    function setFIL_Codigo($FIL_Codigo) {
        $this->FIL_Codigo = $FIL_Codigo;
    }

    function setSUP_PedidoSeq($SUP_PedidoSeq) {
        $this->SUP_PedidoSeq = $SUP_PedidoSeq;
    }

    function setDELX_FIL_Empresa($DELX_FIL_Empresa) {
        $this->DELX_FIL_Empresa = $DELX_FIL_Empresa;
    }

    function setSUP_PedidoFornecedor($SUP_PedidoFornecedor) {
        $this->SUP_PedidoFornecedor = $SUP_PedidoFornecedor;
    }

    function setSUP_PedidoRepresentante($SUP_PedidoRepresentante) {
        $this->SUP_PedidoRepresentante = $SUP_PedidoRepresentante;
    }

    function setSUP_PedidoNegociador($SUP_PedidoNegociador) {
        $this->SUP_PedidoNegociador = $SUP_PedidoNegociador;
    }

    function setSUP_PedidoTransportador($SUP_PedidoTransportador) {
        $this->SUP_PedidoTransportador = $SUP_PedidoTransportador;
    }

    function setSUP_PedidoSituacao($SUP_PedidoSituacao) {
        $this->SUP_PedidoSituacao = $SUP_PedidoSituacao;
    }

    function setSUP_PedidoObservacao($SUP_PedidoObservacao) {
        $this->SUP_PedidoObservacao = $SUP_PedidoObservacao;
    }

    function setSUP_PedidoMoeda($SUP_PedidoMoeda) {
        $this->SUP_PedidoMoeda = $SUP_PedidoMoeda;
    }

    function setSUP_PedidoMoedaData($SUP_PedidoMoedaData) {
        $this->SUP_PedidoMoedaData = $SUP_PedidoMoedaData;
    }

    function setSUP_PedidoMoedaValor($SUP_PedidoMoedaValor) {
        $this->SUP_PedidoMoedaValor = $SUP_PedidoMoedaValor;
    }

    function setSUP_PedidoTipo($SUP_PedidoTipo) {
        $this->SUP_PedidoTipo = $SUP_PedidoTipo;
    }

    function setSUP_PedidoTipoFrete($SUP_PedidoTipoFrete) {
        $this->SUP_PedidoTipoFrete = $SUP_PedidoTipoFrete;
    }

    function setSUP_PedidoVlrFrete($SUP_PedidoVlrFrete) {
        $this->SUP_PedidoVlrFrete = $SUP_PedidoVlrFrete;
    }

    function setSUP_PedidoVlrDespesa($SUP_PedidoVlrDespesa) {
        $this->SUP_PedidoVlrDespesa = $SUP_PedidoVlrDespesa;
    }

    function setSUP_PedidoVlrSeguro($SUP_PedidoVlrSeguro) {
        $this->SUP_PedidoVlrSeguro = $SUP_PedidoVlrSeguro;
    }

    function setSUP_PedidoVlrDesconto($SUP_PedidoVlrDesconto) {
        $this->SUP_PedidoVlrDesconto = $SUP_PedidoVlrDesconto;
    }

    function setSUP_PedidoPerDesconto($SUP_PedidoPerDesconto) {
        $this->SUP_PedidoPerDesconto = $SUP_PedidoPerDesconto;
    }

    function setSUP_PedidoContrato($SUP_PedidoContrato) {
        $this->SUP_PedidoContrato = $SUP_PedidoContrato;
    }

    function setSUP_PedidoNotaAviso($SUP_PedidoNotaAviso) {
        $this->SUP_PedidoNotaAviso = $SUP_PedidoNotaAviso;
    }

    function setSUP_PedidoData($SUP_PedidoData) {
        $this->SUP_PedidoData = $SUP_PedidoData;
    }

    function setSUP_PedidoUsuario($SUP_PedidoUsuario) {
        $this->SUP_PedidoUsuario = $SUP_PedidoUsuario;
    }

    function setSUP_PedidoTipoMovimento($SUP_PedidoTipoMovimento) {
        $this->SUP_PedidoTipoMovimento = $SUP_PedidoTipoMovimento;
    }

    function setSUP_PedidoHora($SUP_PedidoHora) {
        $this->SUP_PedidoHora = $SUP_PedidoHora;
    }

    function setSUP_PedidoContato($SUP_PedidoContato) {
        $this->SUP_PedidoContato = $SUP_PedidoContato;
    }

    function setSUP_PedidoCondicaoPag($SUP_PedidoCondicaoPag) {
        $this->SUP_PedidoCondicaoPag = $SUP_PedidoCondicaoPag;
    }

    function setSUP_PedidoDestino($SUP_PedidoDestino) {
        $this->SUP_PedidoDestino = $SUP_PedidoDestino;
    }

    function setSUP_PedidoTipoDesconto($SUP_PedidoTipoDesconto) {
        $this->SUP_PedidoTipoDesconto = $SUP_PedidoTipoDesconto;
    }

    function setSUP_PedidoValorProduto($SUP_PedidoValorProduto) {
        $this->SUP_PedidoValorProduto = $SUP_PedidoValorProduto;
    }

    function setSUP_PedidoValorServico($SUP_PedidoValorServico) {
        $this->SUP_PedidoValorServico = $SUP_PedidoValorServico;
    }

    function setSUP_PedidoValorTotal($SUP_PedidoValorTotal) {
        $this->SUP_PedidoValorTotal = $SUP_PedidoValorTotal;
    }

    function setSUP_PedidoIdentificador($SUP_PedidoIdentificador) {
        $this->SUP_PedidoIdentificador = $SUP_PedidoIdentificador;
    }

    function setSUP_PedidoValorDescontoServico($SUP_PedidoValorDescontoServico) {
        $this->SUP_PedidoValorDescontoServico = $SUP_PedidoValorDescontoServico;
    }

    function setSUP_PedidoSeqAprovacao($SUP_PedidoSeqAprovacao) {
        $this->SUP_PedidoSeqAprovacao = $SUP_PedidoSeqAprovacao;
    }

    function setSUP_PedidoValorTotalDesconto($SUP_PedidoValorTotalDesconto) {
        $this->SUP_PedidoValorTotalDesconto = $SUP_PedidoValorTotalDesconto;
    }

    function setSUP_PedidoMRP($SUP_PedidoMRP) {
        $this->SUP_PedidoMRP = $SUP_PedidoMRP;
    }

    function setSUP_PedidoMoedaValorNeg($SUP_PedidoMoedaValorNeg) {
        $this->SUP_PedidoMoedaValorNeg = $SUP_PedidoMoedaValorNeg;
    }

    function setSUP_PedidoPessoaEntrega($SUP_PedidoPessoaEntrega) {
        $this->SUP_PedidoPessoaEntrega = $SUP_PedidoPessoaEntrega;
    }

    function setSUP_PedidoPessoaEntregaEnd($SUP_PedidoPessoaEntregaEnd) {
        $this->SUP_PedidoPessoaEntregaEnd = $SUP_PedidoPessoaEntregaEnd;
    }

    function setSUP_PedidoEntregaObs($SUP_PedidoEntregaObs) {
        $this->SUP_PedidoEntregaObs = $SUP_PedidoEntregaObs;
    }

    function setSUP_PedidoSitEnvEmailForn($SUP_PedidoSitEnvEmailForn) {
        $this->SUP_PedidoSitEnvEmailForn = $SUP_PedidoSitEnvEmailForn;
    }

    function setSUP_PedidoPessoaFaturamento($SUP_PedidoPessoaFaturamento) {
        $this->SUP_PedidoPessoaFaturamento = $SUP_PedidoPessoaFaturamento;
    }

    function setSUP_PedidoPessoaFaturamentoEnd($SUP_PedidoPessoaFaturamentoEnd) {
        $this->SUP_PedidoPessoaFaturamentoEnd = $SUP_PedidoPessoaFaturamentoEnd;
    }

    function setSUP_PedidoFaturamentoObs($SUP_PedidoFaturamentoObs) {
        $this->SUP_PedidoFaturamentoObs = $SUP_PedidoFaturamentoObs;
    }

    function setSUP_PedidoContratoEntregaFutur($SUP_PedidoContratoEntregaFutur) {
        $this->SUP_PedidoContratoEntregaFutur = $SUP_PedidoContratoEntregaFutur;
    }

    function setSUP_PedidoUsuNegacao($SUP_PedidoUsuNegacao) {
        $this->SUP_PedidoUsuNegacao = $SUP_PedidoUsuNegacao;
    }

    function setSUP_PedidoDataHoraNegacao($SUP_PedidoDataHoraNegacao) {
        $this->SUP_PedidoDataHoraNegacao = $SUP_PedidoDataHoraNegacao;
    }

    function setSUP_PedidoCCTCod($SUP_PedidoCCTCod) {
        $this->SUP_PedidoCCTCod = $SUP_PedidoCCTCod;
    }

    function setSUP_PedidoFornecedorEnd($SUP_PedidoFornecedorEnd) {
        $this->SUP_PedidoFornecedorEnd = $SUP_PedidoFornecedorEnd;
    }

    function setSUP_PedidoLiberadoAprovacao($SUP_PedidoLiberadoAprovacao) {
        $this->SUP_PedidoLiberadoAprovacao = $SUP_PedidoLiberadoAprovacao;
    }

    function setSUP_PedidoFornecedorAssociado($SUP_PedidoFornecedorAssociado) {
        $this->SUP_PedidoFornecedorAssociado = $SUP_PedidoFornecedorAssociado;
    }

    function setSUP_PedidoChassi($SUP_PedidoChassi) {
        $this->SUP_PedidoChassi = $SUP_PedidoChassi;
    }

    function setSUP_PedidoKM($SUP_PedidoKM) {
        $this->SUP_PedidoKM = $SUP_PedidoKM;
    }

    function setSUP_PedidoNSG($SUP_PedidoNSG) {
        $this->SUP_PedidoNSG = $SUP_PedidoNSG;
    }

    function setSUP_PedidoTipoControle($SUP_PedidoTipoControle) {
        $this->SUP_PedidoTipoControle = $SUP_PedidoTipoControle;
    }

    function setSUP_PedidoTipoPEC($SUP_PedidoTipoPEC) {
        $this->SUP_PedidoTipoPEC = $SUP_PedidoTipoPEC;
    }

    function setSUP_PedidoVia($SUP_PedidoVia) {
        $this->SUP_PedidoVia = $SUP_PedidoVia;
    }

    function setSUP_PedidoVlrAcrescimo($SUP_PedidoVlrAcrescimo) {
        $this->SUP_PedidoVlrAcrescimo = $SUP_PedidoVlrAcrescimo;
    }

    function setSUP_PedidoDataValidade($SUP_PedidoDataValidade) {
        $this->SUP_PedidoDataValidade = $SUP_PedidoDataValidade;
    }

    function setSUP_PedidoBxPrevisao($SUP_PedidoBxPrevisao) {
        $this->SUP_PedidoBxPrevisao = $SUP_PedidoBxPrevisao;
    }

}
