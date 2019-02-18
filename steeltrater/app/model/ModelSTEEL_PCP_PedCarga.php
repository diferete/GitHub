<?php

/*
 * Classe que implementa os models da STEEL_PCP_PedCarga
 * 
 * @author Cleverton Hoffmann
 * @since 20/11/2018
 */

class ModelSTEEL_PCP_PedCarga{
    
    private $pdv_pedidofilial;
    private $pdv_pedidocodigo;
    private $PDV_PedidoEmpCodigo;
    
    private $DELX_CAD_Pessoa;
    
    private $PDV_PedidoObsProducao;
    private $PDV_PedidoObs;
    private $PDV_PedidoObsFinanceiras;
    private $PDV_PedidoDataEmissao;
    private $PDV_PedidoTransportadorCodigo;
    private $PDV_PedidoRedespachoCodigo;
    private $PDV_PedidoFreteRedespacho;
    private $PDV_PedidoTransportadorPlaca;
    private $PDV_PedidoCamChegada;
    private $PDV_PedidoCamSaida;
    private $PDV_PedidoCamEntrada;
    private $PDV_PedidoFreteValor;
    private $PDV_PedidoOrdemCompra;
    private $PDV_PedidoOrdemCompraData;
    private $PDV_PedidoCpgTaxa;
    private $PDV_PedidoDescontoPerc;
    private $PDV_PedidoDescontoValor;
    private $PDV_PedidoDataDigitacao;
    private $PDV_PedidoDataEntrega;
    private $PDV_PedidoSituacao;
    private $PDV_PedidoAprovacao;
    private $PDV_PedidoSomaFrete;
    private $PDV_PedidoSomaST;
    private $PDV_PedidoEndereco;
    private $PDV_PedidoLocalEntrega;
    private $PDV_PedidoConsumidorFinal;
    private $PDV_PedidoAreaRestrita;
    private $PDV_PedidoTipoPagamento;
    private $PDV_PedidoBancoDeposito;
    private $PDV_PedidoComissaoPerc;
    private $PDV_PedidoTipoCod;
    private $PDV_PedidoValidade;
    private $PDV_PedidoBancoCobranca;
    private $PDV_PedidoCarteiraCobranca;
    private $PDV_PedidoValorDevolucao;
    private $PDV_PedidoDataProducao;
    private $PDV_PedidoEspecie;
    private $PDV_PedidoOrcamentoAno;
    private $PDV_PedidoOrcamentoNumero;
    private $PDV_PedidoOrcamentoVersao;
    private $PDV_PedidoContadorImpressao;
    private $PDV_PedidoValorAcrescimo;
    private $PDV_PedidoUsuario;
    private $PDV_PedidoClassificacao;
    private $PDV_PedidoObsImp;
    private $PDV_PedidoOrcamentoConvertido;
    private $PDV_PedidoEmpresaCobranca;
    private $PDV_PedidoSeguroFrete;
    private $PDV_PedidoDescontoAcrescimo;
    private $PDV_PedidoEmpreitada;
    private $PDV_PedidoMotoristaCodigo;
    private $PDV_PedidoNumeroOriginal;
    private $PDV_PedidoEmpresaOriginal;
    private $PDV_PedidoDimensoes;
    private $PDV_PedidoProjetoFilial;
    private $PDV_PedidoProjetoCodigo;
    private $PDV_PedidoUFEmbarque;
    private $PDV_PedidoLocalEmbarque;
    private $PDV_PedidoDataFinal;
    private $PDV_PedidoInfGerais;
    private $PDV_PedidoDespesasAcessorias;
    private $PDV_PedidoRepresentante;
    private $PDV_PedidoEnderecoLogradouro;
    private $PDV_PedidoTabelaPreco;
    private $PDV_PedidoContato;
    private $PDV_PedidoContaDeposito;
    private $PDV_PedidoContaCobranca;
    private $PDV_PedidoMotoristaNome;
    private $PDV_PedidoTipoFreteCodigo;
    private $PDV_PedidoCondicaoPgtoCodigo;
    private $PDV_PedidoMoedaCodigo;
    private $PDV_PedidoTipoMovimentoCodigo;
    private $PDV_PedidoValorTotal;
    private $PDV_PedidoCFOP;
    private $PDV_PedidoTipoEmiNF;
    private $PDV_PedidoSituacaoAltera;
    private $PDV_PedidoExcluido;
    private $PDV_PedidoEmpFisJur;
    private $PDV_PedidoEmpCNPJ;
    private $PDV_PedidoEmpIE;
    private $PDV_PedidoEmpTelefone;
    private $PDV_PedidoEmpFax;
    private $PDV_PedidoEmpConsumidorFinal;
    private $PDV_PedidoEmpRaizCNPJ;
    private $PDV_PedidoEmpEndBairro;
    private $PDV_PedidoEmpEndComplemento;
    private $PDV_PedidoEmpEndNumero;
    private $PDV_PedidoEmpEndUF;
    private $PDV_PedidoEmpEndCEP;
    private $PDV_PedidoEmpEndCidade;
    private $PDV_PedidoEmpEndRegCodigo;
    private $PDV_PedidoEmpEndRegDescricao;
    private $PDV_PedidoEmpEndPaisCod;
    private $PDV_PedidoEmpEndCidCod;
    private $PDV_PedidoEmpEmail;
    private $PDV_PedidoCentroCusto;
    private $PDV_PedidoPrazoEntrega;
    private $PDV_PedidoDispositivoCodigo;
    private $PDV_PedidoDispositivoNroPedido;
    private $PDV_PedidoDispositivoAltera;
    private $PDV_TipoCustoCodigo;
    private $PDV_PedidoEmpCobCodigo;
    private $PDV_PedidoEmpCobEndereco;
    private $PDV_PedidoEmpEntCodigo;
    private $PDV_PedidoEmpEntEndereco;
    private $PDV_PedidoRepresentanteAux;
    private $PDV_PedidoEmEntrega;
    private $PDV_PedidoValorMontagem;
    private $PDV_PedidoValorFreteAux;
    private $PDV_PedidoPesoBruto;
    private $PDV_PedidoPesoLiquido;
    private $PDV_PedidoVolumes;
    private $PDV_PedidoMarca;
    private $PDV_PedidoNumeracaoVolumes;
    private $PDV_PedidoNumeroFardos;
    private $PDV_PedidoNomeSuspect;
    private $PDV_PedidoMetrosCubicos;
    private $PDV_PedidoOrcAno;
    private $PDV_PedidoOrcNumero;
    private $PDV_PedidoOrcVersao;
    private $PDV_PedidoOperadora;
    private $PDV_PedidoValorAdiantamento;
    private $PDV_PedidoDiasEntrega;
    private $PDV_PedidoLiberadoParaProducao;
    private $PDV_PedidoComissaoPercManual;
    private $PDV_PedidoSimuladorVendaSeq;
    private $PDV_PedidoCRMCodigo;
    private $PDV_PedidoOperadoraBandeira;
    private $PDV_PedidoVendaCli;
    private $PDV_PedidoIndicadorPresenca;
    private $PDV_PedidoContratoConstrucao;
    private $PDV_PedidoEmpAtividadeEconomic;
    private $PDV_PedidoEmbalagem;
    private $PDV_PedidoFinMovimentoSeq;
    private $PDV_PedidoTipoVendaCod;
    private $PDV_PedidoEmpAssociado;
    private $PDV_PedidoTipoFornecimento;
    private $PDV_PedidoCodigoInformado;
    private $PDV_PedidoCodigoCR;
    private $PDV_PedidoCodigoAF;
    private $PDV_PedidoCarenciaNegociada;
    private $PDV_PedidoDiasCarenciaJuros;
    private $PDV_PedidoEmbalagemManual;
    
        
    function getDELX_CAD_Pessoa() {
        if(!isset($this->DELX_CAD_Pessoa)){
            $this->DELX_CAD_Pessoa = Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa;
    }

    function setDELX_CAD_Pessoa($DELX_CAD_Pessoa) {
        $this->DELX_CAD_Pessoa = $DELX_CAD_Pessoa;
    }

        
    function getPdv_pedidocodigo() {
        return $this->pdv_pedidocodigo;
    }

    function setPdv_pedidocodigo($pdv_pedidocodigo) {
        $this->pdv_pedidocodigo = $pdv_pedidocodigo;
    }

        
    
    function getPDV_PedidoFilial() {
        return $this->pdv_pedidofilial;
    }

    
    function getPDV_PedidoEmpCodigo() {
        return $this->PDV_PedidoEmpCodigo;
    }

    function getPDV_PedidoObsProducao() {
        return $this->PDV_PedidoObsProducao;
    }

    function getPDV_PedidoObs() {
        return $this->PDV_PedidoObs;
    }

    function getPDV_PedidoObsFinanceiras() {
        return $this->PDV_PedidoObsFinanceiras;
    }

    function getPDV_PedidoDataEmissao() {
        return $this->PDV_PedidoDataEmissao;
    }

    function getPDV_PedidoTransportadorCodigo() {
        return $this->PDV_PedidoTransportadorCodigo;
    }

    function getPDV_PedidoRedespachoCodigo() {
        return $this->PDV_PedidoRedespachoCodigo;
    }

    function getPDV_PedidoFreteRedespacho() {
        return $this->PDV_PedidoFreteRedespacho;
    }

    function getPDV_PedidoTransportadorPlaca() {
        return $this->PDV_PedidoTransportadorPlaca;
    }

    function getPDV_PedidoCamChegada() {
        return $this->PDV_PedidoCamChegada;
    }

    function getPDV_PedidoCamSaida() {
        return $this->PDV_PedidoCamSaida;
    }

    function getPDV_PedidoCamEntrada() {
        return $this->PDV_PedidoCamEntrada;
    }

    function getPDV_PedidoFreteValor() {
        return $this->PDV_PedidoFreteValor;
    }

    function getPDV_PedidoOrdemCompra() {
        return $this->PDV_PedidoOrdemCompra;
    }

    function getPDV_PedidoOrdemCompraData() {
        return $this->PDV_PedidoOrdemCompraData;
    }

    function getPDV_PedidoCpgTaxa() {
        return $this->PDV_PedidoCpgTaxa;
    }

    function getPDV_PedidoDescontoPerc() {
        return $this->PDV_PedidoDescontoPerc;
    }

    function getPDV_PedidoDescontoValor() {
        return $this->PDV_PedidoDescontoValor;
    }

    function getPDV_PedidoDataDigitacao() {
        return $this->PDV_PedidoDataDigitacao;
    }

    function getPDV_PedidoDataEntrega() {
        return $this->PDV_PedidoDataEntrega;
    }

    function getPDV_PedidoSituacao() {
        return $this->PDV_PedidoSituacao;
    }

    function getPDV_PedidoAprovacao() {
        return $this->PDV_PedidoAprovacao;
    }

    function getPDV_PedidoSomaFrete() {
        return $this->PDV_PedidoSomaFrete;
    }

    function getPDV_PedidoSomaST() {
        return $this->PDV_PedidoSomaST;
    }

    function getPDV_PedidoEndereco() {
        return $this->PDV_PedidoEndereco;
    }

    function getPDV_PedidoLocalEntrega() {
        return $this->PDV_PedidoLocalEntrega;
    }

    function getPDV_PedidoConsumidorFinal() {
        return $this->PDV_PedidoConsumidorFinal;
    }

    function getPDV_PedidoAreaRestrita() {
        return $this->PDV_PedidoAreaRestrita;
    }

    function getPDV_PedidoTipoPagamento() {
        return $this->PDV_PedidoTipoPagamento;
    }

    function getPDV_PedidoBancoDeposito() {
        return $this->PDV_PedidoBancoDeposito;
    }

    function getPDV_PedidoComissaoPerc() {
        return $this->PDV_PedidoComissaoPerc;
    }

    function getPDV_PedidoTipoCod() {
        return $this->PDV_PedidoTipoCod;
    }

    function getPDV_PedidoValidade() {
        return $this->PDV_PedidoValidade;
    }

    function getPDV_PedidoBancoCobranca() {
        return $this->PDV_PedidoBancoCobranca;
    }

    function getPDV_PedidoCarteiraCobranca() {
        return $this->PDV_PedidoCarteiraCobranca;
    }

    function getPDV_PedidoValorDevolucao() {
        return $this->PDV_PedidoValorDevolucao;
    }

    function getPDV_PedidoDataProducao() {
        return $this->PDV_PedidoDataProducao;
    }

    function getPDV_PedidoEspecie() {
        return $this->PDV_PedidoEspecie;
    }

    function getPDV_PedidoOrcamentoAno() {
        return $this->PDV_PedidoOrcamentoAno;
    }

    function getPDV_PedidoOrcamentoNumero() {
        return $this->PDV_PedidoOrcamentoNumero;
    }

    function getPDV_PedidoOrcamentoVersao() {
        return $this->PDV_PedidoOrcamentoVersao;
    }

    function getPDV_PedidoContadorImpressao() {
        return $this->PDV_PedidoContadorImpressao;
    }

    function getPDV_PedidoValorAcrescimo() {
        return $this->PDV_PedidoValorAcrescimo;
    }

    function getPDV_PedidoUsuario() {
        return $this->PDV_PedidoUsuario;
    }

    function getPDV_PedidoClassificacao() {
        return $this->PDV_PedidoClassificacao;
    }

    function getPDV_PedidoObsImp() {
        return $this->PDV_PedidoObsImp;
    }

    function getPDV_PedidoOrcamentoConvertido() {
        return $this->PDV_PedidoOrcamentoConvertido;
    }

    function getPDV_PedidoEmpresaCobranca() {
        return $this->PDV_PedidoEmpresaCobranca;
    }

    function getPDV_PedidoSeguroFrete() {
        return $this->PDV_PedidoSeguroFrete;
    }

    function getPDV_PedidoDescontoAcrescimo() {
        return $this->PDV_PedidoDescontoAcrescimo;
    }

    function getPDV_PedidoEmpreitada() {
        return $this->PDV_PedidoEmpreitada;
    }

    function getPDV_PedidoMotoristaCodigo() {
        return $this->PDV_PedidoMotoristaCodigo;
    }

    function getPDV_PedidoNumeroOriginal() {
        return $this->PDV_PedidoNumeroOriginal;
    }

    function getPDV_PedidoEmpresaOriginal() {
        return $this->PDV_PedidoEmpresaOriginal;
    }

    function getPDV_PedidoDimensoes() {
        return $this->PDV_PedidoDimensoes;
    }

    function getPDV_PedidoProjetoFilial() {
        return $this->PDV_PedidoProjetoFilial;
    }

    function getPDV_PedidoProjetoCodigo() {
        return $this->PDV_PedidoProjetoCodigo;
    }

    function getPDV_PedidoUFEmbarque() {
        return $this->PDV_PedidoUFEmbarque;
    }

    function getPDV_PedidoLocalEmbarque() {
        return $this->PDV_PedidoLocalEmbarque;
    }

    function getPDV_PedidoDataFinal() {
        return $this->PDV_PedidoDataFinal;
    }

    function getPDV_PedidoInfGerais() {
        return $this->PDV_PedidoInfGerais;
    }

    function getPDV_PedidoDespesasAcessorias() {
        return $this->PDV_PedidoDespesasAcessorias;
    }

    function getPDV_PedidoRepresentante() {
        return $this->PDV_PedidoRepresentante;
    }

    function getPDV_PedidoEnderecoLogradouro() {
        return $this->PDV_PedidoEnderecoLogradouro;
    }

    function getPDV_PedidoTabelaPreco() {
        return $this->PDV_PedidoTabelaPreco;
    }

    function getPDV_PedidoContato() {
        return $this->PDV_PedidoContato;
    }

    function getPDV_PedidoContaDeposito() {
        return $this->PDV_PedidoContaDeposito;
    }

    function getPDV_PedidoContaCobranca() {
        return $this->PDV_PedidoContaCobranca;
    }

    function getPDV_PedidoMotoristaNome() {
        return $this->PDV_PedidoMotoristaNome;
    }

    function getPDV_PedidoTipoFreteCodigo() {
        return $this->PDV_PedidoTipoFreteCodigo;
    }

    function getPDV_PedidoCondicaoPgtoCodigo() {
        return $this->PDV_PedidoCondicaoPgtoCodigo;
    }

    function getPDV_PedidoMoedaCodigo() {
        return $this->PDV_PedidoMoedaCodigo;
    }

    function getPDV_PedidoTipoMovimentoCodigo() {
        return $this->PDV_PedidoTipoMovimentoCodigo;
    }

    function getPDV_PedidoValorTotal() {
        return $this->PDV_PedidoValorTotal;
    }

    function getPDV_PedidoCFOP() {
        return $this->PDV_PedidoCFOP;
    }

    function getPDV_PedidoTipoEmiNF() {
        return $this->PDV_PedidoTipoEmiNF;
    }

    function getPDV_PedidoSituacaoAltera() {
        return $this->PDV_PedidoSituacaoAltera;
    }

    function getPDV_PedidoExcluido() {
        return $this->PDV_PedidoExcluido;
    }

    function getPDV_PedidoEmpFisJur() {
        return $this->PDV_PedidoEmpFisJur;
    }

    function getPDV_PedidoEmpCNPJ() {
        return $this->PDV_PedidoEmpCNPJ;
    }

    function getPDV_PedidoEmpIE() {
        return $this->PDV_PedidoEmpIE;
    }

    function getPDV_PedidoEmpTelefone() {
        return $this->PDV_PedidoEmpTelefone;
    }

    function getPDV_PedidoEmpFax() {
        return $this->PDV_PedidoEmpFax;
    }

    function getPDV_PedidoEmpConsumidorFinal() {
        return $this->PDV_PedidoEmpConsumidorFinal;
    }

    function getPDV_PedidoEmpRaizCNPJ() {
        return $this->PDV_PedidoEmpRaizCNPJ;
    }

    function getPDV_PedidoEmpEndBairro() {
        return $this->PDV_PedidoEmpEndBairro;
    }

    function getPDV_PedidoEmpEndComplemento() {
        return $this->PDV_PedidoEmpEndComplemento;
    }

    function getPDV_PedidoEmpEndNumero() {
        return $this->PDV_PedidoEmpEndNumero;
    }

    function getPDV_PedidoEmpEndUF() {
        return $this->PDV_PedidoEmpEndUF;
    }

    function getPDV_PedidoEmpEndCEP() {
        return $this->PDV_PedidoEmpEndCEP;
    }

    function getPDV_PedidoEmpEndCidade() {
        return $this->PDV_PedidoEmpEndCidade;
    }

    function getPDV_PedidoEmpEndRegCodigo() {
        return $this->PDV_PedidoEmpEndRegCodigo;
    }

    function getPDV_PedidoEmpEndRegDescricao() {
        return $this->PDV_PedidoEmpEndRegDescricao;
    }

    function getPDV_PedidoEmpEndPaisCod() {
        return $this->PDV_PedidoEmpEndPaisCod;
    }

    function getPDV_PedidoEmpEndCidCod() {
        return $this->PDV_PedidoEmpEndCidCod;
    }

    function getPDV_PedidoEmpEmail() {
        return $this->PDV_PedidoEmpEmail;
    }

    function getPDV_PedidoCentroCusto() {
        return $this->PDV_PedidoCentroCusto;
    }

    function getPDV_PedidoPrazoEntrega() {
        return $this->PDV_PedidoPrazoEntrega;
    }

    function getPDV_PedidoDispositivoCodigo() {
        return $this->PDV_PedidoDispositivoCodigo;
    }

    function getPDV_PedidoDispositivoNroPedido() {
        return $this->PDV_PedidoDispositivoNroPedido;
    }

    function getPDV_PedidoDispositivoAltera() {
        return $this->PDV_PedidoDispositivoAltera;
    }

    function getPDV_TipoCustoCodigo() {
        return $this->PDV_TipoCustoCodigo;
    }

    function getPDV_PedidoEmpCobCodigo() {
        return $this->PDV_PedidoEmpCobCodigo;
    }

    function getPDV_PedidoEmpCobEndereco() {
        return $this->PDV_PedidoEmpCobEndereco;
    }

    function getPDV_PedidoEmpEntCodigo() {
        return $this->PDV_PedidoEmpEntCodigo;
    }

    function getPDV_PedidoEmpEntEndereco() {
        return $this->PDV_PedidoEmpEntEndereco;
    }

    function getPDV_PedidoRepresentanteAux() {
        return $this->PDV_PedidoRepresentanteAux;
    }

    function getPDV_PedidoEmEntrega() {
        return $this->PDV_PedidoEmEntrega;
    }

    function getPDV_PedidoValorMontagem() {
        return $this->PDV_PedidoValorMontagem;
    }

    function getPDV_PedidoValorFreteAux() {
        return $this->PDV_PedidoValorFreteAux;
    }

    function getPDV_PedidoPesoBruto() {
        return $this->PDV_PedidoPesoBruto;
    }

    function getPDV_PedidoPesoLiquido() {
        return $this->PDV_PedidoPesoLiquido;
    }

    function getPDV_PedidoVolumes() {
        return $this->PDV_PedidoVolumes;
    }

    function getPDV_PedidoMarca() {
        return $this->PDV_PedidoMarca;
    }

    function getPDV_PedidoNumeracaoVolumes() {
        return $this->PDV_PedidoNumeracaoVolumes;
    }

    function getPDV_PedidoNumeroFardos() {
        return $this->PDV_PedidoNumeroFardos;
    }

    function getPDV_PedidoNomeSuspect() {
        return $this->PDV_PedidoNomeSuspect;
    }

    function getPDV_PedidoMetrosCubicos() {
        return $this->PDV_PedidoMetrosCubicos;
    }

    function getPDV_PedidoOrcAno() {
        return $this->PDV_PedidoOrcAno;
    }

    function getPDV_PedidoOrcNumero() {
        return $this->PDV_PedidoOrcNumero;
    }

    function getPDV_PedidoOrcVersao() {
        return $this->PDV_PedidoOrcVersao;
    }

    function getPDV_PedidoOperadora() {
        return $this->PDV_PedidoOperadora;
    }

    function getPDV_PedidoValorAdiantamento() {
        return $this->PDV_PedidoValorAdiantamento;
    }

    function getPDV_PedidoDiasEntrega() {
        return $this->PDV_PedidoDiasEntrega;
    }

    function getPDV_PedidoLiberadoParaProducao() {
        return $this->PDV_PedidoLiberadoParaProducao;
    }

    function getPDV_PedidoComissaoPercManual() {
        return $this->PDV_PedidoComissaoPercManual;
    }

    function getPDV_PedidoSimuladorVendaSeq() {
        return $this->PDV_PedidoSimuladorVendaSeq;
    }

    function getPDV_PedidoCRMCodigo() {
        return $this->PDV_PedidoCRMCodigo;
    }

    function getPDV_PedidoOperadoraBandeira() {
        return $this->PDV_PedidoOperadoraBandeira;
    }

    function getPDV_PedidoVendaCli() {
        return $this->PDV_PedidoVendaCli;
    }

    function getPDV_PedidoIndicadorPresenca() {
        return $this->PDV_PedidoIndicadorPresenca;
    }

    function getPDV_PedidoContratoConstrucao() {
        return $this->PDV_PedidoContratoConstrucao;
    }

    function getPDV_PedidoEmpAtividadeEconomic() {
        return $this->PDV_PedidoEmpAtividadeEconomic;
    }

    function getPDV_PedidoEmbalagem() {
        return $this->PDV_PedidoEmbalagem;
    }

    function getPDV_PedidoFinMovimentoSeq() {
        return $this->PDV_PedidoFinMovimentoSeq;
    }

    function getPDV_PedidoTipoVendaCod() {
        return $this->PDV_PedidoTipoVendaCod;
    }

    function getPDV_PedidoEmpAssociado() {
        return $this->PDV_PedidoEmpAssociado;
    }

    function getPDV_PedidoTipoFornecimento() {
        return $this->PDV_PedidoTipoFornecimento;
    }

    function getPDV_PedidoCodigoInformado() {
        return $this->PDV_PedidoCodigoInformado;
    }

    function getPDV_PedidoCodigoCR() {
        return $this->PDV_PedidoCodigoCR;
    }

    function getPDV_PedidoCodigoAF() {
        return $this->PDV_PedidoCodigoAF;
    }

    function getPDV_PedidoCarenciaNegociada() {
        return $this->PDV_PedidoCarenciaNegociada;
    }

    function getPDV_PedidoDiasCarenciaJuros() {
        return $this->PDV_PedidoDiasCarenciaJuros;
    }

    function getPDV_PedidoEmbalagemManual() {
        return $this->PDV_PedidoEmbalagemManual;
    }

    function setPDV_PedidoFilial($PDV_PedidoFilial) {
        $this->pdv_pedidofilial = $PDV_PedidoFilial;
    }

    

    function setPDV_PedidoEmpCodigo($PDV_PedidoEmpCodigo) {
        $this->PDV_PedidoEmpCodigo = $PDV_PedidoEmpCodigo;
    }

    function setPDV_PedidoObsProducao($PDV_PedidoObsProducao) {
        $this->PDV_PedidoObsProducao = $PDV_PedidoObsProducao;
    }

    function setPDV_PedidoObs($PDV_PedidoObs) {
        $this->PDV_PedidoObs = $PDV_PedidoObs;
    }

    function setPDV_PedidoObsFinanceiras($PDV_PedidoObsFinanceiras) {
        $this->PDV_PedidoObsFinanceiras = $PDV_PedidoObsFinanceiras;
    }

    function setPDV_PedidoDataEmissao($PDV_PedidoDataEmissao) {
        $this->PDV_PedidoDataEmissao = $PDV_PedidoDataEmissao;
    }

    function setPDV_PedidoTransportadorCodigo($PDV_PedidoTransportadorCodigo) {
        $this->PDV_PedidoTransportadorCodigo = $PDV_PedidoTransportadorCodigo;
    }

    function setPDV_PedidoRedespachoCodigo($PDV_PedidoRedespachoCodigo) {
        $this->PDV_PedidoRedespachoCodigo = $PDV_PedidoRedespachoCodigo;
    }

    function setPDV_PedidoFreteRedespacho($PDV_PedidoFreteRedespacho) {
        $this->PDV_PedidoFreteRedespacho = $PDV_PedidoFreteRedespacho;
    }

    function setPDV_PedidoTransportadorPlaca($PDV_PedidoTransportadorPlaca) {
        $this->PDV_PedidoTransportadorPlaca = $PDV_PedidoTransportadorPlaca;
    }

    function setPDV_PedidoCamChegada($PDV_PedidoCamChegada) {
        $this->PDV_PedidoCamChegada = $PDV_PedidoCamChegada;
    }

    function setPDV_PedidoCamSaida($PDV_PedidoCamSaida) {
        $this->PDV_PedidoCamSaida = $PDV_PedidoCamSaida;
    }

    function setPDV_PedidoCamEntrada($PDV_PedidoCamEntrada) {
        $this->PDV_PedidoCamEntrada = $PDV_PedidoCamEntrada;
    }

    function setPDV_PedidoFreteValor($PDV_PedidoFreteValor) {
        $this->PDV_PedidoFreteValor = $PDV_PedidoFreteValor;
    }

    function setPDV_PedidoOrdemCompra($PDV_PedidoOrdemCompra) {
        $this->PDV_PedidoOrdemCompra = $PDV_PedidoOrdemCompra;
    }

    function setPDV_PedidoOrdemCompraData($PDV_PedidoOrdemCompraData) {
        $this->PDV_PedidoOrdemCompraData = $PDV_PedidoOrdemCompraData;
    }

    function setPDV_PedidoCpgTaxa($PDV_PedidoCpgTaxa) {
        $this->PDV_PedidoCpgTaxa = $PDV_PedidoCpgTaxa;
    }

    function setPDV_PedidoDescontoPerc($PDV_PedidoDescontoPerc) {
        $this->PDV_PedidoDescontoPerc = $PDV_PedidoDescontoPerc;
    }

    function setPDV_PedidoDescontoValor($PDV_PedidoDescontoValor) {
        $this->PDV_PedidoDescontoValor = $PDV_PedidoDescontoValor;
    }

    function setPDV_PedidoDataDigitacao($PDV_PedidoDataDigitacao) {
        $this->PDV_PedidoDataDigitacao = $PDV_PedidoDataDigitacao;
    }

    function setPDV_PedidoDataEntrega($PDV_PedidoDataEntrega) {
        $this->PDV_PedidoDataEntrega = $PDV_PedidoDataEntrega;
    }

    function setPDV_PedidoSituacao($PDV_PedidoSituacao) {
        $this->PDV_PedidoSituacao = $PDV_PedidoSituacao;
    }

    function setPDV_PedidoAprovacao($PDV_PedidoAprovacao) {
        $this->PDV_PedidoAprovacao = $PDV_PedidoAprovacao;
    }

    function setPDV_PedidoSomaFrete($PDV_PedidoSomaFrete) {
        $this->PDV_PedidoSomaFrete = $PDV_PedidoSomaFrete;
    }

    function setPDV_PedidoSomaST($PDV_PedidoSomaST) {
        $this->PDV_PedidoSomaST = $PDV_PedidoSomaST;
    }

    function setPDV_PedidoEndereco($PDV_PedidoEndereco) {
        $this->PDV_PedidoEndereco = $PDV_PedidoEndereco;
    }

    function setPDV_PedidoLocalEntrega($PDV_PedidoLocalEntrega) {
        $this->PDV_PedidoLocalEntrega = $PDV_PedidoLocalEntrega;
    }

    function setPDV_PedidoConsumidorFinal($PDV_PedidoConsumidorFinal) {
        $this->PDV_PedidoConsumidorFinal = $PDV_PedidoConsumidorFinal;
    }

    function setPDV_PedidoAreaRestrita($PDV_PedidoAreaRestrita) {
        $this->PDV_PedidoAreaRestrita = $PDV_PedidoAreaRestrita;
    }

    function setPDV_PedidoTipoPagamento($PDV_PedidoTipoPagamento) {
        $this->PDV_PedidoTipoPagamento = $PDV_PedidoTipoPagamento;
    }

    function setPDV_PedidoBancoDeposito($PDV_PedidoBancoDeposito) {
        $this->PDV_PedidoBancoDeposito = $PDV_PedidoBancoDeposito;
    }

    function setPDV_PedidoComissaoPerc($PDV_PedidoComissaoPerc) {
        $this->PDV_PedidoComissaoPerc = $PDV_PedidoComissaoPerc;
    }

    function setPDV_PedidoTipoCod($PDV_PedidoTipoCod) {
        $this->PDV_PedidoTipoCod = $PDV_PedidoTipoCod;
    }

    function setPDV_PedidoValidade($PDV_PedidoValidade) {
        $this->PDV_PedidoValidade = $PDV_PedidoValidade;
    }

    function setPDV_PedidoBancoCobranca($PDV_PedidoBancoCobranca) {
        $this->PDV_PedidoBancoCobranca = $PDV_PedidoBancoCobranca;
    }

    function setPDV_PedidoCarteiraCobranca($PDV_PedidoCarteiraCobranca) {
        $this->PDV_PedidoCarteiraCobranca = $PDV_PedidoCarteiraCobranca;
    }

    function setPDV_PedidoValorDevolucao($PDV_PedidoValorDevolucao) {
        $this->PDV_PedidoValorDevolucao = $PDV_PedidoValorDevolucao;
    }

    function setPDV_PedidoDataProducao($PDV_PedidoDataProducao) {
        $this->PDV_PedidoDataProducao = $PDV_PedidoDataProducao;
    }

    function setPDV_PedidoEspecie($PDV_PedidoEspecie) {
        $this->PDV_PedidoEspecie = $PDV_PedidoEspecie;
    }

    function setPDV_PedidoOrcamentoAno($PDV_PedidoOrcamentoAno) {
        $this->PDV_PedidoOrcamentoAno = $PDV_PedidoOrcamentoAno;
    }

    function setPDV_PedidoOrcamentoNumero($PDV_PedidoOrcamentoNumero) {
        $this->PDV_PedidoOrcamentoNumero = $PDV_PedidoOrcamentoNumero;
    }

    function setPDV_PedidoOrcamentoVersao($PDV_PedidoOrcamentoVersao) {
        $this->PDV_PedidoOrcamentoVersao = $PDV_PedidoOrcamentoVersao;
    }

    function setPDV_PedidoContadorImpressao($PDV_PedidoContadorImpressao) {
        $this->PDV_PedidoContadorImpressao = $PDV_PedidoContadorImpressao;
    }

    function setPDV_PedidoValorAcrescimo($PDV_PedidoValorAcrescimo) {
        $this->PDV_PedidoValorAcrescimo = $PDV_PedidoValorAcrescimo;
    }

    function setPDV_PedidoUsuario($PDV_PedidoUsuario) {
        $this->PDV_PedidoUsuario = $PDV_PedidoUsuario;
    }

    function setPDV_PedidoClassificacao($PDV_PedidoClassificacao) {
        $this->PDV_PedidoClassificacao = $PDV_PedidoClassificacao;
    }

    function setPDV_PedidoObsImp($PDV_PedidoObsImp) {
        $this->PDV_PedidoObsImp = $PDV_PedidoObsImp;
    }

    function setPDV_PedidoOrcamentoConvertido($PDV_PedidoOrcamentoConvertido) {
        $this->PDV_PedidoOrcamentoConvertido = $PDV_PedidoOrcamentoConvertido;
    }

    function setPDV_PedidoEmpresaCobranca($PDV_PedidoEmpresaCobranca) {
        $this->PDV_PedidoEmpresaCobranca = $PDV_PedidoEmpresaCobranca;
    }

    function setPDV_PedidoSeguroFrete($PDV_PedidoSeguroFrete) {
        $this->PDV_PedidoSeguroFrete = $PDV_PedidoSeguroFrete;
    }

    function setPDV_PedidoDescontoAcrescimo($PDV_PedidoDescontoAcrescimo) {
        $this->PDV_PedidoDescontoAcrescimo = $PDV_PedidoDescontoAcrescimo;
    }

    function setPDV_PedidoEmpreitada($PDV_PedidoEmpreitada) {
        $this->PDV_PedidoEmpreitada = $PDV_PedidoEmpreitada;
    }

    function setPDV_PedidoMotoristaCodigo($PDV_PedidoMotoristaCodigo) {
        $this->PDV_PedidoMotoristaCodigo = $PDV_PedidoMotoristaCodigo;
    }

    function setPDV_PedidoNumeroOriginal($PDV_PedidoNumeroOriginal) {
        $this->PDV_PedidoNumeroOriginal = $PDV_PedidoNumeroOriginal;
    }

    function setPDV_PedidoEmpresaOriginal($PDV_PedidoEmpresaOriginal) {
        $this->PDV_PedidoEmpresaOriginal = $PDV_PedidoEmpresaOriginal;
    }

    function setPDV_PedidoDimensoes($PDV_PedidoDimensoes) {
        $this->PDV_PedidoDimensoes = $PDV_PedidoDimensoes;
    }

    function setPDV_PedidoProjetoFilial($PDV_PedidoProjetoFilial) {
        $this->PDV_PedidoProjetoFilial = $PDV_PedidoProjetoFilial;
    }

    function setPDV_PedidoProjetoCodigo($PDV_PedidoProjetoCodigo) {
        $this->PDV_PedidoProjetoCodigo = $PDV_PedidoProjetoCodigo;
    }

    function setPDV_PedidoUFEmbarque($PDV_PedidoUFEmbarque) {
        $this->PDV_PedidoUFEmbarque = $PDV_PedidoUFEmbarque;
    }

    function setPDV_PedidoLocalEmbarque($PDV_PedidoLocalEmbarque) {
        $this->PDV_PedidoLocalEmbarque = $PDV_PedidoLocalEmbarque;
    }

    function setPDV_PedidoDataFinal($PDV_PedidoDataFinal) {
        $this->PDV_PedidoDataFinal = $PDV_PedidoDataFinal;
    }

    function setPDV_PedidoInfGerais($PDV_PedidoInfGerais) {
        $this->PDV_PedidoInfGerais = $PDV_PedidoInfGerais;
    }

    function setPDV_PedidoDespesasAcessorias($PDV_PedidoDespesasAcessorias) {
        $this->PDV_PedidoDespesasAcessorias = $PDV_PedidoDespesasAcessorias;
    }

    function setPDV_PedidoRepresentante($PDV_PedidoRepresentante) {
        $this->PDV_PedidoRepresentante = $PDV_PedidoRepresentante;
    }

    function setPDV_PedidoEnderecoLogradouro($PDV_PedidoEnderecoLogradouro) {
        $this->PDV_PedidoEnderecoLogradouro = $PDV_PedidoEnderecoLogradouro;
    }

    function setPDV_PedidoTabelaPreco($PDV_PedidoTabelaPreco) {
        $this->PDV_PedidoTabelaPreco = $PDV_PedidoTabelaPreco;
    }

    function setPDV_PedidoContato($PDV_PedidoContato) {
        $this->PDV_PedidoContato = $PDV_PedidoContato;
    }

    function setPDV_PedidoContaDeposito($PDV_PedidoContaDeposito) {
        $this->PDV_PedidoContaDeposito = $PDV_PedidoContaDeposito;
    }

    function setPDV_PedidoContaCobranca($PDV_PedidoContaCobranca) {
        $this->PDV_PedidoContaCobranca = $PDV_PedidoContaCobranca;
    }

    function setPDV_PedidoMotoristaNome($PDV_PedidoMotoristaNome) {
        $this->PDV_PedidoMotoristaNome = $PDV_PedidoMotoristaNome;
    }

    function setPDV_PedidoTipoFreteCodigo($PDV_PedidoTipoFreteCodigo) {
        $this->PDV_PedidoTipoFreteCodigo = $PDV_PedidoTipoFreteCodigo;
    }

    function setPDV_PedidoCondicaoPgtoCodigo($PDV_PedidoCondicaoPgtoCodigo) {
        $this->PDV_PedidoCondicaoPgtoCodigo = $PDV_PedidoCondicaoPgtoCodigo;
    }

    function setPDV_PedidoMoedaCodigo($PDV_PedidoMoedaCodigo) {
        $this->PDV_PedidoMoedaCodigo = $PDV_PedidoMoedaCodigo;
    }

    function setPDV_PedidoTipoMovimentoCodigo($PDV_PedidoTipoMovimentoCodigo) {
        $this->PDV_PedidoTipoMovimentoCodigo = $PDV_PedidoTipoMovimentoCodigo;
    }

    function setPDV_PedidoValorTotal($PDV_PedidoValorTotal) {
        $this->PDV_PedidoValorTotal = $PDV_PedidoValorTotal;
    }

    function setPDV_PedidoCFOP($PDV_PedidoCFOP) {
        $this->PDV_PedidoCFOP = $PDV_PedidoCFOP;
    }

    function setPDV_PedidoTipoEmiNF($PDV_PedidoTipoEmiNF) {
        $this->PDV_PedidoTipoEmiNF = $PDV_PedidoTipoEmiNF;
    }

    function setPDV_PedidoSituacaoAltera($PDV_PedidoSituacaoAltera) {
        $this->PDV_PedidoSituacaoAltera = $PDV_PedidoSituacaoAltera;
    }

    function setPDV_PedidoExcluido($PDV_PedidoExcluido) {
        $this->PDV_PedidoExcluido = $PDV_PedidoExcluido;
    }

    function setPDV_PedidoEmpFisJur($PDV_PedidoEmpFisJur) {
        $this->PDV_PedidoEmpFisJur = $PDV_PedidoEmpFisJur;
    }

    function setPDV_PedidoEmpCNPJ($PDV_PedidoEmpCNPJ) {
        $this->PDV_PedidoEmpCNPJ = $PDV_PedidoEmpCNPJ;
    }

    function setPDV_PedidoEmpIE($PDV_PedidoEmpIE) {
        $this->PDV_PedidoEmpIE = $PDV_PedidoEmpIE;
    }

    function setPDV_PedidoEmpTelefone($PDV_PedidoEmpTelefone) {
        $this->PDV_PedidoEmpTelefone = $PDV_PedidoEmpTelefone;
    }

    function setPDV_PedidoEmpFax($PDV_PedidoEmpFax) {
        $this->PDV_PedidoEmpFax = $PDV_PedidoEmpFax;
    }

    function setPDV_PedidoEmpConsumidorFinal($PDV_PedidoEmpConsumidorFinal) {
        $this->PDV_PedidoEmpConsumidorFinal = $PDV_PedidoEmpConsumidorFinal;
    }

    function setPDV_PedidoEmpRaizCNPJ($PDV_PedidoEmpRaizCNPJ) {
        $this->PDV_PedidoEmpRaizCNPJ = $PDV_PedidoEmpRaizCNPJ;
    }

    function setPDV_PedidoEmpEndBairro($PDV_PedidoEmpEndBairro) {
        $this->PDV_PedidoEmpEndBairro = $PDV_PedidoEmpEndBairro;
    }

    function setPDV_PedidoEmpEndComplemento($PDV_PedidoEmpEndComplemento) {
        $this->PDV_PedidoEmpEndComplemento = $PDV_PedidoEmpEndComplemento;
    }

    function setPDV_PedidoEmpEndNumero($PDV_PedidoEmpEndNumero) {
        $this->PDV_PedidoEmpEndNumero = $PDV_PedidoEmpEndNumero;
    }

    function setPDV_PedidoEmpEndUF($PDV_PedidoEmpEndUF) {
        $this->PDV_PedidoEmpEndUF = $PDV_PedidoEmpEndUF;
    }

    function setPDV_PedidoEmpEndCEP($PDV_PedidoEmpEndCEP) {
        $this->PDV_PedidoEmpEndCEP = $PDV_PedidoEmpEndCEP;
    }

    function setPDV_PedidoEmpEndCidade($PDV_PedidoEmpEndCidade) {
        $this->PDV_PedidoEmpEndCidade = $PDV_PedidoEmpEndCidade;
    }

    function setPDV_PedidoEmpEndRegCodigo($PDV_PedidoEmpEndRegCodigo) {
        $this->PDV_PedidoEmpEndRegCodigo = $PDV_PedidoEmpEndRegCodigo;
    }

    function setPDV_PedidoEmpEndRegDescricao($PDV_PedidoEmpEndRegDescricao) {
        $this->PDV_PedidoEmpEndRegDescricao = $PDV_PedidoEmpEndRegDescricao;
    }

    function setPDV_PedidoEmpEndPaisCod($PDV_PedidoEmpEndPaisCod) {
        $this->PDV_PedidoEmpEndPaisCod = $PDV_PedidoEmpEndPaisCod;
    }

    function setPDV_PedidoEmpEndCidCod($PDV_PedidoEmpEndCidCod) {
        $this->PDV_PedidoEmpEndCidCod = $PDV_PedidoEmpEndCidCod;
    }

    function setPDV_PedidoEmpEmail($PDV_PedidoEmpEmail) {
        $this->PDV_PedidoEmpEmail = $PDV_PedidoEmpEmail;
    }

    function setPDV_PedidoCentroCusto($PDV_PedidoCentroCusto) {
        $this->PDV_PedidoCentroCusto = $PDV_PedidoCentroCusto;
    }

    function setPDV_PedidoPrazoEntrega($PDV_PedidoPrazoEntrega) {
        $this->PDV_PedidoPrazoEntrega = $PDV_PedidoPrazoEntrega;
    }

    function setPDV_PedidoDispositivoCodigo($PDV_PedidoDispositivoCodigo) {
        $this->PDV_PedidoDispositivoCodigo = $PDV_PedidoDispositivoCodigo;
    }

    function setPDV_PedidoDispositivoNroPedido($PDV_PedidoDispositivoNroPedido) {
        $this->PDV_PedidoDispositivoNroPedido = $PDV_PedidoDispositivoNroPedido;
    }

    function setPDV_PedidoDispositivoAltera($PDV_PedidoDispositivoAltera) {
        $this->PDV_PedidoDispositivoAltera = $PDV_PedidoDispositivoAltera;
    }

    function setPDV_TipoCustoCodigo($PDV_TipoCustoCodigo) {
        $this->PDV_TipoCustoCodigo = $PDV_TipoCustoCodigo;
    }

    function setPDV_PedidoEmpCobCodigo($PDV_PedidoEmpCobCodigo) {
        $this->PDV_PedidoEmpCobCodigo = $PDV_PedidoEmpCobCodigo;
    }

    function setPDV_PedidoEmpCobEndereco($PDV_PedidoEmpCobEndereco) {
        $this->PDV_PedidoEmpCobEndereco = $PDV_PedidoEmpCobEndereco;
    }

    function setPDV_PedidoEmpEntCodigo($PDV_PedidoEmpEntCodigo) {
        $this->PDV_PedidoEmpEntCodigo = $PDV_PedidoEmpEntCodigo;
    }

    function setPDV_PedidoEmpEntEndereco($PDV_PedidoEmpEntEndereco) {
        $this->PDV_PedidoEmpEntEndereco = $PDV_PedidoEmpEntEndereco;
    }

    function setPDV_PedidoRepresentanteAux($PDV_PedidoRepresentanteAux) {
        $this->PDV_PedidoRepresentanteAux = $PDV_PedidoRepresentanteAux;
    }

    function setPDV_PedidoEmEntrega($PDV_PedidoEmEntrega) {
        $this->PDV_PedidoEmEntrega = $PDV_PedidoEmEntrega;
    }

    function setPDV_PedidoValorMontagem($PDV_PedidoValorMontagem) {
        $this->PDV_PedidoValorMontagem = $PDV_PedidoValorMontagem;
    }

    function setPDV_PedidoValorFreteAux($PDV_PedidoValorFreteAux) {
        $this->PDV_PedidoValorFreteAux = $PDV_PedidoValorFreteAux;
    }

    function setPDV_PedidoPesoBruto($PDV_PedidoPesoBruto) {
        $this->PDV_PedidoPesoBruto = $PDV_PedidoPesoBruto;
    }

    function setPDV_PedidoPesoLiquido($PDV_PedidoPesoLiquido) {
        $this->PDV_PedidoPesoLiquido = $PDV_PedidoPesoLiquido;
    }

    function setPDV_PedidoVolumes($PDV_PedidoVolumes) {
        $this->PDV_PedidoVolumes = $PDV_PedidoVolumes;
    }

    function setPDV_PedidoMarca($PDV_PedidoMarca) {
        $this->PDV_PedidoMarca = $PDV_PedidoMarca;
    }

    function setPDV_PedidoNumeracaoVolumes($PDV_PedidoNumeracaoVolumes) {
        $this->PDV_PedidoNumeracaoVolumes = $PDV_PedidoNumeracaoVolumes;
    }

    function setPDV_PedidoNumeroFardos($PDV_PedidoNumeroFardos) {
        $this->PDV_PedidoNumeroFardos = $PDV_PedidoNumeroFardos;
    }

    function setPDV_PedidoNomeSuspect($PDV_PedidoNomeSuspect) {
        $this->PDV_PedidoNomeSuspect = $PDV_PedidoNomeSuspect;
    }

    function setPDV_PedidoMetrosCubicos($PDV_PedidoMetrosCubicos) {
        $this->PDV_PedidoMetrosCubicos = $PDV_PedidoMetrosCubicos;
    }

    function setPDV_PedidoOrcAno($PDV_PedidoOrcAno) {
        $this->PDV_PedidoOrcAno = $PDV_PedidoOrcAno;
    }

    function setPDV_PedidoOrcNumero($PDV_PedidoOrcNumero) {
        $this->PDV_PedidoOrcNumero = $PDV_PedidoOrcNumero;
    }

    function setPDV_PedidoOrcVersao($PDV_PedidoOrcVersao) {
        $this->PDV_PedidoOrcVersao = $PDV_PedidoOrcVersao;
    }

    function setPDV_PedidoOperadora($PDV_PedidoOperadora) {
        $this->PDV_PedidoOperadora = $PDV_PedidoOperadora;
    }

    function setPDV_PedidoValorAdiantamento($PDV_PedidoValorAdiantamento) {
        $this->PDV_PedidoValorAdiantamento = $PDV_PedidoValorAdiantamento;
    }

    function setPDV_PedidoDiasEntrega($PDV_PedidoDiasEntrega) {
        $this->PDV_PedidoDiasEntrega = $PDV_PedidoDiasEntrega;
    }

    function setPDV_PedidoLiberadoParaProducao($PDV_PedidoLiberadoParaProducao) {
        $this->PDV_PedidoLiberadoParaProducao = $PDV_PedidoLiberadoParaProducao;
    }

    function setPDV_PedidoComissaoPercManual($PDV_PedidoComissaoPercManual) {
        $this->PDV_PedidoComissaoPercManual = $PDV_PedidoComissaoPercManual;
    }

    function setPDV_PedidoSimuladorVendaSeq($PDV_PedidoSimuladorVendaSeq) {
        $this->PDV_PedidoSimuladorVendaSeq = $PDV_PedidoSimuladorVendaSeq;
    }

    function setPDV_PedidoCRMCodigo($PDV_PedidoCRMCodigo) {
        $this->PDV_PedidoCRMCodigo = $PDV_PedidoCRMCodigo;
    }

    function setPDV_PedidoOperadoraBandeira($PDV_PedidoOperadoraBandeira) {
        $this->PDV_PedidoOperadoraBandeira = $PDV_PedidoOperadoraBandeira;
    }

    function setPDV_PedidoVendaCli($PDV_PedidoVendaCli) {
        $this->PDV_PedidoVendaCli = $PDV_PedidoVendaCli;
    }

    function setPDV_PedidoIndicadorPresenca($PDV_PedidoIndicadorPresenca) {
        $this->PDV_PedidoIndicadorPresenca = $PDV_PedidoIndicadorPresenca;
    }

    function setPDV_PedidoContratoConstrucao($PDV_PedidoContratoConstrucao) {
        $this->PDV_PedidoContratoConstrucao = $PDV_PedidoContratoConstrucao;
    }

    function setPDV_PedidoEmpAtividadeEconomic($PDV_PedidoEmpAtividadeEconomic) {
        $this->PDV_PedidoEmpAtividadeEconomic = $PDV_PedidoEmpAtividadeEconomic;
    }

    function setPDV_PedidoEmbalagem($PDV_PedidoEmbalagem) {
        $this->PDV_PedidoEmbalagem = $PDV_PedidoEmbalagem;
    }

    function setPDV_PedidoFinMovimentoSeq($PDV_PedidoFinMovimentoSeq) {
        $this->PDV_PedidoFinMovimentoSeq = $PDV_PedidoFinMovimentoSeq;
    }

    function setPDV_PedidoTipoVendaCod($PDV_PedidoTipoVendaCod) {
        $this->PDV_PedidoTipoVendaCod = $PDV_PedidoTipoVendaCod;
    }

    function setPDV_PedidoEmpAssociado($PDV_PedidoEmpAssociado) {
        $this->PDV_PedidoEmpAssociado = $PDV_PedidoEmpAssociado;
    }

    function setPDV_PedidoTipoFornecimento($PDV_PedidoTipoFornecimento) {
        $this->PDV_PedidoTipoFornecimento = $PDV_PedidoTipoFornecimento;
    }

    function setPDV_PedidoCodigoInformado($PDV_PedidoCodigoInformado) {
        $this->PDV_PedidoCodigoInformado = $PDV_PedidoCodigoInformado;
    }

    function setPDV_PedidoCodigoCR($PDV_PedidoCodigoCR) {
        $this->PDV_PedidoCodigoCR = $PDV_PedidoCodigoCR;
    }

    function setPDV_PedidoCodigoAF($PDV_PedidoCodigoAF) {
        $this->PDV_PedidoCodigoAF = $PDV_PedidoCodigoAF;
    }

    function setPDV_PedidoCarenciaNegociada($PDV_PedidoCarenciaNegociada) {
        $this->PDV_PedidoCarenciaNegociada = $PDV_PedidoCarenciaNegociada;
    }

    function setPDV_PedidoDiasCarenciaJuros($PDV_PedidoDiasCarenciaJuros) {
        $this->PDV_PedidoDiasCarenciaJuros = $PDV_PedidoDiasCarenciaJuros;
    }

    function setPDV_PedidoEmbalagemManual($PDV_PedidoEmbalagemManual) {
        $this->PDV_PedidoEmbalagemManual = $PDV_PedidoEmbalagemManual;
    }
    
}