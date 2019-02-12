<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/11/2018
 */


class ControllerSTEEL_PCP_PedCargaItens extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_PedCargaItens');
    }
    
     public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        //vai totalizar os insumos
        $aInsumos = $this->Persistencia->pesoInsumo($aChave);
        $aChave[3]=$aInsumos;
        $this->View->setAParametrosExtras($aChave);
        
        }
        
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
          
          $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aparam[0]);
          $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aparam[1]);
          
            }  else {
          $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aparam1[0]);
          $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aparam1[1]);
          $this->Persistencia->setChaveIncremento(false); 
        }
        
}
    
    public function buscaDadosCarga($sDados){
        $aId = explode(',', $sDados);
        /*0=codigo
          1=descricao
          2=quantidade
          3=valorun
          
          4=insumo
          5=insumodes
          6=insumoQt
          7=insumoVlr
          
          8=servico
          9=servicoDes
          10=ServicoQt
          11=ServicoVlr
         
         */
      
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        
        //monta mvc do cabecalho
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCampos['pdv_pedidocodigo']);
        $oPevCabDados = $oPevCab->Persistencia->consultarWhere();
        
        //busca a tabela do cliente
        $oTabCli = Fabrica::FabricarController('STEEL_PCP_TabCli');
        $oTabCli->Persistencia->adicionaFiltro('emp_codigo',$oPevCabDados->getPDV_PedidoEmpCodigo());
        $oTabCliDados = $oTabCli->Persistencia->consultarWhere();
        
        //instancia a tabela de preco
        $oTabPreco = Fabrica::FabricarController('DELX_TPV_TabelaPrecoProduto');
        

        //Fabrica a controller STEEL_PCP_OrdensFab e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpSteel->Persistencia->adicionaFiltro('op',$aCampos['op']);
        $oOpSteel->Persistencia->adicionaFiltro('emp_codigo',$oPevCabDados->getPDV_PedidoEmpCodigo());
        $iNrOp = $oOpSteel->Persistencia->getCount();
        if($iNrOp > 0){
            //busca produto, quant, valor, verifica quando é arame
            $aDadosTela = array();
            $oDadosOp = $oOpSteel->Persistencia->consultarWhere();
            $aDadosTela['ProdutoFinal'] = $oDadosOp->getProdFinal();
            $aDadosTela['ProdutoFinalDes'] =$oDadosOp->getProdesFinal();
            $aDadosTela['Quant'] = $oDadosOp->getQuant();
            $aDadosTela['ValorEnt'] = $oDadosOp->getVlrNfEntUnit();
           // $aDadosTela['TotalRetorno']=$oDadosOp->getQuant()*$oDadosOp->getVlrNfEnt();
            //busca o insumo
            $oReceita = Fabrica::FabricarController('STEEL_PCP_Receitas');
            $oReceita->Persistencia->adicionaFiltro('cod',$oDadosOp->getReceita());
            $oReceitaDados = $oReceita->Persistencia->consultarWhere();
            $aDadosTela['codInsumo'] = $oReceitaDados->getCodInsumo(); 
            
            //busca descrição do insumo
            $oProd = Fabrica::FabricarController('DELX_PRO_Produtos');
            $oProd->Persistencia->adicionaFiltro('pro_codigo',$oReceitaDados->getCodInsumo());
            $oProdDados = $oProd->Persistencia->consultarWhere();
            $aDadosTela['insumoDes'] = $oProdDados->getPro_descricao();
            
            //busca preço do insumo
            $oTabPreco->Persistencia->limpaFiltro();
            $oTabPreco->Persistencia->adicionaFiltro('tpv_codigo',$oTabCliDados->getTab_preco());
            $oTabPreco->Persistencia->adicionaFiltro('tpv_produtocodigo',$aDadosTela['codInsumo']);
            $oTabPrecoDados = $oTabPreco->Persistencia->consultarWhere();
            $aDadosTela['insumoQt'] =$oDadosOp->getPeso();
            if($oTabPrecoDados->getTpv_produtopreco()==null || $oTabPrecoDados->getTpv_produtopreco()==0){
                   $oMensagemPreco = new Mensagem('Atenção!','O item '.$aDadosTela['codInsumo'].' não tem preço cadastrado! Solicite o cadastro '
                           . ' junto ao administrativo.', Mensagem::TIPO_ERROR);
                   echo $oMensagemPreco->getRender();
               }
            $aDadosTela['insumoVlr']=$oTabPrecoDados->getTpv_produtopreco();
            
            
            //analisa o código do serviço se é metalbo
            if($oDadosOp->getEmp_codigo()=='75483040000211'){
                $oMensagemMetalbo = new Mensagem('Cliente Metalbo!','Será carregado código serviço da Metalbo', Mensagem::TIPO_INFO);
                echo $oMensagemMetalbo->getRender();
                $aDadosTela['codServ']=$oReceitaDados->getCodServMet();
                $oProd->Persistencia->limpaFiltro();
                $oProd->Persistencia->adicionaFiltro('pro_codigo',$oReceitaDados->getCodServMet());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['codServDes'] = $oProdDados->getPro_descricao();
                //busca preço do insumo
               $oTabPreco->Persistencia->limpaFiltro();
               $oTabPreco->Persistencia->adicionaFiltro('tpv_codigo',$oTabCliDados->getTab_preco());
               $oTabPreco->Persistencia->adicionaFiltro('tpv_produtocodigo',$aDadosTela['codServ']);
               $oTabPrecoDados = $oTabPreco->Persistencia->consultarWhere();
               $aDadosTela['ServicoQt'] =$oDadosOp->getPeso();
               if($oTabPrecoDados->getTpv_produtopreco()==null || $oTabPrecoDados->getTpv_produtopreco()==0){
                   $oMensagemPreco = new Mensagem('Atenção!','O item '.$aDadosTela['codServ'].' não tem preço cadastrado! Solicite o cadastro '
                           . ' junto ao administrativo.', Mensagem::TIPO_ERROR);
                   echo $oMensagemPreco->getRender();
               }
               $aDadosTela['ServicoVlr']=$oTabPrecoDados->getTpv_produtopreco();
             }else {
                $aDadosTela['codServ']=$oReceitaDados->getCodServ();
                $oProd->Persistencia->limpaFiltro();
                $oProd->Persistencia->adicionaFiltro('pro_codigo',$oReceitaDados->getCodServ());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['codServDes'] = $oProdDados->getPro_descricao();
                //busca preço do insumo
               $oTabPreco->Persistencia->limpaFiltro();
               $oTabPreco->Persistencia->adicionaFiltro('tpv_codigo',$oTabCliDados->getTab_preco());
               $oTabPreco->Persistencia->adicionaFiltro('tpv_produtocodigo',$aDadosTela['codServ']);
               $oTabPrecoDados = $oTabPreco->Persistencia->consultarWhere();
               $aDadosTela['ServicoQt'] ='1';
               if($oTabPrecoDados->getTpv_produtopreco()==null || $oTabPrecoDados->getTpv_produtopreco()==0){
                   $oMensagemPreco = new Mensagem('Atenção!','O item '.$aDadosTela['codServ'].' não tem preço cadastrado! Solicite o cadastro '
                           . ' junto ao administrativo.', Mensagem::TIPO_ERROR);
                   echo $oMensagemPreco->getRender();
               }
               $aDadosTela['ServicoVlr']=$oTabPrecoDados->getTpv_produtopreco(); 
            }
            
            
            //seta o valor na tela
            $this->setaValorTela($aDadosTela,$aId);
            
        }else{
            $oMensagem = new Modal('Atenção!','Esta ordem de produção não existe ou não pertence a empresa da carga, '
                    . 'verifique o número da ordem de produção!', Modal::TIPO_AVISO, false, true);
            echo $oMensagem->getRender();
             echo '$("#' . $aId[0] . '").val("");'
         . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("0,00");'
                . '$("#' . $aId[3] . '").val("0,00");'
                . '$("#' . $aId[4] . '").val("");'
                . '$("#' . $aId[5] . '").val("");'
                . '$("#' . $aId[6] . '").val("");'
                . '$("#' . $aId[7] . '").val("");'
                . '$("#' . $aId[8] . '").val("");'
                . '$("#' . $aId[9] . '").val("");'
                . '$("#' . $aId[10] . '").val("");'
                . '$("#' . $aId[11] . '").val("");';
        }
    }
    /**
     * Seta o valor na tela 
     */
    public function setaValorTela($aDadosTela,$aId){
         /*0=codigo
          1=descricao
          2=quantidade
          3=valorun
          
          4=insumo
          5=insumodes
          6=insumoQt
          7=insumoVlr
          
          8=servico
          9=servicoDes
          10=ServicoQt
          11=ServicoVlr
         
         */
        
    echo '$("#' . $aId[0] . '").val("'.$aDadosTela['ProdutoFinal'].'");'
         . '$("#' . $aId[1] . '").val("'.$aDadosTela['ProdutoFinalDes'].'");'
                . '$("#' . $aId[2] . '").val("' . number_format($aDadosTela['Quant'], 2, ',', '.'). '");'
                . '$("#' . $aId[3] . '").val("' .number_format($aDadosTela['ValorEnt'], 2, ',', '.'). '");'
                . '$("#' . $aId[4] . '").val("'.$aDadosTela['codInsumo'].'");'
                . '$("#' . $aId[5] . '").val("' .$aDadosTela['insumoDes']. '");'
                . '$("#' . $aId[6] . '").val("' .number_format($aDadosTela['insumoQt'], 2, ',', '.'). '");'
                . '$("#' . $aId[7] . '").val("' .number_format($aDadosTela['insumoVlr'], 2, ',', '.'). '");'
                . '$("#' . $aId[8] . '").val("' .$aDadosTela['codServ']. '");'
                . '$("#' . $aId[9] . '").val("' .$aDadosTela['codServDes']. '");'
                . '$("#' . $aId[10] . '").val("' .number_format($aDadosTela['ServicoQt'], 2, ',', '.'). '");'
                . '$("#' . $aId[11] . '").val("' .number_format($aDadosTela['ServicoVlr'], 2, ',', '.'). '");';
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        
        $this->Model->setPDV_PedidoItemQtdPedida(number_format($this->Model->getPDV_PedidoItemQtdPedida(), 2, ',', '.'));
        $this->Model->setPDV_PedidoItemValorUnitario(number_format($this->Model->getPDV_PedidoItemValorUnitario(), 2, ',', '.'));
        //number_format($this->Model->getPDV_PedidoItemValorUnitario($PDV_PedidoItemValorUnitario), 2, ',', '.')
        
        return $aCampos;
    }
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
           $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
          
        }
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
    /**
     * Recebe os dados para analisar se altera ou insere um novo registro
     * @param type $sDados
     * @param type $sCampos
     */
    public function pedAcaoDetalheIten($sDados, $sCampos) {
        //adiciona filtro da chave primária
        $this->parametros = $sCampos;
        //carrega o model
        $this->carregaModel();
        $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $this->Model->getPdv_PedidoFilial());
        $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $this->Model->getPdv_pedidocodigo());
        $this->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $this->Model->getPdv_pedidoitemseq());
        
        $iCont = $this->Persistencia->getCount();
                
        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //verifica se há validacao no lado do servidor
        $this->getVal($sDados . ',' . $iCont);
        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //se cont = 0 segue ação incluir
        if ($iCont == 0) {
            $this->acaoIncluirDetSteel($sDados, $sCampos);
        } else {
            $this->acaoAlterarDetSteel($sDados, $sCampos);
        }
    }
    
   
    
    /**
     * Método para incluir dados nas tabelas detalhe
     */
    public function acaoIncluirDetSteel($sId, $sCampos) {  
        $aChave = explode(',',$sCampos);
        $aDados = explode(',', $sId);
        $this->parametros = $sCampos;
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        //adiciona filtros extras
        $this->adicionaFiltrosExtras();
        //necessidade de colocar novos filtros mas limpa os anteriores
        $this->adicionaFiltroDet2();

        //traz lista campos
        $this->View->criaTela();
        $aCamposTela = $this->View->getTela()->getCampos();
        $this->carregaModel($aCamposTela);
        
        
        //Método que pega os valores dos campos da tela e joga em um array
        parse_str($_REQUEST['campos'], $aCampos);
        
        
        //função que seta os valores padrões 
        $this->setaPadraoItem();
        //monta mvc produtos
        $oProdUn = Fabrica::FabricarController('DELX_PRO_Produtos');
        //monta mvc do cabecalho
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCampos['pdv_pedidocodigo']);
        
        
        //valida se há algum valor zerado
        $this->validaZero($aCampos);
        
        //DEFINE O ARRAY PARA CONTROLAR OS SERVIÇOS E INSUMOS
        //$aInsumosServ = array('RETORNO','INSUMO','SERVIÇO');
       // $aInsumosServ = array('SERVIÇO','INSUMO','RETORNO');
        $aInsumosServ = array('RETORNO','INSUMO','SERVIÇO');
        foreach ($aInsumosServ as $key => $value) {
            
            switch ($value){
            case "INSUMO":    
                
                $this->Model->setPDV_PedidoItemProduto($aCampos['insumoCod']);
                $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['insumoNome']);
                $this->Model->setPDV_PedidoItemQtdPedida($this->ValorSql($aCampos['insumoQt']));
                $this->Model->setPDV_PedidoItemValorUnitario($this->ValorSql($aCampos['insumoVlr']));
                $this->Model->setOp($aCampos['op']);
                $this->Model->setPdv_insserv($value);
                
                //define a CFOP do retorno por hora vamos no tipo = do movimento
                $this->Model->setPDV_PedidoItemCFOP('5902');
                
                //busca a unidade de medida
                $oProdUn->Persistencia->limpaFiltro();
                $oProdUn->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getPDV_PedidoItemProduto());
                $oProdDados = $oProdUn->Persistencia->consultarWhere();
                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());
                
                 //seta valores específicos do retorno da mercadoria
                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                $this->Model->setPDV_PedidoItemConsideraVenda('N');
                
                //gera o valor total
                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                $ValorTotal = ($Qt*$ValorUni);
                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);
                
                //pega o valor do item na tabela de preço
                 $oPevCabDados = $oPevCab->Persistencia->consultarWhere();
                //insere os filtros
                $this->insereFiltrosInsert();
               
            break;
            case "SERVIÇO":
                
                $this->Model->setPDV_PedidoItemProduto($aCampos['servicoCod']);
                $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['servicoDes']);
                $this->Model->setPDV_PedidoItemQtdPedida($this->ValorSql($aCampos['servicoQt']));
                $this->Model->setPDV_PedidoItemValorUnitario($this->ValorSql($aCampos['servicoVlr']));
                $this->Model->setOp($aCampos['op']);
                $this->Model->setPdv_insserv($value);
                
                //define a CFOP do retorno por hora vamos no tipo = do movimento
                $this->Model->setPDV_PedidoItemCFOP('5902');
                
                 //busca a unidade de medida
                $oProdUn->Persistencia->limpaFiltro();
                $oProdUn->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getPDV_PedidoItemProduto());
                $oProdDados = $oProdUn->Persistencia->consultarWhere();
                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());
                
                //seta valores específicos do retorno da mercadoria
                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                $this->Model->setPDV_PedidoItemConsideraVenda('N');
                
                //gera o valor total
                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                $ValorTotal = ($Qt*$ValorUni);
                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);
                
                
                
                //insere os filtros
                $this->insereFiltrosInsert();
            break;  
            case "RETORNO":
                
                $this->Model->setPDV_PedidoItemProduto($aCampos['PDV_PedidoItemProduto']);
                $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['PDV_PedidoItemProdutoNomeManua']);
                $this->Model->setPDV_PedidoItemQtdPedida($this->ValorSql($aCampos['PDV_PedidoItemQtdPedida']));
                $this->Model->setPDV_PedidoItemValorUnitario($this->ValorSql($aCampos['PDV_PedidoItemValorUnitario']));
                $this->Model->setOp($aCampos['op']);
                $this->Model->setPdv_insserv($value);
                
                //define a CFOP do retorno por hora vamos no tipo = do movimento
                $this->Model->setPDV_PedidoItemCFOP('5902');
                
                 //busca a unidade de medida
                $oProdUn->Persistencia->limpaFiltro();
                $oProdUn->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getPDV_PedidoItemProduto());
                $oProdDados = $oProdUn->Persistencia->consultarWhere();
                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());
                
                //seta valores específicos do retorno da mercadoria
                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                $this->Model->setPDV_PedidoItemGeraFinanceiro('N');
                $this->Model->setPDV_PedidoItemConsideraVenda('N');
                
                //gera o valor total
                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                $ValorTotal = ($Qt*$ValorUni);
                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);
                
                //insere os filtros
                $this->insereFiltrosInsert();
                
            break;
            }

            $this->Persistencia->iniciaTransacao();

            //array de controle de erros
            $aRetorno[0] = true;


            $aRetorno = $this->beforeInsert();

            if ($aRetorno[0]) {
                $aRetorno = $this->Persistencia->inserir();
            }

            if ($aRetorno[0]) {
                $aRetorno = $this->afterInsert();
                $this->Persistencia->commit();
            }
            //instancia a classe mensagem
            if ($aRetorno[0]) {
                $oMsg = new Mensagem('INSERIDO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_SUCESSO);
                //chama o método para zerar os campos do form se não for detalhe
                //Limpar o form é tratado na controller filhos
                $this->acaoLimpar($sForm, $sCampos);
                //método que executa após limpar
                $this->afterResetForm($sDados);

                //retorna aut incremento
                $iAutoInc = $this->retornaValuInc();
                //monta a mensagem

                $msg = "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
                echo $msg;
                echo $oMsg->getRender();
                $this->getDadosConsulta($aDados[2], true, null);
                $oFocus = new Base();
                echo $oFocus->focus($aDados[3]);


                //monta os filtros
            } else {
                $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }
        }
        
        //gera o total na tabela de cabeçalho
        $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCampos['pdv_pedidofilial']);
        $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCampos['pdv_pedidocodigo']);
        $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
        $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCabTot->Persistencia->geraTotaliza($iValorTot,$aCampos);
        //gera o totalizador para a tela
        $aTotal = $this->Persistencia->pesoInsumo($aChave);
        $sInsumo ='0';
        $sRetorno ='0';
        $sServico ='0';
        foreach ($aTotal as $key => $value) {
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
        //aplica os valores
        echo '$("#' . $aDados[4] . '").text("RETORNO: ' . number_format($sRetorno, 2, ',', '.'). '");';
        echo '$("#' . $aDados[5] . '").text("INSUMO: ' . number_format($sInsumo, 2, ',', '.'). '");';
        echo '$("#' . $aDados[6] . '").text("SERVIÇO: ' . number_format($sServico, 2, ',', '.'). '");';
        //vamos gerar as parcelas do financeiro
        $this->parcelaPedido($aChave);
        
    }
    
    /**
     * Seta valores padroes para os itens que não passam na tabela de parametros
     */
    
    public function setaPadraoItem(){
        $this->Model->setPDV_PedidoItemQtdFaturada('0');
        $this->Model->setPDV_PedidoItemAprovacao(' ');
        
        $sData = Util::getDataAtual();
        $this->Model->setPDV_PedidoItemDataEntrega($sData);
        
        $this->Model->setPDV_PedidoItemGrade(' ');
        
        $this->Model->setPDV_PedidoItemSituacao('A');
        $this->Model->setPDV_PedidoItemAprovacao('A');
        $this->Model->setPDV_PedidoItemValorTabela('0');
        $this->Model->setPDV_PedidoItemDimGFormula(' ');
        $this->Model->setPDV_PedidoItemDimGExpres(' ');
        
        //atenção se vamos deixar em branco
        $this->Model->setPDV_PedidoItemObsOF(' ');
        $this->Model->setPDV_PedidoItemProdutoReferenci(' ');
        $this->Model->setPDV_PedidoItemDescFormulaSeq(' ');
        $this->Model->setPDV_PedidoItemIdenProgramacao(' ');
        $this->Model->setPDV_PedidoItemTaxaTecnologica('0');
        $this->Model->setPDV_PedidoItemJustificativa(' ');
        $this->Model->setPDV_PedidoItemDescProdComercia(' ');
        
      }
      
      /**
       * Verifica se há valor zerado
       */
      public function validaZero($aCampos){
          //verifica valor zerado no retorno
          $sErro ='';
          if($aCampos['PDV_PedidoItemValorUnitario']=='0,00'||$aCampos['PDV_PedidoItemValorUnitario']==''||$aCampos['PDV_PedidoItemValorUnitario']=='0'){
              $sErro = 'Valor unitário do RETORNO não pode ser zero! ';
          }
          if($aCampos['insumoVlr']=='0,00'||$aCampos['insumoVlr']==''||$aCampos['insumoVlr']=='0'){
              $sErro .=' Valor unitário do INSUMO não pode ser zero! ';
          }
          if($aCampos['servicoVlr']=='0,00'||$aCampos['servicoVlr']==''||$aCampos['servicoVlr']=='0'){
              $sErro .=' Valor unitário do SERVIÇO  não pode ser zero! ';
          }
          
          if($sErro!==''){
              $oMensagem = new Modal('Atenção', $sErro, Modal::TIPO_ERRO, false, true, false); 
              echo $oMensagem->getRender();
              exit();
          }
          
          
          
      }

      

      /**
     * Filtros para o foreach
     */
    public function insereFiltrosInsert(){
        //limpa os filtros e adiciona novamente
        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $this->Model->getPdv_PedidoFilial());
        $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $this->Model->getPdv_pedidocodigo());
    }
    
    /**
     * Função para inserir na tabela STEEL_PCP_CargaInsumoServ
     */
    public function afterInsert() {
        parent::afterInsert();
        
        $oCargaInsumos = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
        //seta o model os dados do model PedCargaItens
        $oCargaInsumos->Model->setPdv_pedidofilial($this->Model->getPdv_PedidoFilial());
        $oCargaInsumos->Model->setPdv_pedidocodigo($this->Model->getPdv_pedidocodigo());
        $oCargaInsumos->Model->setPdv_pedidoitemseq($this->Model->getPdv_pedidoitemseq());
        $oCargaInsumos->Model->setPdv_insserv($this->Model->getPdv_insserv());
        $oCargaInsumos->Model->setOp($this->Model->getOp());
        
        //gerar insert
        $oCargaInsumos->Persistencia->inserir();
        
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Altera os items da carga steel
     * @return string
     */
    public function acaoAlterarDetSteel($sId, $sCampos) {
        $aDados = explode(',', $sId);
        $this->parametros = $sCampos;
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        $aRetorno[0] = true;
        //adiciona filtros extras
        $this->adicionaFiltrosExtras();
        //necessidade de colocar novos filtros mas limpa os anteriores
        $this->adicionaFiltroDet2();

        $this->Persistencia->iniciaTransacao();

        $aChaveMestre = $this->Persistencia->getChaveArray();
        foreach ($aChaveMestre as $oCampoBanco) {
            if ($oCampoBanco->getPersiste()) {
                $this->setValorModel($this->Model, $oCampoBanco->getNomeModel());
            }
        }

        $this->Model = $this->Persistencia->consultar();
        //cria a tela
        $this->View->criaTela();
        
         //traz lista campos
        $aCamposTela = $this->View->getTela()->getCampos();

        $this->carregaModel($aCamposTela);
        
        //DEFINE O ARRAY PARA CONTROLAR OS SERVIÇOS E INSUMOS
        $aInsumosServ = array('RETORNO','INSUMO','SERVIÇO');
        foreach ($aInsumosServ as $key => $value) {
            
            switch ($value){
            case "INSUMO":    
                $this->Model->setPDV_PedidoItemProduto($aCampos['insumoCod']);
                $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['insumoNome']);
                $this->Model->setPDV_PedidoItemQtdPedida(str_replace(',', '.',$aCampos['insumoQt']));
                $this->Model->setPDV_PedidoItemValorUnitario(str_replace(',', '.',$aCampos['insumoVlr']));
                //$this->Model->setPdv_pedidoitemseq($this->Model->getPdv_pedidoitemseq()+1);
            break;
            case "SERVIÇO":
                $this->Model->setPDV_PedidoItemProduto($aCampos['servicoCod']);
                $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['servicoDes']);
                $this->Model->setPDV_PedidoItemQtdPedida(str_replace(',', '.', $aCampos['servicoQt']));
                $this->Model->setPDV_PedidoItemValorUnitario(str_replace(',', '.',$aCampos['servicoVlr']));
                //$this->Model->setPdv_pedidoitemseq($this->Model->getPdv_pedidoitemseq()+1);
            case "RETORNO":
            break;
            }
            

        if ($aRetorno[0]) {
            $aRetorno = $this->beforeUpdate();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->alterar();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->afterUpdate();
        }
        if ($aRetorno[0]) {

            $this->Persistencia->commit();

            $aRetorno = $this->afterCommitUpdate();
        }

        //instancia a classe mensagem
        if ($aRetorno[0]) {
            $oMsg = new Mensagem('ALTERADO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_INFO);
            //chama o método para zerar os campos do form se não for detalhe

            $this->acaoLimpar($sForm, $sCampos);

            //funcao após limpar o form
            $this->afterResetForm($sId);

            //retorna aut incremento
            $iAutoInc = $this->retornaValuInc();
            //monta a mensagem
            //$msg ="".$oLimpa->limpaFormDetail($sForm).""
            $msg = "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
            echo $msg;
            echo $oMsg->getRender();
            $this->getDadosConsulta($aDados[2], TRUE, null);
            //gera a atualização do grid
            //monta os filtros
        } else {
            $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
        }
        
        }
    }
    
    
    
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->carregaDefault();
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $this->carregaDefault();
        
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    /* ///SETA OS VALORES PARA TODOS OS CAMPOS DA TABELA BASTA PREENCHER COM A TABELA
     * Funcao para pegar valores padroes das cargas da classe STEEL_PCP_ParamVendasItem
     */
    public function carregaDefault(){
        $oParametros = Fabrica::FabricarController('STEEL_PCP_ParamVendasItem');
        
        $oParamDados = $oParametros->Persistencia->consultar();
        
        //Passa os dados para o model STEEL_PCP_PedCargaItens
        $this->Model->setPDV_PedidoItemMoeda($oParamDados->getPDV_PedidoItemMoeda());
        $this->Model->setPDV_PedidoItemFreteRateado($oParamDados->getPDV_PedidoItemFreteRateado());
        $this->Model->setPDV_PedidoItemDespesasRateado($oParamDados->getPDV_PedidoItemDespesasRateado());
        $this->Model->setPDV_PedidoItemSeguroRateado($oParamDados->getPDV_PedidoItemSeguroRateado());
        $this->Model->setPDV_PedidoItemAcrescimoRateado($oParamDados->getPDV_PedidoItemAcrescimoRateado());
        $this->Model->setPDV_PedidoItemDescontoPercentu($oParamDados->getPDV_PedidoItemDescontoPercentu());
        $this->Model->setPDV_PedidoItemAcrescimoPercent($oParamDados->getPDV_PedidoItemAcrescimoPercent());
        $this->Model->setPDV_PedidoItemOrdemImpressao($oParamDados->getPDV_PedidoItemOrdemImpressao());
        $this->Model->setPDV_PedidoItemQtdLiberada($oParamDados->getPDV_PedidoItemQtdLiberada());
        $this->Model->setPDV_PedidoItemDescontoValor($oParamDados->getPDV_PedidoItemDescontoValor());
        $this->Model->setPDV_PedidoItemAcrescimoValor($oParamDados->getPDV_PedidoItemAcrescimoValor());
        $this->Model->setPDV_PedidoItemTipoEmiNF($oParamDados->getPDV_PedidoItemTipoEmiNF());
        $this->Model->setPDV_PedidoItemCancelado($oParamDados->getPDV_PedidoItemCancelado());
        $this->Model->setPDV_PedidoItemDiasEntrega($oParamDados->getPDV_PedidoItemDiasEntrega());
        $this->Model->setPDV_PedidoItemVlrFaturado($oParamDados->getPDV_PedidoItemVlrFaturado());
        $this->Model->setPDV_PedidoItemValorCusto($oParamDados->getPDV_PedidoItemValorCusto());
        $this->Model->setPDV_PedidoItemPercentualCusto($oParamDados->getPDV_PedidoItemPercentualCusto());
        $this->Model->setPDV_PedidoItemDimGQtd($oParamDados->getPDV_PedidoItemDimGQtd());
        $this->Model->setPDV_PedidoItemDimGFormula($oParamDados->getPDV_PedidoItemDimGFormula());
        $this->Model->setPDV_PedidoItemDimGExpres($oParamDados->getPDV_PedidoItemDimGExpres());
        $this->Model->setPDV_PedidoItemQtdPecas($oParamDados->getPDV_PedidoItemQtdPecas());
        $this->Model->setPDV_PedidoItemObsOF($oParamDados->getPDV_PedidoItemObsOF());
        $this->Model->setPDV_PedidoItemPercentualPromoc($oParamDados->getPDV_PedidoItemPercentualPromoc());
        $this->Model->setPDV_PedidoItemValorMotagemRate($oParamDados->getPDV_PedidoItemValorMotagemRate());
        $this->Model->setPDV_PedidoItemValorFreteAuxRat($oParamDados->getPDV_PedidoItemValorFreteAuxRat());
        $this->Model->setPDV_PedidoItemConfigSalvaSeq($oParamDados->getPDV_PedidoItemConfigSalvaSeq());
        $this->Model->setPDV_PedidoItemEstruturaNumero($oParamDados->getPDV_PedidoItemEstruturaNumero());
        $this->Model->setPDV_PedidoItemEntregaAntecipad($oParamDados->getPDV_PedidoItemEntregaAntecipad());
        $this->Model->setPDV_PedidoItemProdutoCusto($oParamDados->getPDV_PedidoItemProdutoCusto());
        $this->Model->setPDV_PedidoItemProdutoMarkup($oParamDados->getPDV_PedidoItemProdutoMarkup());
        $this->Model->setPDV_PedidoItemProdutoReferenci($oParamDados->getPDV_PedidoItemProdutoReferenci());
        $this->Model->setPDV_PedidoItemTipoFornecimento($oParamDados->getPDV_PedidoItemTipoFornecimento());
        $this->Model->setPDV_PedidoItemMoedaPadrao($oParamDados->getPDV_PedidoItemMoedaPadrao());
        $this->Model->setPDV_PedidoItemMoedaValorCotaca($oParamDados->getPDV_PedidoItemMoedaValorCotaca());
        $this->Model->setPDV_PedidoItemMoedaValor($oParamDados->getPDV_PedidoItemMoedaValor());
        $this->Model->setPDV_PedidoItemConfigProcessada($oParamDados->getPDV_PedidoItemConfigProcessada());
        $this->Model->setPDV_PedidoItemEspecie($oParamDados->getPDV_PedidoItemEspecie());
        $this->Model->setPDV_PedidoItemVolumes($oParamDados->getPDV_PedidoItemVolumes());
        $this->Model->setPDV_PedidoItemDescFormulaSeq($oParamDados->getPDV_PedidoItemDescFormulaSeq());
        $this->Model->setPDV_AprovacaoAlteraPedido($oParamDados->getPDV_AprovacaoAlteraPedido());
        $this->Model->setPDV_PedidoItemOrigem($oParamDados->getPDV_PedidoItemOrigem());
        $this->Model->setPDV_PedidoItemPedidoVendaCli($oParamDados->getPDV_PedidoItemPedidoVendaCli());
        $this->Model->setPDV_PedidoItemProdObsoleto($oParamDados->getPDV_PedidoItemProdObsoleto());
        $this->Model->setPDV_PedidoItemSerieModelo($oParamDados->getPDV_PedidoItemSerieModelo());
        $this->Model->setPDV_PedidoItemIdenProgramacao($oParamDados->getPDV_PedidoItemIdenProgramacao());
        $this->Model->setPDV_PedidoItemMargemVlrUnitJur($oParamDados->getPDV_PedidoItemMargemVlrUnitJur());
        $this->Model->setPDV_PedidoItemDiasEntregaFinal($oParamDados->getPDV_PedidoItemDiasEntregaFinal());
        $this->Model->setPDV_PedidoItemQtdEncerrada($oParamDados->getPDV_PedidoItemQtdEncerrada());
        $this->Model->setPDV_PedidoItemContratoSeq($oParamDados->getPDV_PedidoItemContratoSeq());
        $this->Model->setPDV_PedidoItemValorTratamento($oParamDados->getPDV_PedidoItemValorTratamento());
        $this->Model->setPDV_PedidoItemProdutoImportado($oParamDados->getPDV_PedidoItemProdutoImportado());
        $this->Model->setPDV_PedidoItemTabelaFreteKM($oParamDados->getPDV_PedidoItemTabelaFreteKM());
        $this->Model->setPDV_PedidoItemFilialDistancia($oParamDados->getPDV_PedidoItemFilialDistancia());
        $this->Model->setPDV_PedidoItemFreteUnitario($oParamDados->getPDV_PedidoItemFreteUnitario());
        $this->Model->setPDV_PedidoItemSeqOptyWay($oParamDados->getPDV_PedidoItemSeqOptyWay());
        $this->Model->setPDV_PedidoItemDataInclusao($oParamDados->getPDV_PedidoItemDataInclusao());
        $this->Model->setPDV_PedidoItemJustificativa($oParamDados->getPDV_PedidoItemJustificativa());
        $this->Model->setPDV_PedidoItemMotivo($oParamDados->getPDV_PedidoItemMotivo());
        $this->Model->setPDV_PedidoItemValorFreteTabela($oParamDados->getPDV_PedidoItemValorFreteTabela());
        $this->Model->setPDV_PedidoItemAlturaComercial($oParamDados->getPDV_PedidoItemAlturaComercial());
        $this->Model->setPDV_PedidoItemLarguraComercial($oParamDados->getPDV_PedidoItemLarguraComercial());
        $this->Model->setPDV_PedidoItemDescProdComercia($oParamDados->getPDV_PedidoItemDescProdComercia());
        
    }
    
     public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
        echo $sScript;
       }
       
       
       /**
        * Método que mostra a mensagem do excluir 
        */
       public function msgExcluirItensCarga($sDados){
            $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse();
            
            $oMensagem = new Modal('Atenção','Será deletado os insumos e os serviços desse item.', Modal::TIPO_INFO, true,true,true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[1].'-form","' . $sClasse . '","excluirItensCarga","' . $sDados . '");');
            echo $oMensagem->getRender();
           
       }

       



       /**
        * Método excluir especial 
        */
       
       public function excluirItensCarga($sDados){
            $aDados = explode(',', $sDados);
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $sClasse = $this->getNomeClasse(); 
            
            //consulta qual é sua op
            $oCargaInsumos = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
            //seta o model os dados do model PedCargaItens
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCamposChave['pdv_pedidofilial']);
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidoitemseq',$aCamposChave['pdv_pedidoitemseq']);
            //vamos consultar a op base
            
            $oOp = $oCargaInsumos->Persistencia->consultarWhere();
            
            //consulta as sequencias da ordem de carga a serem deletadas
            
            $oCargaInsumos->Persistencia->limpaFiltro();
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCamposChave['pdv_pedidofilial']);
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
            $oCargaInsumos->Persistencia->adicionaFiltro('op',$oOp->getOp());
            
            $aOps = $oCargaInsumos->Persistencia->getArrayModel();
            
            //deleta na tabela de itens
            
            foreach ($aOps as $key => $oValue) {
                //deleta primeiramente dos itens da carga
                $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $oValue->getPdv_pedidofilial());
                $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $oValue->getPdv_pedidocodigo());
                $this->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $oValue->getPdv_pedidoitemseq());
                $this->Persistencia->excluir();
                $this->Persistencia->limpaFiltro();
                //delete na tabela de insumos 
                $oCargaInsumos->Persistencia->limpaFiltro();
                $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial',$oValue->getPdv_pedidofilial());
                $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo',$oValue->getPdv_pedidocodigo());
                $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $oValue->getPdv_pedidoitemseq());
                $oCargaInsumos->Persistencia->excluir();
            }
            // Retorna Mensagem Informando o Sucesso da Exlusão do registro
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
            //atualiza o valor total do cabeçalho
                $oPedItens = Fabrica::FabricarController('STEEL_PCP_PedCargaItens');
                $oPedItens->Persistencia->adicionaFiltro('pdv_pedidofilial',$aCamposChave['pdv_pedidofilial']);
                $oPedItens->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
                $iTotalItens = $oPedItens->Persistencia->getSoma('PDV_PedidoItemValorTotal');
                //gera update no cabeçalho
                $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
                $oPevCabTot->Persistencia->geraTotaliza($iTotalItens,$aCamposChave);
             

            //se necessário adiciona filtro de reload
            $this->filtroReload($sChave);
            
            //Atualiza o Grid
            $this->getDadosConsulta($aDados[1], false, null);
            //atualiza os contadores
            //gera o totalizador para a tela
        $aChave[0]=$aCamposChave['pdv_pedidofilial'];
        $aChave[1]=$aCamposChave['pdv_pedidocodigo'];
        $aTotal = $this->Persistencia->pesoInsumo($aChave);
        $sInsumo ='0';
        $sRetorno ='0';
        $sServico ='0';
        foreach ($aTotal as $key => $value) {
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
        //aplica os valores
        echo '$("[name=retorno]").text("RETORNO: ' . number_format($sRetorno, 2, ',', '.'). '");';
        echo '$("[name=insumo]").text("INSUMO: ' . number_format($sInsumo, 2, ',', '.'). '");';
        echo '$("[name=servico]").text("SERVIÇO: ' . number_format($sServico, 2, ',', '.'). '");';
        //atualiza as parcelas do financeiro
        $this->parcelaPedido($aChave);
        }



       
       public function acaoExcluirDependencias() {
           parent::acaoExcluirDependencias();
           
           
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
       }
        
       /**
        * gera parceclas do financeiro
        */
       
       public function parcelaPedido($aChave){
           //pegamos o valor total a gerar as parcelas
           $this->Persistencia->limpaFiltro();
           $this->Persistencia->adicionaFiltro('pdv_pedidofilial','8993358000174');
           $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aChave[1]);
           $this->Persistencia->adicionaFiltro('pdv_pedidoitemgerafinanceiro','S');
           
           $iTotal = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
           
           //consulta a tabela de preço
           $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
           $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial',$aChave[0]);
           $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aChave[1]);
           $oPevDadosCab = $oPevCab->Persistencia->consultarWhere();
           $iCondPag = $oPevDadosCab->getPDV_PedidoCondicaoPgtoCodigo();
           
           
           $aChave[3]=$iCondPag;
           //define valor da percela 
           $oCondPag = Fabrica::FabricarController('DELX_CPG_CondicaoPagamento');
           $oCondPag->Persistencia->adicionaFiltro('cpg_codigo',$iCondPag);
           $oCondPagDados = $oCondPag->Persistencia->consultarWhere();
           $iNrParcela = $oCondPagDados->getCpg_numeroparcelas();
           $iValorParc = $iTotal/$iNrParcela;
           
           //busca as parcelas 
           $aParcelas = $this->Persistencia->parcCondPag($aChave);
           //fabrica a parcela 
            $oParcelaPed = Fabrica::FabricarController('STEEL_PCP_PedidoParcela');
            $oParcelaPed->Persistencia->adicionaFiltro('pdv_pedidofilial',$aChave[0]);
            $oParcelaPed->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aChave[1]);
            //deleta parcelas existentes!!!!!!!!!!!!!!!!
            $oParcelaPed->Persistencia->excluir();
          
           
           //vai gerar o insert da parcela no pedido
         if($iTotal > 0){
           foreach ($aParcelas as $key => $oValue) {
              
               //seta o model para inserção
               $oParcelaPed->Model->setPdv_pedidofilial($aChave[0]);
               $oParcelaPed->Model->setPdv_pedidocodigo($aChave[1]);
               $oParcelaPed->Model->setPdv_pedidoparcelaseq($oValue->cpg_numeroparcela);
               $oParcelaPed->Persistencia->setModel($oParcelaPed->Model);
               //faz o cálculo da data 
               $dataAtual = date('d/m/Y');
               $data=date('d/m/Y',strtotime("+".$oValue->cpg_diasparcela." days")); //date('d/m/Y',strtotime("+".$oValue->cpg_diasparcela." day", strtotime($dataAtual)));
               
               $oParcelaPed->Model->setPDV_PedidoParcelaVencimento($data);
               //fecha o calculo da data
               $oParcelaPed->Model->setPDV_PedidoParcelaValor($iValorParc);
               $oParcelaPed->Model->setPDV_PedidoParcelaPercentual('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaAntecipada('N');
               $oParcelaPed->Model->setPDV_PedidoParcelaDias('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaObs('');
               $oParcelaPed->Model->setPDV_PedidoParcelaAdiantamento('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaAlteradaManua('N');
               $oParcelaPed->Model->setPDV_PedidoParcelaMoedaPadrao('');
               $oParcelaPed->Model->setPDV_PedidoParcelaMoedaCodigo('');
               //$oParcelaPed->Model->setPDV_PedidoParcelaMoedaData('');
               $oParcelaPed->Model->setPDV_PedidoParcelaMoedaValorCot('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaMoedaVlrCotNe('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaMoedaValor('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaValorImposto('0');
               $oParcelaPed->Model->setPDV_PedidoParcelaValorFrete('0');
               
               $oParcelaPed->Persistencia->inserir();
               
           }
         }
           
           
       }
}