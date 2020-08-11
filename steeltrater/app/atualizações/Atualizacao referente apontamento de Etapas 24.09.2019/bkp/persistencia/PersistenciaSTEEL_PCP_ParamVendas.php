<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_Parametros
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */

class PersistenciaSTEEL_PCP_ParamVendas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ParamVendas');

        $this->adicionaRelacionamento('id', 'id', true, true,true);
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('PDV_PedidoDescontoPerc', 'PDV_PedidoDescontoPerc');
        $this->adicionaRelacionamento('PDV_PedidoSomaFrete', 'PDV_PedidoSomaFrete');
        $this->adicionaRelacionamento('PDV_PedidoSomaST', 'PDV_PedidoSomaST');
        $this->adicionaRelacionamento('PDV_PedidoEndereco', 'PDV_PedidoEndereco');
        $this->adicionaRelacionamento('PDV_PedidoConsumidorFinal', 'PDV_PedidoConsumidorFinal');
        $this->adicionaRelacionamento('PDV_PedidoAreaRestrita', 'PDV_PedidoAreaRestrita');
        $this->adicionaRelacionamento('PDV_PedidoTipoPagamento', 'PDV_PedidoTipoPagamento');
        $this->adicionaRelacionamento('PDV_PedidoComissaoPerc', 'PDV_PedidoComissaoPerc');
        $this->adicionaRelacionamento('PDV_PedidoTipoCod', 'PDV_PedidoTipoCod');
        $this->adicionaRelacionamento('PDV_PedidoBancoCobranca', 'PDV_PedidoBancoCobranca');
        $this->adicionaRelacionamento('PDV_PedidoCarteiraCobranca', 'PDV_PedidoCarteiraCobranca');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoAno', 'PDV_PedidoOrcamentoAno');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoNumero', 'PDV_PedidoOrcamentoNumero');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoVersao', 'PDV_PedidoOrcamentoVersao');
        $this->adicionaRelacionamento('PDV_PedidoContadorImpressao', 'PDV_PedidoContadorImpressao');
        $this->adicionaRelacionamento('PDV_PedidoObsImp', 'PDV_PedidoObsImp');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoConvertido', 'PDV_PedidoOrcamentoConvertido');
        $this->adicionaRelacionamento('PDV_PedidoEmpreitada', 'PDV_PedidoEmpreitada');
        $this->adicionaRelacionamento('PDV_PedidoNumeroOriginal', 'PDV_PedidoNumeroOriginal');
        $this->adicionaRelacionamento('PDV_PedidoEmpresaOriginal', 'PDV_PedidoEmpresaOriginal');
        $this->adicionaRelacionamento('PDV_PedidoDimensoes', 'PDV_PedidoDimensoes');
        $this->adicionaRelacionamento('PDV_PedidoDataFinal', 'PDV_PedidoDataFinal');
        $this->adicionaRelacionamento('PDV_PedidoContaCobranca', 'PDV_PedidoContaCobranca');
        $this->adicionaRelacionamento('PDV_PedidoMotoristaNome', 'PDV_PedidoMotoristaNome');
        $this->adicionaRelacionamento('PDV_PedidoTipoFreteCodigo', 'PDV_PedidoTipoFreteCodigo');
        $this->adicionaRelacionamento('PDV_PedidoCondicaoPgtoCodigo', 'PDV_PedidoCondicaoPgtoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoMoedaCodigo', 'PDV_PedidoMoedaCodigo');
        $this->adicionaRelacionamento('PDV_PedidoTipoEmiNF', 'PDV_PedidoTipoEmiNF');
        $this->adicionaRelacionamento('PDV_PedidoSituacaoAltera', 'PDV_PedidoSituacaoAltera');
        $this->adicionaRelacionamento('PDV_PedidoExcluido', 'PDV_PedidoExcluido');
        $this->adicionaRelacionamento('PDV_PedidoEmpFisJur', 'PDV_PedidoEmpFisJur');
        $this->adicionaRelacionamento('PDV_PedidoDispositivoCodigo', 'PDV_PedidoDispositivoCodigo');        
        $this->adicionaRelacionamento('PDV_PedidoDispositivoNroPedido', 'PDV_PedidoDispositivoNroPedido');
        $this->adicionaRelacionamento('PDV_PedidoDispositivoAltera', 'PDV_PedidoDispositivoAltera');
        $this->adicionaRelacionamento('PDV_PedidoEmEntrega', 'PDV_PedidoEmEntrega');
        $this->adicionaRelacionamento('PDV_PedidoNomeSuspect', 'PDV_PedidoNomeSuspect');
        $this->adicionaRelacionamento('PDV_PedidoMetrosCubicos', 'PDV_PedidoMetrosCubicos');
        $this->adicionaRelacionamento('PDV_PedidoOrcAno', 'PDV_PedidoOrcAno');
        $this->adicionaRelacionamento('PDV_PedidoOrcNumero', 'PDV_PedidoOrcNumero');
        $this->adicionaRelacionamento('PDV_PedidoOrcVersao', 'PDV_PedidoOrcVersao');
        $this->adicionaRelacionamento('PDV_PedidoOperadora', 'PDV_PedidoOperadora');
        $this->adicionaRelacionamento('PDV_PedidoValorAdiantamento', 'PDV_PedidoValorAdiantamento');
        $this->adicionaRelacionamento('PDV_PedidoDiasEntrega', 'PDV_PedidoDiasEntrega');
        $this->adicionaRelacionamento('PDV_PedidoLiberadoParaProducao', 'PDV_PedidoLiberadoParaProducao');
        $this->adicionaRelacionamento('PDV_PedidoComissaoPercManual', 'PDV_PedidoComissaoPercManual');
        $this->adicionaRelacionamento('PDV_PedidoSimuladorVendaSeq', 'PDV_PedidoSimuladorVendaSeq');
        $this->adicionaRelacionamento('PDV_PedidoCRMCodigo', 'PDV_PedidoCRMCodigo');
        $this->adicionaRelacionamento('PDV_PedidoOperadoraBandeira', 'PDV_PedidoOperadoraBandeira');
        $this->adicionaRelacionamento('PDV_PedidoContratoConstrucao', 'PDV_PedidoContratoConstrucao');
        $this->adicionaRelacionamento('PDV_PedidoEmpAtividadeEconomic', 'PDV_PedidoEmpAtividadeEconomic');
        $this->adicionaRelacionamento('PDV_PedidoEmbalagem', 'PDV_PedidoEmbalagem');
        $this->adicionaRelacionamento('PDV_PedidoFinMovimentoSeq', 'PDV_PedidoFinMovimentoSeq');
        $this->adicionaRelacionamento('PDV_PedidoEmpAssociado', 'PDV_PedidoEmpAssociado');
        $this->adicionaRelacionamento('PDV_PedidoTipoFornecimento', 'PDV_PedidoTipoFornecimento');
        $this->adicionaRelacionamento('PDV_PedidoCodigoInformado', 'PDV_PedidoCodigoInformado');
        $this->adicionaRelacionamento('PDV_PedidoCodigoCR', 'PDV_PedidoCodigoCR');
        $this->adicionaRelacionamento('PDV_PedidoCodigoAF', 'PDV_PedidoCodigoAF');
        $this->adicionaRelacionamento('PDV_PedidoCarenciaNegociada', 'PDV_PedidoCarenciaNegociada');
        $this->adicionaRelacionamento('PDV_PedidoDiasCarenciaJuros', 'PDV_PedidoDiasCarenciaJuros');
        $this->adicionaRelacionamento('PDV_PedidoEmbalagemManual', 'PDV_PedidoEmbalagemManual');
       
        $this->setSTop('100');
        
        $this->adicionaOrderBy('id',1);
    }

}