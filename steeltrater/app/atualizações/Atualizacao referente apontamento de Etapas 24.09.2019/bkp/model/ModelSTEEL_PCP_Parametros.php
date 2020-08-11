<?php

/*
 * Classe que implementa os models da STEEL_PCP_Parametros
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */

class ModelSTEEL_PCP_Parametros{
    
    private $id;
    private $nome;
    private $PDV_PedidoDescontoPerc;
    private $PDV_PedidoSomaFrete;
    private $PDV_PedidoSomaST;
    private $PDV_PedidoEndereco;
    private $PDV_PedidoConsumidorFinal;
    private $PDV_PedidoAreaRestrita;
    private $PDV_PedidoTipoPagamento;
    private $PDV_PedidoComissaoPerc;
    private $PDV_PedidoTipoCod;
    private $PDV_PedidoBancoCobranca;
    private $PDV_PedidoCarteiraCobranca;
    private $PDV_PedidoOrcamentoAno;
    private $PDV_PedidoOrcamentoNumero;
    private $PDV_PedidoOrcamentoVersao;
    private $PDV_PedidoContadorImpressao;
    private $PDV_PedidoObsImp;
    private $PDV_PedidoOrcamentoConvertido;
    private $PDV_PedidoEmpreitada;
    private $PDV_PedidoNumeroOriginal;
    private $PDV_PedidoEmpresaOriginal;
    private $PDV_PedidoDimensoes;
    private $PDV_PedidoDataFinal;
    private $PDV_PedidoContato;
    private $PDV_PedidoContaDeposito;
    private $PDV_PedidoContaCobranca;
    private $PDV_PedidoMotoristaNome;
    private $PDV_PedidoTipoFreteCodigo;
    private $PDV_PedidoCondicaoPgtoCodigo;
    private $PDV_PedidoMoedaCodigo;
    private $PDV_PedidoTipoEmiNF;
    private $PDV_PedidoSituacaoAltera;
    private $PDV_PedidoExcluido;
    private $PDV_PedidoEmpFisJur;
    private $PDV_PedidoDispositivoCodigo;
    private $PDV_PedidoDispositivoNroPedido;
    private $PDV_PedidoDispositivoAltera;
    private $PDV_PedidoEmEntrega;
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
    private $PDV_PedidoContratoConstrucao;
    private $PDV_PedidoEmpAtividadeEconomic;
    private $PDV_PedidoEmbalagem;
    private $PDV_PedidoFinMovimentoSeq;
    private $PDV_PedidoEmpAssociado;
    private $PDV_PedidoTipoFornecimento;
    private $PDV_PedidoCodigoInformado;
    private $PDV_PedidoCodigoCR;
    private $PDV_PedidoCodigoAF;
    private $PDV_PedidoCarenciaNegociada;
    private $PDV_PedidoDiasCarenciaJuros;
    private $PDV_PedidoEmbalagemManual;
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getPDV_PedidoDescontoPerc() {
        return $this->PDV_PedidoDescontoPerc;
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

    function getPDV_PedidoConsumidorFinal() {
        return $this->PDV_PedidoConsumidorFinal;
    }

    function getPDV_PedidoAreaRestrita() {
        return $this->PDV_PedidoAreaRestrita;
    }

    function getPDV_PedidoTipoPagamento() {
        return $this->PDV_PedidoTipoPagamento;
    }

    function getPDV_PedidoComissaoPerc() {
        return $this->PDV_PedidoComissaoPerc;
    }

    function getPDV_PedidoTipoCod() {
        return $this->PDV_PedidoTipoCod;
    }

    function getPDV_PedidoBancoCobranca() {
        return $this->PDV_PedidoBancoCobranca;
    }

    function getPDV_PedidoCarteiraCobranca() {
        return $this->PDV_PedidoCarteiraCobranca;
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

    function getPDV_PedidoObsImp() {
        return $this->PDV_PedidoObsImp;
    }

    function getPDV_PedidoOrcamentoConvertido() {
        return $this->PDV_PedidoOrcamentoConvertido;
    }

    function getPDV_PedidoEmpreitada() {
        return $this->PDV_PedidoEmpreitada;
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

    function getPDV_PedidoDataFinal() {
        return $this->PDV_PedidoDataFinal;
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

    function getPDV_PedidoDispositivoCodigo() {
        return $this->PDV_PedidoDispositivoCodigo;
    }

    function getPDV_PedidoDispositivoNroPedido() {
        return $this->PDV_PedidoDispositivoNroPedido;
    }

    function getPDV_PedidoDispositivoAltera() {
        return $this->PDV_PedidoDispositivoAltera;
    }

    function getPDV_PedidoEmEntrega() {
        return $this->PDV_PedidoEmEntrega;
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

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPDV_PedidoDescontoPerc($PDV_PedidoDescontoPerc) {
        $this->PDV_PedidoDescontoPerc = $PDV_PedidoDescontoPerc;
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

    function setPDV_PedidoConsumidorFinal($PDV_PedidoConsumidorFinal) {
        $this->PDV_PedidoConsumidorFinal = $PDV_PedidoConsumidorFinal;
    }

    function setPDV_PedidoAreaRestrita($PDV_PedidoAreaRestrita) {
        $this->PDV_PedidoAreaRestrita = $PDV_PedidoAreaRestrita;
    }

    function setPDV_PedidoTipoPagamento($PDV_PedidoTipoPagamento) {
        $this->PDV_PedidoTipoPagamento = $PDV_PedidoTipoPagamento;
    }

    function setPDV_PedidoComissaoPerc($PDV_PedidoComissaoPerc) {
        $this->PDV_PedidoComissaoPerc = $PDV_PedidoComissaoPerc;
    }

    function setPDV_PedidoTipoCod($PDV_PedidoTipoCod) {
        $this->PDV_PedidoTipoCod = $PDV_PedidoTipoCod;
    }

    function setPDV_PedidoBancoCobranca($PDV_PedidoBancoCobranca) {
        $this->PDV_PedidoBancoCobranca = $PDV_PedidoBancoCobranca;
    }

    function setPDV_PedidoCarteiraCobranca($PDV_PedidoCarteiraCobranca) {
        $this->PDV_PedidoCarteiraCobranca = $PDV_PedidoCarteiraCobranca;
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

    function setPDV_PedidoObsImp($PDV_PedidoObsImp) {
        $this->PDV_PedidoObsImp = $PDV_PedidoObsImp;
    }

    function setPDV_PedidoOrcamentoConvertido($PDV_PedidoOrcamentoConvertido) {
        $this->PDV_PedidoOrcamentoConvertido = $PDV_PedidoOrcamentoConvertido;
    }

    function setPDV_PedidoEmpreitada($PDV_PedidoEmpreitada) {
        $this->PDV_PedidoEmpreitada = $PDV_PedidoEmpreitada;
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

    function setPDV_PedidoDataFinal($PDV_PedidoDataFinal) {
        $this->PDV_PedidoDataFinal = $PDV_PedidoDataFinal;
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

    function setPDV_PedidoDispositivoCodigo($PDV_PedidoDispositivoCodigo) {
        $this->PDV_PedidoDispositivoCodigo = $PDV_PedidoDispositivoCodigo;
    }

    function setPDV_PedidoDispositivoNroPedido($PDV_PedidoDispositivoNroPedido) {
        $this->PDV_PedidoDispositivoNroPedido = $PDV_PedidoDispositivoNroPedido;
    }

    function setPDV_PedidoDispositivoAltera($PDV_PedidoDispositivoAltera) {
        $this->PDV_PedidoDispositivoAltera = $PDV_PedidoDispositivoAltera;
    }

    function setPDV_PedidoEmEntrega($PDV_PedidoEmEntrega) {
        $this->PDV_PedidoEmEntrega = $PDV_PedidoEmEntrega;
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