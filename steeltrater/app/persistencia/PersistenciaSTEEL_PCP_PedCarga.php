<?php

/*
 * Classe que implementa a persistencia de pedCarga
 * 
 * @author Cleverton Hoffmann
 * @since 20/11/2018
 */

class PersistenciaSTEEL_PCP_PedCarga extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('pdv_pedido');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo', true, true,true);
        
        $this->adicionaRelacionamento('PDV_PedidoTipoMovimentoCodigo', 'DELX_NFS_TipoMovimento.nfs_tipomovimentocodigo',false,false);
        $this->adicionaRelacionamento('PDV_PedidoEmpCodigo','DELX_CAD_Pessoa.emp_codigo',false,false);
        $this->adicionaRelacionamento('PDV_PedidoEmpCodigo', 'PDV_PedidoEmpCodigo');
        
        $this->adicionaRelacionamento('PDV_PedidoObsProducao', 'PDV_PedidoObsProducao');
        $this->adicionaRelacionamento('PDV_PedidoObs', 'PDV_PedidoObs');
        $this->adicionaRelacionamento('PDV_PedidoObsFinanceiras', 'PDV_PedidoObsFinanceiras');
        $this->adicionaRelacionamento('PDV_PedidoDataEmissao', 'PDV_PedidoDataEmissao');
        $this->adicionaRelacionamento('PDV_PedidoTransportadorCodigo', 'PDV_PedidoTransportadorCodigo');
        $this->adicionaRelacionamento('PDV_PedidoRedespachoCodigo', 'PDV_PedidoRedespachoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoFreteRedespacho', 'PDV_PedidoFreteRedespacho');
        $this->adicionaRelacionamento('PDV_PedidoTransportadorPlaca', 'PDV_PedidoTransportadorPlaca');
        $this->adicionaRelacionamento('PDV_PedidoCamChegada', 'PDV_PedidoCamChegada');
        $this->adicionaRelacionamento('PDV_PedidoCamSaida', 'PDV_PedidoCamSaida');
        $this->adicionaRelacionamento('PDV_PedidoCamEntrada', 'PDV_PedidoCamEntrada');
        $this->adicionaRelacionamento('PDV_PedidoFreteValor', 'PDV_PedidoFreteValor');
        $this->adicionaRelacionamento('PDV_PedidoOrdemCompra', 'PDV_PedidoOrdemCompra');
        $this->adicionaRelacionamento('PDV_PedidoOrdemCompraData', 'PDV_PedidoOrdemCompraData');
        $this->adicionaRelacionamento('PDV_PedidoCpgTaxa', 'PDV_PedidoCpgTaxa');
        $this->adicionaRelacionamento('PDV_PedidoDescontoPerc', 'PDV_PedidoDescontoPerc');
        $this->adicionaRelacionamento('PDV_PedidoDescontoValor', 'PDV_PedidoDescontoValor');
        $this->adicionaRelacionamento('PDV_PedidoDataDigitacao', 'PDV_PedidoDataDigitacao');
        $this->adicionaRelacionamento('PDV_PedidoDataEntrega', 'PDV_PedidoDataEntrega');
        $this->adicionaRelacionamento('PDV_PedidoSituacao', 'PDV_PedidoSituacao');
        $this->adicionaRelacionamento('PDV_PedidoAprovacao', 'PDV_PedidoAprovacao');
        $this->adicionaRelacionamento('PDV_PedidoSomaFrete', 'PDV_PedidoSomaFrete');
        $this->adicionaRelacionamento('PDV_PedidoSomaST', 'PDV_PedidoSomaST');
        $this->adicionaRelacionamento('PDV_PedidoEndereco', 'PDV_PedidoEndereco');
        $this->adicionaRelacionamento('PDV_PedidoLocalEntrega', 'PDV_PedidoLocalEntrega');
        $this->adicionaRelacionamento('PDV_PedidoConsumidorFinal', 'PDV_PedidoConsumidorFinal');
        $this->adicionaRelacionamento('PDV_PedidoAreaRestrita', 'PDV_PedidoAreaRestrita');
        $this->adicionaRelacionamento('PDV_PedidoTipoPagamento', 'PDV_PedidoTipoPagamento');
        $this->adicionaRelacionamento('PDV_PedidoBancoDeposito', 'PDV_PedidoBancoDeposito');
        $this->adicionaRelacionamento('PDV_PedidoComissaoPerc', 'PDV_PedidoComissaoPerc');
        $this->adicionaRelacionamento('PDV_PedidoTipoCod', 'PDV_PedidoTipoCod');
        $this->adicionaRelacionamento('PDV_PedidoValidade', 'PDV_PedidoValidade');
        $this->adicionaRelacionamento('PDV_PedidoBancoCobranca', 'PDV_PedidoBancoCobranca');
        $this->adicionaRelacionamento('PDV_PedidoCarteiraCobranca', 'PDV_PedidoCarteiraCobranca');
        $this->adicionaRelacionamento('PDV_PedidoValorDevolucao', 'PDV_PedidoValorDevolucao');
        $this->adicionaRelacionamento('PDV_PedidoDataProducao', 'PDV_PedidoDataProducao');
        $this->adicionaRelacionamento('PDV_PedidoEspecie', 'PDV_PedidoEspecie');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoAno', 'PDV_PedidoOrcamentoAno');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoNumero', 'PDV_PedidoOrcamentoNumero');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoVersao', 'PDV_PedidoOrcamentoVersao');
        $this->adicionaRelacionamento('PDV_PedidoContadorImpressao', 'PDV_PedidoContadorImpressao');
        $this->adicionaRelacionamento('PDV_PedidoValorAcrescimo', 'PDV_PedidoValorAcrescimo');
        $this->adicionaRelacionamento('PDV_PedidoUsuario', 'PDV_PedidoUsuario');
        $this->adicionaRelacionamento('PDV_PedidoClassificacao', 'PDV_PedidoClassificacao');
        $this->adicionaRelacionamento('PDV_PedidoObsImp', 'PDV_PedidoObsImp');
        $this->adicionaRelacionamento('PDV_PedidoOrcamentoConvertido', 'PDV_PedidoOrcamentoConvertido');
        $this->adicionaRelacionamento('PDV_PedidoEmpresaCobranca', 'PDV_PedidoEmpresaCobranca');
        $this->adicionaRelacionamento('PDV_PedidoSeguroFrete', 'PDV_PedidoSeguroFrete');
        $this->adicionaRelacionamento('PDV_PedidoDescontoAcrescimo', 'PDV_PedidoDescontoAcrescimo');
        $this->adicionaRelacionamento('PDV_PedidoEmpreitada', 'PDV_PedidoEmpreitada');
        $this->adicionaRelacionamento('PDV_PedidoMotoristaCodigo', 'PDV_PedidoMotoristaCodigo');
        $this->adicionaRelacionamento('PDV_PedidoNumeroOriginal', 'PDV_PedidoNumeroOriginal');
        $this->adicionaRelacionamento('PDV_PedidoEmpresaOriginal', 'PDV_PedidoEmpresaOriginal');
        $this->adicionaRelacionamento('PDV_PedidoDimensoes', 'PDV_PedidoDimensoes');
        $this->adicionaRelacionamento('PDV_PedidoProjetoFilial', 'PDV_PedidoProjetoFilial');
        $this->adicionaRelacionamento('PDV_PedidoProjetoCodigo', 'PDV_PedidoProjetoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoUFEmbarque', 'PDV_PedidoUFEmbarque');
        $this->adicionaRelacionamento('PDV_PedidoLocalEmbarque', 'PDV_PedidoLocalEmbarque');
        $this->adicionaRelacionamento('PDV_PedidoDataFinal','PDV_PedidoDataFinal');
        $this->adicionaRelacionamento('PDV_PedidoInfGerais', 'PDV_PedidoInfGerais');
        $this->adicionaRelacionamento('PDV_PedidoDespesasAcessorias', 'PDV_PedidoDespesasAcessorias');
        $this->adicionaRelacionamento('PDV_PedidoRepresentante', 'PDV_PedidoRepresentante');
        $this->adicionaRelacionamento('PDV_PedidoEnderecoLogradouro', 'PDV_PedidoEnderecoLogradouro');
        $this->adicionaRelacionamento('PDV_PedidoTabelaPreco', 'PDV_PedidoTabelaPreco');
        $this->adicionaRelacionamento('PDV_PedidoContato', 'PDV_PedidoContato');
        $this->adicionaRelacionamento('PDV_PedidoContaDeposito', 'PDV_PedidoContaDeposito');
        $this->adicionaRelacionamento('PDV_PedidoContaCobranca', 'PDV_PedidoContaCobranca');
        $this->adicionaRelacionamento('PDV_PedidoMotoristaNome', 'PDV_PedidoMotoristaNome');
        $this->adicionaRelacionamento('PDV_PedidoTipoFreteCodigo', 'PDV_PedidoTipoFreteCodigo');
        $this->adicionaRelacionamento('PDV_PedidoCondicaoPgtoCodigo', 'PDV_PedidoCondicaoPgtoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoMoedaCodigo', 'PDV_PedidoMoedaCodigo');
        $this->adicionaRelacionamento('PDV_PedidoTipoMovimentoCodigo', 'PDV_PedidoTipoMovimentoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoValorTotal', 'PDV_PedidoValorTotal');
        $this->adicionaRelacionamento('PDV_PedidoCFOP', 'PDV_PedidoCFOP');
        $this->adicionaRelacionamento('PDV_PedidoTipoEmiNF', 'PDV_PedidoTipoEmiNF');
        $this->adicionaRelacionamento('PDV_PedidoSituacaoAltera', 'PDV_PedidoSituacaoAltera');
        $this->adicionaRelacionamento('PDV_PedidoExcluido', 'PDV_PedidoExcluido');
        $this->adicionaRelacionamento('PDV_PedidoEmpFisJur', 'PDV_PedidoEmpFisJur');
        $this->adicionaRelacionamento('PDV_PedidoEmpCNPJ', 'PDV_PedidoEmpCNPJ');
        $this->adicionaRelacionamento('PDV_PedidoEmpIE', 'PDV_PedidoEmpIE');
        $this->adicionaRelacionamento('PDV_PedidoEmpTelefone', 'PDV_PedidoEmpTelefone');
        $this->adicionaRelacionamento('PDV_PedidoEmpFax', 'PDV_PedidoEmpFax');
        $this->adicionaRelacionamento('PDV_PedidoEmpConsumidorFinal', 'PDV_PedidoEmpConsumidorFinal');
        $this->adicionaRelacionamento('PDV_PedidoEmpRaizCNPJ', 'PDV_PedidoEmpRaizCNPJ');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndBairro', 'PDV_PedidoEmpEndBairro');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndComplemento', 'PDV_PedidoEmpEndComplemento');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndNumero', 'PDV_PedidoEmpEndNumero');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndUF', 'PDV_PedidoEmpEndUF');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndCEP', 'PDV_PedidoEmpEndCEP');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndCidade', 'PDV_PedidoEmpEndCidade');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndRegCodigo', 'PDV_PedidoEmpEndRegCodigo');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndRegDescricao', 'PDV_PedidoEmpEndRegDescricao');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndPaisCod', 'PDV_PedidoEmpEndPaisCod');
        $this->adicionaRelacionamento('PDV_PedidoEmpEndCidCod', 'PDV_PedidoEmpEndCidCod');
        $this->adicionaRelacionamento('PDV_PedidoEmpEmail', 'PDV_PedidoEmpEmail');
        $this->adicionaRelacionamento('PDV_PedidoCentroCusto', 'PDV_PedidoCentroCusto');
        $this->adicionaRelacionamento('PDV_PedidoPrazoEntrega', 'PDV_PedidoPrazoEntrega');
        $this->adicionaRelacionamento('PDV_PedidoDispositivoCodigo', 'PDV_PedidoDispositivoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoDispositivoNroPedido', 'PDV_PedidoDispositivoNroPedido');
        $this->adicionaRelacionamento('PDV_PedidoDispositivoAltera', 'PDV_PedidoDispositivoAltera');
        $this->adicionaRelacionamento('PDV_TipoCustoCodigo', 'PDV_TipoCustoCodigo');
        $this->adicionaRelacionamento('PDV_PedidoEmpCobCodigo', 'PDV_PedidoEmpCobCodigo');
        $this->adicionaRelacionamento('PDV_PedidoEmpCobEndereco', 'PDV_PedidoEmpCobEndereco');
        $this->adicionaRelacionamento('PDV_PedidoEmpEntCodigo', 'PDV_PedidoEmpEntCodigo');
        $this->adicionaRelacionamento('PDV_PedidoEmpEntEndereco', 'PDV_PedidoEmpEntEndereco');
        $this->adicionaRelacionamento('PDV_PedidoRepresentanteAux', 'PDV_PedidoRepresentanteAux');
        $this->adicionaRelacionamento('PDV_PedidoEmEntrega', 'PDV_PedidoEmEntrega');
        $this->adicionaRelacionamento('PDV_PedidoValorMontagem', 'PDV_PedidoValorMontagem');
        $this->adicionaRelacionamento('PDV_PedidoValorFreteAux', 'PDV_PedidoValorFreteAux');
        $this->adicionaRelacionamento('PDV_PedidoPesoBruto', 'PDV_PedidoPesoBruto');
        $this->adicionaRelacionamento('PDV_PedidoPesoLiquido', 'PDV_PedidoPesoLiquido');
        $this->adicionaRelacionamento('PDV_PedidoVolumes', 'PDV_PedidoVolumes');
        $this->adicionaRelacionamento('PDV_PedidoMarca', 'PDV_PedidoMarca');
        $this->adicionaRelacionamento('PDV_PedidoNumeracaoVolumes', 'PDV_PedidoNumeracaoVolumes');
        $this->adicionaRelacionamento('PDV_PedidoNumeroFardos', 'PDV_PedidoNumeroFardos');
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
        $this->adicionaRelacionamento('PDV_PedidoVendaCli', 'PDV_PedidoVendaCli');
        $this->adicionaRelacionamento('PDV_PedidoIndicadorPresenca', 'PDV_PedidoIndicadorPresenca');
        $this->adicionaRelacionamento('PDV_PedidoContratoConstrucao', 'PDV_PedidoContratoConstrucao');
        $this->adicionaRelacionamento('PDV_PedidoEmpAtividadeEconomic', 'PDV_PedidoEmpAtividadeEconomic');
        $this->adicionaRelacionamento('PDV_PedidoEmbalagem', 'PDV_PedidoEmbalagem');
        $this->adicionaRelacionamento('PDV_PedidoFinMovimentoSeq', 'PDV_PedidoFinMovimentoSeq');
        $this->adicionaRelacionamento('PDV_PedidoTipoVendaCod', 'PDV_PedidoTipoVendaCod');
        $this->adicionaRelacionamento('PDV_PedidoEmpAssociado', 'PDV_PedidoEmpAssociado');
        $this->adicionaRelacionamento('PDV_PedidoTipoFornecimento', 'PDV_PedidoTipoFornecimento');
        $this->adicionaRelacionamento('PDV_PedidoCodigoInformado', 'PDV_PedidoCodigoInformado');
        $this->adicionaRelacionamento('PDV_PedidoCodigoCR', 'PDV_PedidoCodigoCR');
        $this->adicionaRelacionamento('PDV_PedidoCodigoAF', 'PDV_PedidoCodigoAF');
        $this->adicionaRelacionamento('PDV_PedidoCarenciaNegociada', 'PDV_PedidoCarenciaNegociada');
        $this->adicionaRelacionamento('PDV_PedidoDiasCarenciaJuros', 'PDV_PedidoDiasCarenciaJuros');
        $this->adicionaRelacionamento('PDV_PedidoEmbalagemManual', 'PDV_PedidoEmbalagemManual');
        
        
        

        $this->setSTop('50');
        
        $this->adicionaJoin('DELX_CAD_Pessoa',null,1,'PDV_PedidoEmpCodigo','emp_codigo');
        $this->adicionaJoin('DELX_NFS_TipoMovimento', null,1, 'PDV_PedidoTipoMovimentoCodigo','nfs_tipomovimentocodigo');
        $this->adicionaOrderBy('pdv_pedidocodigo',1);
    }
    
    public function afterInsert($aCampos) {
        parent::afterInsert($aCampos);
        
        $sSql ="update tec_sequencia set tec_sequencianumero = ".$aCampos['pdv_pedidocodigo']." "
               ."where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='PDV_PEDIDO'";
       
        $this->executaSql($sSql);
    }
    
    /**
     * Função para gerar o totalizador no cabeçalho do pedido
     */
    public function geraTotaliza($iTotal,$aCampos){
       
        
        $sSql = "UPDATE " . $this->getTabela() . " SET PDV_PedidoValorTotal = ".$iTotal." "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql);
        
        
    }
    
    /**
     * Libera o pedido para faturamento
     */
    public function liberaPed($aCampos){
        $sSql = "UPDATE pdv_pedido SET PDV_PedidoSituacao = 'O', PDV_PedidoAprovacao = 'O' "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql);
        $sSql = "UPDATE pdv_pedidoitem SET PDV_PedidoItemSituacao = 'O', PDV_PedidoItemAprovacao = 'O' "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql);
        
       
    }
    
    /**
     * retorna situacao
     */
    public function retornaSit($aCampos){
        $sSql = "UPDATE pdv_pedido SET PDV_PedidoSituacao = 'A', PDV_PedidoAprovacao = 'A' "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql);
        $sSql = "UPDATE pdv_pedidoitem SET PDV_PedidoItemSituacao = 'A', PDV_PedidoItemAprovacao = 'A' "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql);
        
       
    }
    
     /**
     * atualiza pesos do cabeçalho de pedido
     */
    public function atualizaPeso($aCampos,$iPesoLiq,$iVolumes,$sEmpcod){
        $oCaixa = Fabrica::FabricarController('STEEL_PCP_PesoCaixas');
        $oCaixa->Persistencia->adicionaFiltro('empcodigo',$sEmpcod);
        $oDadosCaixa = $oCaixa->Persistencia->consultarWhere();
        
        $iPesoCaixa = $oDadosCaixa->getPeso();
        $iTotalCaixa = $iPesoCaixa * $iVolumes;
        $iPesoBruto = $iTotalCaixa + $iPesoLiq; 
        
        
        $sSql = "UPDATE pdv_pedido SET PDV_PedidoPesoLiquido = '".$iPesoLiq."', PDV_PedidoPesoBruto='".$iPesoBruto."', PDV_PedidoVolumes ='".$iVolumes."' "
                . "WHERE pdv_pedidofilial ='".$aCampos['pdv_pedidofilial']."' and pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'";
        
        $this->executaSql($sSql); 
    }
     /**
     * atualiza pesos do cabeçalho de pedido
     */
    public function buscaPeso($aCampos){
        $sSql = "select coalesce(sum(pesoOp),0)as pesoliquido 
                from pdv_pedidoitem left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.pdv_pedidofilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.pdv_pedidocodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.pdv_pedidoitemseq = STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                where pdv_pedidoitem.pdv_pedidofilial = '8993358000174' 
                and pdv_pedidoitem.pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'
                and pdv_insserv = 'RETORNO'";
        //COALESCE(SUM(Price),0)
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        return $row->pesoliquido;
    }
    
    /**
     * Busca o total de volumes retornados
     */
    public function retornaVolumes($aCampos){
        $sSql = " select count(*) as volumes 
		from pdv_pedidoitem left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.pdv_pedidofilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.pdv_pedidocodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.pdv_pedidoitemseq = STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                where pdv_pedidoitem.pdv_pedidofilial = '8993358000174' 
                and pdv_pedidoitem.pdv_pedidocodigo ='".$aCampos['pdv_pedidocodigo']."'
                and pdv_insserv = 'RETORNO'";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        return $row->volumes;
    }
}
