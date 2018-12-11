<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 20/11/2018
 */


class ControllerSTEEL_PCP_PedCarga extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_PedCarga');
        $this->setControllerDetalhe('STEEL_PCP_PedCargaItens');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $this->carregaDefault();
        
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->carregaDefault();
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }


    /*
     * Funcao para pegar valores padroes das cargas da classe STEEL_PCP_ParamVendas
     */
    public function carregaDefault(){
        $oParametros = Fabrica::FabricarController('STEEL_PCP_ParamVendas');
        
        $oParamDados = $oParametros->Persistencia->consultar();
        
        //passa os dados para o model STEEL_PCP_PedCarga
        $this->Model->setPDV_PedidoDescontoPerc($oParamDados->getPDV_PedidoDescontoPerc());
        $this->Model->setPDV_PedidoSomaFrete($oParamDados->getPDV_PedidoSomaFrete());
        $this->Model->setPDV_PedidoSomaST($oParamDados->getPDV_PedidoSomaST());
        $this->Model->setPDV_PedidoEndereco($oParamDados->getPDV_PedidoEndereco());
        $this->Model->setPDV_PedidoConsumidorFinal($oParamDados->getPDV_PedidoConsumidorFinal());
        $this->Model->setPDV_PedidoAreaRestrita($oParamDados->getPDV_PedidoAreaRestrita());
        $this->Model->setPDV_PedidoTipoPagamento($oParamDados->getPDV_PedidoTipoPagamento());
        $this->Model->setPDV_PedidoComissaoPerc($oParamDados->getPDV_PedidoComissaoPerc());
        $this->Model->setPDV_PedidoTipoCod($oParamDados->getPDV_PedidoTipoCod());
        $this->Model->setPDV_PedidoBancoCobranca($oParamDados->getPDV_PedidoBancoCobranca());
        $this->Model->setPDV_PedidoCarteiraCobranca($oParamDados->getPDV_PedidoCarteiraCobranca());
        $this->Model->setPDV_PedidoOrcamentoAno($oParamDados->getPDV_PedidoOrcamentoAno());
        $this->Model->setPDV_PedidoOrcamentoNumero($oParamDados->getPDV_PedidoOrcamentoNumero());
        $this->Model->setPDV_PedidoOrcamentoVersao($oParamDados->getPDV_PedidoOrcamentoVersao());
        $this->Model->setPDV_PedidoContadorImpressao($oParamDados->getPDV_PedidoContadorImpressao());
        $this->Model->setPDV_PedidoObsImp($oParamDados->getPDV_PedidoObsImp());
        $this->Model->setPDV_PedidoOrcamentoConvertido($oParamDados->getPDV_PedidoOrcamentoConvertido());
        $this->Model->setPDV_PedidoEmpreitada($oParamDados->getPDV_PedidoEmpreitada());
        $this->Model->setPDV_PedidoNumeroOriginal($oParamDados->getPDV_PedidoNumeroOriginal());
        $this->Model->setPDV_PedidoEmpresaOriginal($oParamDados->getPDV_PedidoEmpresaOriginal());
        $this->Model->setPDV_PedidoDimensoes($oParamDados->getPDV_PedidoDimensoes());
        $this->Model->setPDV_PedidoDataFinal($oParamDados->getPDV_PedidoDataFinal());
        $this->Model->setPDV_PedidoContato($oParamDados->getPDV_PedidoContato());
        $this->Model->setPDV_PedidoContaDeposito($oParamDados->getPDV_PedidoContaDeposito());
        $this->Model->setPDV_PedidoContaCobranca($oParamDados->getPDV_PedidoContaCobranca());
        $this->Model->setPDV_PedidoMotoristaNome($oParamDados->getPDV_PedidoMotoristaNome());
        $this->Model->setPDV_PedidoTipoFreteCodigo($oParamDados->getPDV_PedidoTipoFreteCodigo());
        $this->Model->setPDV_PedidoCondicaoPgtoCodigo($oParamDados->getPDV_PedidoCondicaoPgtoCodigo());
        $this->Model->setPDV_PedidoMoedaCodigo($oParamDados->getPDV_PedidoMoedaCodigo());
        $this->Model->setPDV_PedidoTipoEmiNF($oParamDados->getPDV_PedidoTipoEmiNF());
        $this->Model->setPDV_PedidoSituacaoAltera($oParamDados->getPDV_PedidoSituacaoAltera());
        $this->Model->setPDV_PedidoExcluido($oParamDados->getPDV_PedidoExcluido());
        $this->Model->setPDV_PedidoEmpFisJur($oParamDados->getPDV_PedidoEmpFisJur());
        $this->Model->setPDV_PedidoDispositivoCodigo($oParamDados->getPDV_PedidoDispositivoCodigo());
        $this->Model->setPDV_PedidoDispositivoNroPedido($oParamDados->getPDV_PedidoDispositivoNroPedido());
        $this->Model->setPDV_PedidoDispositivoAltera($oParamDados->getPDV_PedidoDispositivoAltera());
        $this->Model->setPDV_PedidoEmEntrega($oParamDados->getPDV_PedidoEmEntrega());
        $this->Model->setPDV_PedidoNomeSuspect($oParamDados->getPDV_PedidoNomeSuspect());
        $this->Model->setPDV_PedidoMetrosCubicos($oParamDados->getPDV_PedidoMetrosCubicos());
        $this->Model->setPDV_PedidoOrcAno($oParamDados->getPDV_PedidoOrcAno());
        $this->Model->setPDV_PedidoOrcNumero($oParamDados->getPDV_PedidoOrcNumero());
        $this->Model->setPDV_PedidoOrcVersao($oParamDados->getPDV_PedidoOrcVersao());
        $this->Model->setPDV_PedidoOperadora($oParamDados->getPDV_PedidoOperadora());
        $this->Model->setPDV_PedidoValorAdiantamento($oParamDados->getPDV_PedidoValorAdiantamento());
        $this->Model->setPDV_PedidoDiasEntrega($oParamDados->getPDV_PedidoDiasEntrega());
        $this->Model->setPDV_PedidoLiberadoParaProducao($oParamDados->getPDV_PedidoLiberadoParaProducao());
        $this->Model->setPDV_PedidoComissaoPercManual($oParamDados->getPDV_PedidoComissaoPercManual());
        $this->Model->setPDV_PedidoSimuladorVendaSeq($oParamDados->getPDV_PedidoSimuladorVendaSeq());
        $this->Model->setPDV_PedidoCRMCodigo($oParamDados->getPDV_PedidoCRMCodigo());
        $this->Model->setPDV_PedidoOperadoraBandeira($oParamDados->getPDV_PedidoOperadoraBandeira());
        $this->Model->setPDV_PedidoContratoConstrucao($oParamDados->getPDV_PedidoContratoConstrucao());
        $this->Model->setPDV_PedidoEmpAtividadeEconomic($oParamDados->getPDV_PedidoEmpAtividadeEconomic());
        $this->Model->setPDV_PedidoEmbalagem($oParamDados->getPDV_PedidoEmbalagem());
        $this->Model->setPDV_PedidoFinMovimentoSeq($oParamDados->getPDV_PedidoFinMovimentoSeq());
        $this->Model->setPDV_PedidoEmpAssociado($oParamDados->getPDV_PedidoEmpAssociado());
        $this->Model->setPDV_PedidoTipoFornecimento($oParamDados->getPDV_PedidoTipoFornecimento());
        $this->Model->setPDV_PedidoCodigoInformado($oParamDados->getPDV_PedidoCodigoInformado());
        $this->Model->setPDV_PedidoCodigoCR($oParamDados-> getPDV_PedidoCodigoCR());
        $this->Model->setPDV_PedidoCodigoAF($oParamDados->getPDV_PedidoCodigoAF());
        $this->Model->setPDV_PedidoCarenciaNegociada($oParamDados->getPDV_PedidoCarenciaNegociada());
        $this->Model->setPDV_PedidoDiasCarenciaJuros($oParamDados->getPDV_PedidoDiasCarenciaJuros());
        $this->Model->setPDV_PedidoEmbalagemManual($oParamDados->getPDV_PedidoEmbalagemManual());
        
       // observacoes
        $this->Model->setPDV_PedidoObsProducao(" ");
        $this->Model->setPDV_PedidoObs(" ");
        $this->Model->setPDV_PedidoObsFinanceiras(" ");
        
        //pega representante do cliente da carga
        $oRepCli = Fabrica::FabricarController('DELX_CAD_Pessoa');
        $oRepCli->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getPDV_PedidoEmpCodigo());
        $oDadosRep = $oRepCli->Persistencia->consultarWhere();
        $this->Model->setPDV_PedidoRepresentante($oDadosRep->getRep_codigo());
        
        //pega endereço do cliente da carga
        $oEndCli = Fabrica::FabricarController('DELX_EMP_PessoaEndereco');
        $oEndCli->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getPDV_PedidoEmpCodigo());
        $oEndCli->Persistencia->adicionaFiltro('emp_enderecoseq', "1");
        $oDadosEnd = $oEndCli->Persistencia->consultarWhere();
        $this->Model->setPDV_PedidoEnderecoLogradouro($oDadosEnd->getEmp_enderecologradouro());
        
        
        $oPedTabPreco = Fabrica::FabricarController('STEEL_PCP_TabCli');
        $oPedTabPreco->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getPDV_PedidoEmpCodigo());
        $oDadosTab = $oPedTabPreco->Persistencia->consultarWhere();
        $this->Model->setPDV_PedidoTabelaPreco($oDadosTab->getTab_preco());
                
        $this->Model->setPDV_PedidoValorTotal("0");//aguardar
        $this->Model->setPDV_PedidoCFOP(" ");//aguardar
        $this->Model->setPDV_PedidoEmpCNPJ($oDadosRep->getEmp_cnpj());
        $this->Model->setPDV_PedidoEmpIE($oDadosEnd->getEmp_enderecoinscestadual());
        $this->Model->setPDV_PedidoEmpTelefone($oDadosEnd->getEmp_enderecotelefone());
        $this->Model->setPDV_PedidoEmpFax($oDadosEnd->getEmp_enderecotelefone());
        $this->Model->setPDV_PedidoEmpConsumidorFinal("N");
        $this->Model->setPDV_PedidoEmpRaizCNPJ($oDadosRep->getEmp_cnpj());
        $this->Model->setPDV_PedidoEmpEndBairro($oDadosEnd->getEmp_enderecobairro());
        $this->Model->setPDV_PedidoEmpEndComplemento($oDadosEnd->getEmp_enderecocomplemento());
        $this->Model->setPDV_PedidoEmpEndNumero($oDadosEnd->getEmp_endereconumero());
        //buca cep
        //getCid_codigo()  //buca os dados da cidade  getCid_paiscodigo()  temos pais cep
        $oCidade = Fabrica::FabricarController('DELX_CID_Cidade');
        $oCidade->Persistencia->adicionaFiltro('cid_paiscodigo','30');
        $oCidade->Persistencia->adicionaFiltro('cid_codigo',$oDadosEnd->getCid_codigo());
        $oDadosCid = $oCidade->Persistencia->consultarWhere();
        
        
        $this->Model->setPDV_PedidoEmpEndUF($oDadosCid->getCid_estadocodigo());
        $this->Model->setPDV_PedidoEmpEndCEP($oDadosEnd->getCid_logradourocep());
        $this->Model->setPDV_PedidoEmpEndCidade($oDadosCid->getCid_descricao());
        $this->Model->setPDV_PedidoEmpEndRegCodigo("4");
        $this->Model->setPDV_PedidoEmpEndRegDescricao(" ");
        $this->Model->setPDV_PedidoEmpEndPaisCod("30");
        $this->Model->setPDV_PedidoEmpEndCidCod($oDadosCid->getCid_codigo());
        $this->Model->setPDV_PedidoEmpEmail(" ");        
        $this->Model->setPDV_PedidoRepresentanteAux("");

    }
    
    public function consultaOpDados($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //Fabrica a controller STEEL_PCP_OrdensFab e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op_base']);

            if ($oDados->getOp() == null) {
                $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo '$("#' . $aId[0] . '").val("");'
                  . '$("#' . $aId[1] . '").val("");';
            } else {
                             
                //coloca os dados na view  
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");';
            }                       
    } 
    
     public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$this->Model->getPDV_PedidoFilial());
       $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$this->Model->getPdv_pedidocodigo());
       }
    
       /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getPDV_PedidoFilial();
       $aRetorno[1]=  $this->Model->getPdv_pedidocodigo();
       return $aRetorno;
   }
   
}