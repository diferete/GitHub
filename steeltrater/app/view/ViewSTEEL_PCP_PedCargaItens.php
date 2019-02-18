<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 21/11/2018
 */

class ViewSTEEL_PCP_PedCargaItens extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        $this->getTela()->setSNomeGrid('detalheCargaItemSteel');
         
        $this->getTela()->setBGridResponsivo(false);
        
        $oNr = new CampoConsulta('Filial', 'PDV_PedidoFilial');
        $oCod = new CampoConsulta('Pedido', 'PDV_PedidoCodigo');
        //botao excluir
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_PedCargaItens','msgExcluirItensCarga');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
        $oBotaoExcluir->setSNomeGrid('detalheCargaItemSteel');
        
        $oOp = new CampoConsulta('Op','STEEL_PCP_CargaInsumoServ.op');
        $oOp->setILargura(50);
        $oSeq = new CampoConsulta('Seq', 'pdv_pedidoitemseq');
        $oSeq->setILargura(50);
        $oProd = new CampoConsulta('Produto','PDV_PedidoItemProduto');
        $oProd->setILargura(50);
        $oDescProd = new CampoConsulta('Desc', 'PDV_PedidoItemProdutoNomeManua');
        $oDescProd->setILargura(300);
        $oUn = new CampoConsulta('Un','PDV_PedidoItemProdutoUnidadeMa');
        $oUn->setILargura(50);
        $oQt = new CampoConsulta('Quant','PDV_PedidoItemQtdPedida',CampoConsulta::TIPO_DECIMAL);
        $oQt->setILargura(50);
        $oVlrUnir = new CampoConsulta('ValorUnit', 'PDV_PedidoItemValorUnitario',CampoConsulta::TIPO_DECIMAL);
        $oVlrUnir->setILargura(50);
        $oNcm = new CampoConsulta('NCM', 'DELX_PRO_Produtos.pro_ncm');
        $oNcm->setILargura(100);
        $oTipo = new CampoConsulta('Tipo','STEEL_PCP_CargaInsumoServ.pdv_insserv');
        $oTipo->addComparacao('RETORNO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        
        $this->getTela()->setIAltura(400);
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        
        $this->setBScrollInf(false);
        $this->addCampos($oBotaoExcluir,$oOp,$oSeq,$oProd,$oDescProd,$oUn,$oQt,$oVlrUnir,$oNcm,$oTipo);
    }
    
    function criaGridDetalhe() {
        $aIdsTela = $this->getSIdsTelas();
        parent::criaGridDetalhe($aIdsTela[6]);
       
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(400);
        $this->getOGridDetalhe()->setBGridResponsivo(false);
        $this->getOGridDetalhe()->setSNomeGrid('detalheCargaItemSteel');
        $oNr = new CampoConsulta('Filial', 'PDV_PedidoFilial');
        $oCod = new CampoConsulta('Pedido', 'PDV_PedidoCodigo') ;
       
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_PedCargaItens','msgExcluirItensCarga');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
        $oBotaoExcluir->setSNomeGrid('detalheCargaItemSteel');
        
        
        $oOp = new CampoConsulta('Op','STEEL_PCP_CargaInsumoServ.op');
        $oOp->setILargura(50);
        $oSeq = new CampoConsulta('Seq', 'pdv_pedidoitemseq');
        $oSeq->setILargura(50);
        $oProd = new CampoConsulta('Produto','PDV_PedidoItemProduto');
        $oProd->setILargura(50);
        $oDescProd = new CampoConsulta('Desc', 'PDV_PedidoItemProdutoNomeManua');
        $oDescProd->setILargura(300);
        $oUn = new CampoConsulta('Un','PDV_PedidoItemProdutoUnidadeMa');
        $oUn->setILargura(50);
        $oQt = new CampoConsulta('Quant','PDV_PedidoItemQtdPedida',CampoConsulta::TIPO_DECIMAL);
        $oQt->setILargura(50);
        $oVlrUnir = new CampoConsulta('ValorUnit', 'PDV_PedidoItemValorUnitario',CampoConsulta::TIPO_DECIMAL);
        $oVlrUnir->setILargura(50);
        $oNcm = new CampoConsulta('NCM', 'DELX_PRO_Produtos.pro_ncm');
        $oNcm->setILargura(100);
        $oTipo = new CampoConsulta('Tipo','STEEL_PCP_CargaInsumoServ.pdv_insserv');
       
        
        $this->addCamposDetalhe($oBotaoExcluir,$oOp,$oSeq,$oProd,$oDescProd,$oUn,$oQt,$oVlrUnir,$oNcm,$oTipo);
    
     
        $this->addGriTela($this->getOGridDetalhe());
        
    }

    public function criaTela() {
        parent::criaTela();
        $this->criaGridDetalhe();
        
        $aValor = $this->getAParametrosExtras();
        //traz os totalizadores dos insumos
        $sInsumo ='0';
        $sRetorno ='0';
        $sServico ='0';
        foreach ($aValor[3] as $key => $value) {
            switch ($value->pdv_insserv) {
                    case 'INSUMO':
                        $sInsumo = number_format($value->total, 2,',', '.');
                        break;
                    case 'RETORNO':
                        $sRetorno = number_format($value->total, 2,',', '.');
                        break;
                    case 'SERVIÇO':
                        $sServico = number_format($value->total, 2,',', '.');
                        break;
                }
        }
        
        
        
        $oFilial = new Campo('Filial', 'pdv_pedidofilial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilial->setSValor($aValor[0]);
        $oFilial->setBCampoBloqueado(true);
        //------------------------------------------------------------
        $oNrCarga = new Campo('CargaNº','pdv_pedidocodigo', Campo::TIPO_TEXTO,1,1,1,1);
        $oNrCarga->setBCampoBloqueado(true);
        $oNrCarga->setSValor($aValor[1]);
        //BOTÃO PARA PESQUISA
        $oBtnPesqOp = new Campo('Pesq','btn1', Campo::TIPO_BOTAOSMALL,2,2,2,2);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        //-------------------------------------------------------------
        //$oDiv = new campo('Dados da carga','div1', Campo::DIVISOR_VERMELHO,12,12,12,12);
       // $oDiv->setApenasTela(true);
          $oLinha = new campo('','linha1', Campo::TIPO_LINHA,12,12,12,12);
          $oLinha->setApenasTela(true);
        //--------------------------------------------------------------
        //CAMPO OP BASE PARA PUXAR DADOS AUTOMÁTICOS DA ORDEM DE PRODUÇÃO 
        $oOp = new Campo('Ordem Produção','op', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oOp->setApenasTela(true);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->setBFocus(true);
        $oOp->addValidacao(false, Validacao::TIPO_STRING);
        $oOp->setClasseBusca('STEEL_PCP_OrdensFabPesq');
        $oOp->setSCampoRetorno('op',$this->getTela()->getId());
        $oOp->setSIdHideEtapa($this->getSIdHideEtapa());
        
        //CAMPO SEQUÊNCIA
        $oSeq = new Campo('Seq','pdv_pedidoitemseq', Campo::TIPO_TEXTO,1);
        $oSeq->setBCampoBloqueado(true);
        //CAMPO QUE PUXA DO ITEM DA ORDEM DE PRODUÇÃO
        $oCodigo = new Campo('Produto','PDV_PedidoItemProduto', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oCodigo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodigo->setBCampoBloqueado(true);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        //----------------------------------------------------------------
        $oDescricao = new Campo('Nome Produto','PDV_PedidoItemProdutoNomeManua', Campo::TIPO_BUSCADOBANCO,4,4,4,4);
        $oDescricao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDescricao->setBCampoBloqueado(true);
        $oDescricao->setSIdPk($oCodigo->getId());
        $oDescricao->setClasseBusca('DELX_PRO_Produtos');
        $oDescricao->addCampoBusca('pro_codigo', '','');
        $oDescricao->addCampoBusca('pro_descricao', '','');
        $oDescricao->setSIdTela($this->getTela()->getId());
        $oDescricao->addValidacao(false, Validacao::TIPO_STRING);
        
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oDescricao->getId(),  $this->getTela()->getId());
        
        //----------------------------------------------------------------
        $oQtd = new Campo('Quantidade','PDV_PedidoItemQtdPedida', Campo::TIPO_DECIMAL,1,1,1,1);
        $oQtd->setSValor('0,00');
        $oQtd->setBCampoBloqueado(true);
        
        $oVlrUn = new Campo('Valor Unitário','PDV_PedidoItemValorUnitario', Campo::TIPO_DECIMAL,1,1,1,1);
        $oVlrUn->setBCampoBloqueado(true);
        
        $oTotalProduto = new Campo('Total','totalRetorno', Campo::TIPO_DECIMAL,1,1,1,1);
        $oTotalProduto->setApenasTela(true);
        $oTotalProduto->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotalProduto->setBCampoBloqueado(true);
        
        //SETA OS CAMPOS DO INSUMO QUE SERÃO GRAVADOS
        $oInsumo = new Campo('Insumo','insumoCod', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oInsumo->setApenasTela(true);
        $oInsumo->setSCorFundo(Campo::FUNDO_AZUL);
        $oInsumo->setBCampoBloqueado(true);
        $oInsumo->setSIdHideEtapa($this->getSIdHideEtapa());
       
        
        $oInsumoDes = new Campo('Nome Insumo','insumoNome', Campo::TIPO_BUSCADOBANCO,4,4,4,4);
        $oInsumoDes->setApenasTela(true);
        $oInsumoDes->setSCorFundo(Campo::FUNDO_AZUL);
        $oInsumoDes->setBCampoBloqueado(true);
        $oInsumoDes->setSIdPk($oCodigo->getId());
        $oInsumoDes->setClasseBusca('STEEL_PCP_Produtos');
        $oInsumoDes->addCampoBusca('pro_codigo', '','');
        $oInsumoDes->addCampoBusca('pro_descricao', '','');
        $oInsumoDes->setSIdTela($this->getTela()->getId());
        $oInsumoDes->addValidacao(false, Validacao::TIPO_STRING);
        
        $oInsumo->setClasseBusca('STEEL_PCP_Produtos');
        $oInsumo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oInsumo->addCampoBusca('pro_descricao',$oInsumoDes->getId(),  $this->getTela()->getId());
        
       
    
      //---------------------------------------------------------------------------------
        $oInsumoQt = new Campo('Quantidade','insumoQt', Campo::TIPO_DECIMAL,1,1,1,1);
        $oInsumoQt->setApenasTela(true);
        $oInsumoQt->setSValor('0,00');
        $oInsumoQt->setBCampoBloqueado(true);
        
        $oInsumoVlr = new Campo('Valor Unitário','insumoVlr', Campo::TIPO_DECIMAL,1,1,1,1);
        $oInsumoVlr->setApenasTela(true);
        $oInsumoVlr->setBCampoBloqueado(true);
        
        $oTotalInsumo = new Campo('Total','totalInsumo', Campo::TIPO_DECIMAL,1,1,1,1);
        $oTotalInsumo->setApenasTela(true);
        $oTotalInsumo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotalInsumo->setBCampoBloqueado(true);
       
        //-----------------------------------------------------------------
        
        //SETA OS CAMPOS DE SERVIÇO
        $oServico = new Campo('Serviço','servicoCod', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oServico->setApenasTela(true);
        $oServico->setSCorFundo(Campo::FUNDO_AZUL);
        $oServico->setBCampoBloqueado(true);
        $oServico->setSIdHideEtapa($this->getSIdHideEtapa());
        
        $oServicoDes = new Campo('Nome Serviço','servicoDes', Campo::TIPO_BUSCADOBANCO,4,4,4,4);
        $oServicoDes->setApenasTela(true);
        $oServicoDes->setSCorFundo(Campo::FUNDO_AZUL);
        $oServicoDes->setBCampoBloqueado(true);
        $oServicoDes->setSIdPk($oCodigo->getId());
        $oServicoDes->setClasseBusca('STEEL_PCP_Produtos');
        $oServicoDes->addCampoBusca('pro_codigo', '','');
        $oServicoDes->addCampoBusca('pro_descricao', '','');
        $oServicoDes->setSIdTela($this->getTela()->getId());
        $oServicoDes->addValidacao(false, Validacao::TIPO_STRING);
        
        $oServico->setClasseBusca('STEEL_PCP_Produtos');
        $oServico->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oServico->addCampoBusca('pro_descricao',$oServicoDes->getId(),  $this->getTela()->getId());
        
        
        $oServicoQt = new Campo('Quantidade','servicoQt', Campo::TIPO_DECIMAL,1,1,1,1);
        $oServicoQt->setApenasTela(true);
        $oServicoQt->setSValor('0,00');
        $oServicoQt->setBCampoBloqueado(true);
        
        $oServicoVlr = new Campo('Valor Unitário','servicoVlr', Campo::TIPO_DECIMAL,1,1,1,1);
        $oServicoVlr->setApenasTela(true);
        $oServicoVlr->setBCampoBloqueado(true);
        
        $oTotalServico = new Campo('Total','totalServico', Campo::TIPO_DECIMAL,1,1,1,1);
        $oTotalServico->setApenasTela(true);
        $oTotalServico->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotalServico->setBCampoBloqueado(true);
        
       //------------------Evento ao sair do campo op ------------------
        $sEventoOp = 'var OpSteel =  $("#'.$oOp->getId().'").val();if(OpSteel !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_PedCargaItens","buscaDadosCarga",'
                 . '"'.$oCodigo->getId().','.$oDescricao->getId().','.$oQtd->getId().','.$oVlrUn->getId().','
                . ''.$oInsumo->getId().','.$oInsumoDes->getId().','.$oInsumoQt->getId().','.$oInsumoVlr->getId().','
                . ''.$oServico->getId().','.$oServicoDes->getId().','.$oServicoQt->getId().','.$oServicoVlr->getId().','
                . ''.$oTotalProduto->getId().','.$oTotalInsumo->getId().','.$oTotalServico->getId().'");}';
        $oOp->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
        $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
        
        //totalizadores retorno peso, insumo, serviço
        
        $oRetornoTot = new Campo('RETORNO','retorno',  Campo::TIPO_BADGE,1);
        $oRetornoTot->setSEstiloBadge(Campo::BADGE_WARNING);
        $oRetornoTot->setLabel('RETORNO: '.$sRetorno);
        
        $oInsumoTot = new Campo('INSUMO','insumo',  Campo::TIPO_BADGE,1);
        $oInsumoTot->setSEstiloBadge(Campo::BADGE_WARNING);
        $oInsumoTot->setLabel('INSUMO: '.$sInsumo);
        
        $oServicoTot = new Campo('SERVIÇO','servico',  Campo::TIPO_BADGE,1);
        $oServicoTot->setSEstiloBadge(Campo::BADGE_WARNING);
        $oServicoTot->setLabel('SERVIÇO: '.$sServico);
        
        //-------------------Botão inserir-----------------------------

        $oBtnInserir = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId()); 
        $sGrid=$this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","pedAcaoDetalheIten",'
                . '"'.$this->getTela()->getId().'-form,'.$oSeq->getId().','.$sGrid.','.$oOp->getId().','
                . ''.$oRetornoTot->getId().','.$oInsumoTot->getId().','.$oServicoTot->getId().'","'.$aValor[0].','.$aValor[1].'");';
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        //------------------checkbox para liberar faturamento 
        $oFatManual = new campo('Ativa montagem manual','montaManual', Campo::TIPO_CHECK,2,2,2,2);
        $oFatManual->setApenasTela(true);
        $sFuncaoManual = 'if($("#'.$oFatManual->getId().'").is(":checked") == true){'
                . ' $("#'.$oCodigo->getId().'").attr("readonly", false);  '
                 . ' $("#'.$oCodigo->getId().'-btn").removeAttr("disabled");  '
                . ' $("#'.$oDescricao->getId().'").attr("readonly", false); '
                . ' $("#'.$oQtd->getId().'").attr("readonly", false);'
                . '$("#'.$oVlrUn->getId().'").attr("readonly", false);'
                . '$("#'.$oInsumo->getId().'").attr("readonly", false);'
                . ' $("#'.$oInsumo->getId().'-btn").removeAttr("disabled");  '
                . '$("#'.$oInsumoDes->getId().'").attr("readonly", false);'
                . '$("#'.$oInsumoQt->getId().'").attr("readonly", false);'
                . '$("#'.$oInsumoVlr->getId().'").attr("readonly", false);'
                . '$("#'.$oServico->getId().'").attr("readonly", false);'
                . ' $("#'.$oServico->getId().'-btn").removeAttr("disabled");  '
                . '$("#'.$oServicoDes->getId().'").attr("readonly", false);'
                . '$("#'.$oServicoQt->getId().'").attr("readonly", false);'
                . '$("#'.$oServicoVlr->getId().'").attr("readonly", false);}else{ '//$oDescricao
                 . ' $("#'.$oCodigo->getId().'").attr("readonly", true);  '
                . ' $("#'.$oCodigo->getId().'-btn").attr("disabled", true);  '
                . ' $("#'.$oDescricao->getId().'").attr("readonly", true); '
                . ' $("#'.$oQtd->getId().'").attr("readonly", true);'
                . '$("#'.$oVlrUn->getId().'").attr("readonly", true);'
                . '$("#'.$oInsumo->getId().'").attr("readonly", true);'
                . ' $("#'.$oInsumo->getId().'-btn").attr("disabled", true);  '
                . '$("#'.$oInsumoDes->getId().'").attr("readonly", true);'
                . '$("#'.$oInsumoQt->getId().'").attr("readonly", true);'
                . '$("#'.$oInsumoVlr->getId().'").attr("readonly", true);'
                . '$("#'.$oServico->getId().'").attr("readonly", true);'
                .' $("#'.$oServico->getId().'-btn").attr("disabled", true);  '
                . '$("#'.$oServicoDes->getId().'").attr("readonly", true);'
                . '$("#'.$oServicoQt->getId().'").attr("readonly", true);'
                . '$("#'.$oServicoVlr->getId().'").attr("readonly", true);  }';    
        $oFatManual->addEvento(Campo::EVENTO_CHANGE,$sFuncaoManual );
        
        //-----------------------monta os calculos das qt * valores
         $sEventoCalculo = 'precoMontagemCarta("'.$oQtd->getId().'","'.$oVlrUn->getId().'",'
                 . '"'.$oTotalProduto->getId().'","'.$oInsumoQt->getId().'",'
                 . '"'.$oInsumoVlr->getId().'","'.$oTotalInsumo->getId().'"'
                 . ',"'.$oServicoQt->getId().'","'.$oServicoVlr->getId().'",'
                 . '"'.$oTotalServico->getId().'");';
         

         //eventos
         $oQtd->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         $oVlrUn->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         $oInsumoQt->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         $oInsumoVlr->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         $oServicoQt->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         $oServicoVlr->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
                
        $this->addCampos(array($oFilial,$oNrCarga,$oSeq,$oOp,$oBtnPesqOp,$oFatManual),$oLinha,
                //array($oOp,$oBtnPesqOp),
                array($oCodigo,$oDescricao,$oQtd,$oVlrUn,$oTotalProduto),
                array($oInsumo,$oInsumoDes,$oInsumoQt,$oInsumoVlr,$oTotalInsumo),
                array($oServico,$oServicoDes,$oServicoQt,$oServicoVlr,$oTotalServico,$oBtnInserir),
                array($oRetornoTot,$oInsumoTot,$oServicoTot));
        
        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oFilial,$oNrCarga);
        //desabilita o botao alterar
        $this->getTela()->setBUsaAltGrid(false);
        $this->getTela()->setBUsaDelGrid(false);
    }
}