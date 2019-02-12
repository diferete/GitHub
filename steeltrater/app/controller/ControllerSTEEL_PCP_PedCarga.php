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
       //------------------------------------------------------------------------
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
        
        //define as empresas de cobrança como 0
        $this->Model->setPDV_PedidoEmpCobCodigo('0');
        $this->Model->setPDV_PedidoEmpCobEndereco('0');
        $this->Model->setPDV_PedidoEmpEntCodigo('0');
        $this->Model->setPDV_PedidoEmpEntEndereco('0');
        $this->Model->setPDV_PedidoRepresentanteAux('0');
        
        //carrega como default a cfop 5902
        $this->Model->setPDV_PedidoCFOP('5902');
        //soma o total dos itens
        $oPedItens = Fabrica::FabricarController('STEEL_PCP_PedCargaItens');
        $oPedItens->Persistencia->adicionaFiltro('pdv_pedidofilial',$this->Model->getPDV_PedidoFilial());
        $oPedItens->Persistencia->adicionaFiltro('pdv_pedidocodigo',$this->Model->getPdv_pedidocodigo());
        $iTotalItens = $oPedItens->Persistencia->getSoma('PDV_PedidoItemValorTotal');
        $this->Model->setPDV_PedidoValorTotal($iTotalItens);
        
    }
    
    public function consultaOpDados($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //Fabrica a controller STEEL_PCP_OrdensFab e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op_base']);
        
        $oTab = Fabrica::FabricarController('STEEL_PCP_TabCli');
        $oTab->Persistencia->adicionaFiltro('emp_codigo',$oDados->getEmp_codigo());
        $oTabela = $oTab->Persistencia->consultarWhere();

            if ($oDados->getOp() == null) {
                $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo '$("#' . $aId[0] . '").val("");'
                  . '$("#' . $aId[1] . '").val("");'
                  .'$("#' . $aId[2] . '").val("");';
            } else {
                             
                //coloca os dados na view  
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[2] . '").val("' . $oTabela->getTab_preco() . '");';
            }                       
    }
    
    public function verificaTabelaCliente($sDados){
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        
        
        $oTab = Fabrica::FabricarController('STEEL_PCP_TabCli');
        $oTab->Persistencia->adicionaFiltro('emp_codigo',$aCampos['PDV_PedidoEmpCodigo']);
        $oTabela = $oTab->Persistencia->consultarWhere();
        if($oTabela->getTab_preco()==null){
            $oMensagem = new Modal('Atenção.','Este cliente não tem tabela de preço cadastrada! Solicite o cadastro da tabela ao setor administrativo!', Modal::TIPO_AVISO, FALSE, true, false);
            echo $oMensagem->getRender();
            echo '$("#' . $aId[2] . '").val("");';
        } else {
             echo '$("#' . $aId[2] . '").val("' . $oTabela->getTab_preco() . '");';
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
   
   public function acaoMostraRelCarga($sDados) {
       parent::acaoMostraRelEspecifico($sDados);

       $aInfo = $_REQUEST['parametrosCampos'];
       sort($aInfo);
       
       $sVethor='';
       foreach ($aInfo as $key => $value) {
           $aValor1 = explode('=', $value);
           $aValor2 = explode('&', $aValor1[1]);
           $sVethor.= 'nCarga[]='.$aValor1[2].'&'.'pedFilial='.$aValor2[0].'&';
       }

        $sSistema ="app/relatorio";
        $sRelatorio = 'RelRomaneioCarga.php?'.$sVethor;
        
        $sCampos.= $this->getSget();
        
       $sCampos.='&output=tela';
       $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
       echo $oWindow; 

   }
   
   public function scrollFilhas($aFiltros) {
       parent::scrollFilhas($aFiltros);
       $aFiltros[1]='pdv_pedidofilial';
       return $aFiltros;
   }
   
   /**
    * Mensagem para liberar para o faturamento
    */
   
   public function msgLibFat($sDados){
            $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse();
            
            //pega os dados para validações
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCamposChave['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
            
            $this->Model = $this->Persistencia->consultarWhere();
            
            if($this->Model->getPDV_PedidoSituacao() == 'O' && $this->Model->getPDV_PedidoAprovacao()== 'O'){
                $oMensagem = new Modal('Atenção','Esta carga ja está liberada para faturamento!', Modal::TIPO_INFO, false,true,false);
                echo $oMensagem->getRender(); 
                exit();
            }
            
            if($this->Model->getPDV_PedidoSituacao() == 'T' && $this->Model->getPDV_PedidoAprovacao()=='F'){
                $oMensagem = new Modal('Atenção','Esta carga ja foi faturada!', Modal::TIPO_INFO, false,true,false);
                echo $oMensagem->getRender(); 
            }
            if($this->Model->getPDV_PedidoSituacao() == 'C' && $this->Model->getPDV_PedidoAprovacao()=='C'){
                $oMensagem = new Modal('Atenção','Esta carga foi cancelada!', Modal::TIPO_INFO, false,true,false);
                echo $oMensagem->getRender(); 
            }
            //libera a carga
            if($this->Model->getPDV_PedidoSituacao() == 'A' && $this->Model->getPDV_PedidoAprovacao()=='A'){
                $oMensagem = new Modal('Atenção','Será liberado o faturamento dessa carga!', Modal::TIPO_INFO, true,true,true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[1].'-form","' . $sClasse . '","liberaFaturamento","' . $sDados . '");');
                echo $oMensagem->getRender(); 
            }
       
       
   }
   
   /**
    * Função que irá liberar o pedido para faturamento
    */
   public function liberaFaturamento($sDados){
            $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse();
            
            
            $this->Persistencia->liberaPed($aCamposChave);
            
            $oMensagem = new Mensagem('Sucesso!','Pedido liberado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[1]."-pesq').click();"; 
   }
   
   /**
    * Mensagem para o retorno
    */
   public function msgRetornaSit($sDados){
            $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse();
            
             //pega os dados para validações
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCamposChave['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
            
            $this->Model = $this->Persistencia->consultarWhere();
            
            if($this->Model->getPDV_PedidoSituacao() == 'A' && $this->Model->getPDV_PedidoAprovacao()=='A'){
                $oMensagem = new Modal('Atenção','Esta carga não necessita ser retornada!', Modal::TIPO_INFO, false,true,false);
                echo $oMensagem->getRender(); 
            }
            
           if($this->Model->getPDV_PedidoSituacao() == 'T' && $this->Model->getPDV_PedidoAprovacao()=='F'){
                $oMensagem = new Modal('Atenção','Esta carga ja foi faturada!', Modal::TIPO_INFO, false,true,false);
                echo $oMensagem->getRender(); 
            }
            
            //libera a carga
            if($this->Model->getPDV_PedidoSituacao() == 'O' && $this->Model->getPDV_PedidoAprovacao()=='O'){
                $oMensagem = new Modal('Atenção','Será retornada a situação dessa carga!', Modal::TIPO_INFO, true,true,true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[1].'-form","' . $sClasse . '","retornaSit","' . $sDados . '");');
                echo $oMensagem->getRender(); 
            }
            
            
   }
   
   /**
    * Public function retorna situação
    */
   public function retornaSit($sDados){
           $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse();
            
            $this->Persistencia->retornaSit($aCamposChave);
            
            $oMensagem = new Mensagem('Sucesso!','Pedido retornado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[1]."-pesq').click();"; 
   }
}