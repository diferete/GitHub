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
        parent::pkDetalhe($aChave);
        //vai totalizar os insumos
        $aCamposChave['pdv_pedidocodigo'] = $aChave[1];
        //$aInsumos = $this->Persistencia->pesoInsumo($aChave);
        //$aChave[3]=$aInsumos;

        $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');

        $aChave[3] = $oPevCabTot->Persistencia->buscaPeso($aCamposChave);
        $aChave[4] = $oPevCabTot->Persistencia->retornaVolumes($aCamposChave);
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if (count($aparam) > 0) {

            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aparam[0]);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aparam[1]);
        } else {
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aparam1[0]);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aparam1[1]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function buscaDadosCarga($sDados) {
        $aId = explode(',', $sDados);
        /* 0=codigo
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

          12=totalRetorno
          13=totalInsumo
          14=totalServico

         */

        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //monta mvc do cabecalho
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
        $oPevCabDados = $oPevCab->Persistencia->consultarWhere();

        //busca a tabela do cliente
        $oTabCli = Fabrica::FabricarController('STEEL_PCP_TabCabPreco');
        $oTabCli->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $oTabCli->Persistencia->adicionaFiltro('sit', 'INATIVA', 0, 10);
        $oTabCliDados = $oTabCli->Persistencia->consultarWhere();


        //Fabrica a controller STEEL_PCP_OrdensFab e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpSteel->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpSteel->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $iNrOp = $oOpSteel->Persistencia->getCount();
        if ($iNrOp > 0) {
            //---------------------BUSCA O RETORNO, quant, valor, verifica quando é arame------------------------
            $aDadosTela = array();
            $oDadosOp = $oOpSteel->Persistencia->consultarWhere();
            $oProdutoFinal = Fabrica::FabricarController('DELX_PRO_Produtos');
            $oProdutoFinal->Persistencia->adicionaFiltro('pro_codigo', $oDadosOp->getProdFinal());
            $oDadosProdFinal = $oProdutoFinal->Persistencia->consultarWhere();
            $aDadosTela['ProdutoFinal'] = $oDadosOp->getProdFinal();
            $aDadosTela['ProdutoFinalDes'] = $oDadosOp->getProdesFinal();
            $aDadosTela['Quant'] = $oDadosOp->getQuant();
            $aDadosTela['ValorEnt'] = $oDadosOp->getVlrNfEntUnit();
            $aDadosTela['TotalRetorno'] = $oDadosOp->getVlrNfEnt();
            //--------------------BUSCA O INSUMO------------------------------------------------------------------
            $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'INSUMO');
            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oDadosProdFinal->getPro_ncm());
            $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();
            //verifica se há cadastro do insumo
            if ($oDadosInsumo->getProd() !== null) {
                $aDadosTela['codInsumo'] = $oDadosInsumo->getProd();
                //busca descrição do insumo
                $oProd = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oProd->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['insumoDes'] = $oProdDados->getPro_descricao();
                //busca peso
                $aDadosTela['insumoQt'] = $oDadosOp->getPeso();
                $aDadosTela['insumoVlr'] = $oDadosInsumo->getPreco();
                $aDadosTela['insumoTotal'] = $aDadosTela['insumoQt'] * $aDadosTela['insumoVlr'];
            } else {
                $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                echo $oModal->getRender();
            }
            // -----------------------Fim do insumo---------------------------------------------------------------
            //------------------------BUSCA O SERVIÇO---------------------------------------------------------------
            $oItemsTabela->Persistencia->limpaFiltro();
            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'SERVIÇO');
            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oDadosProdFinal->getPro_ncm());
            $oDadosServico = $oItemsTabela->Persistencia->consultarWhere();

            if ($oDadosServico->getProd() !== null) {
                //Servico
                $aDadosTela['codServ'] = $oDadosServico->getProd();
                $oProd = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oProd->Persistencia->adicionaFiltro('pro_codigo', $oDadosServico->getProd());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['codServDes'] = $oProdDados->getPro_descricao();
                $aDadosTela['ServicoQt'] = $oDadosOp->getPeso();
                $aDadosTela['ServicoVlr'] = $oDadosServico->getPreco();
                $aDadosTela['ServicoTotal'] = $aDadosTela['ServicoQt'] * $aDadosTela['ServicoVlr'];
            } else {
                $oModal = new Modal('Atenção', 'Não há cadastro de serviço desse produto, analise a tabela '
                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                echo $oModal->getRender();
            }

            //seta o valor na tela
            $this->setaValorTela($aDadosTela, $aId);
        } else {
            $oMensagem = new Modal('Atenção!', 'Esta ordem de produção não existe ou não pertence a empresa da carga, '
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
            . '$("#' . $aId[11] . '").val("");'
            . '$("#' . $aId[12] . '").val("");'
            . '$("#' . $aId[13] . '").val("");'
            . '$("#' . $aId[14] . '").val("");';
        }
    }

    /**
     * Seta o valor na tela 
     */
    public function setaValorTela($aDadosTela, $aId) {
        /* 0=codigo
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
         * 
         * 12=totalRetorno
          13=totalInsumo
          14=totalServico

         */

        echo '$("#' . $aId[0] . '").val("' . $aDadosTela['ProdutoFinal'] . '");'
        . '$("#' . $aId[1] . '").val("' . $aDadosTela['ProdutoFinalDes'] . '");'
        . '$("#' . $aId[2] . '").val("' . number_format($aDadosTela['Quant'], 2, ',', '.') . '");'
        . '$("#' . $aId[3] . '").val("' . number_format($aDadosTela['ValorEnt'], 2, ',', '.') . '");'
        . '$("#' . $aId[4] . '").val("' . $aDadosTela['codInsumo'] . '");'
        . '$("#' . $aId[5] . '").val("' . $aDadosTela['insumoDes'] . '");'
        . '$("#' . $aId[6] . '").val("' . number_format($aDadosTela['insumoQt'], 2, ',', '.') . '");'
        . '$("#' . $aId[7] . '").val("' . number_format($aDadosTela['insumoVlr'], 2, ',', '.') . '");'
        . '$("#' . $aId[8] . '").val("' . $aDadosTela['codServ'] . '");'
        . '$("#' . $aId[9] . '").val("' . $aDadosTela['codServDes'] . '");'
        . '$("#' . $aId[10] . '").val("' . number_format($aDadosTela['ServicoQt'], 2, ',', '.') . '");'
        . '$("#' . $aId[11] . '").val("' . number_format($aDadosTela['ServicoVlr'], 2, ',', '.') . '");'
        . '$("#' . $aId[12] . '").val("' . number_format($aDadosTela['TotalRetorno'], 2, ',', '.') . '");'
        . '$("#' . $aId[13] . '").val("' . number_format($aDadosTela['insumoTotal'], 2, ',', '.') . '");'
        . '$("#' . $aId[14] . '").val("' . number_format($aDadosTela['ServicoTotal'], 2, ',', '.') . '");';
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
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
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

        //pega valores da tela 
        //Método que pega os valores dos campos da tela e joga em um array
        parse_str($_REQUEST['campos'], $aCampos);
        //valida se ordem de produção não foi faturada duas vezes
        $this->Persistencia->limpaFiltro();
        //($sCampo, $sValor, $iTipoLigacao = 0, $iTipoComparacao = 0, $sValorFim = "", $sTabelaCampo = "", $sCampoType = "")
        $this->Persistencia->adicionaFiltro('STEEL_PCP_CargaInsumoServ.op', $aCampos['op'], 0, 0, "", "STEEL_PCP_CargaInsumoServ");
        $iContOp = $this->Persistencia->getCount();
        //se > 5 vai para pois já se encontra uma ordem de produção
        if ($iContOp > 0) {
            $oModal = new Modal('Atenção!', 'Ordem de produção já se encontra em uma carga!', Modal::TIPO_AVISO, false, true, true);
            echo $oModal->getRender();
            exit();
        }
        //verifica parametro referente a bloquea faturamento de op sem apontamento
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpSteel->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpDados = $oOpSteel->Persistencia->consultarWhere();
        if ($oOpDados->getTipoOrdem() == 'P' || $oOpDados->getTipoOrdem() == 'Z' || $oOpDados->getTipoOrdem() == 'TZ') {
            $oSTEEL_PCP_ParametrosProd = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
            $oSTEEL_PCP_ParametrosProd->Persistencia->adicionaFiltro('parametro', 'BLOQUEIA CARGA OP TÊMPERA NÃO APONTADA');
            $oSteelDados = $oSTEEL_PCP_ParametrosProd->Persistencia->consultarWhere();
            if ($oSteelDados->getValor() == 'SIM') {
                $oSTEEL_PCP_ordensFabApontEnt = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
                $oSTEEL_PCP_ordensFabApontEnt->Persistencia->adicionaFiltro('op', $aCampos['op']);
                $oDadosOrdensFabApontEnt = $oSTEEL_PCP_ordensFabApontEnt->Persistencia->consultarWhere();
                if ($oDadosOrdensFabApontEnt->getSituacao() !== 'Finalizado') {
                    $oModal = new Modal('Atenção!', 'Ordem de produção não está com seu apontamento finalizado!', Modal::TIPO_AVISO, false, true, true);
                    echo $oModal->getRender();
                    exit();
                }
            }
        }
        //bloqueia fio máquina não apontada
        if ($oOpDados->getTipoOrdem() == 'F') {
            $oSTEEL_PCP_ParametrosProd = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
            $oSTEEL_PCP_ParametrosProd->Persistencia->adicionaFiltro('parametro', 'BLOQUEIA CARGA OP FIO NÃO APONTADA');
            $oSteelDados = $oSTEEL_PCP_ParametrosProd->Persistencia->consultarWhere();
            if ($oSteelDados->getValor() == 'SIM') {
                $oSTEEL_PCP_ordensFabApontEnt = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
                $oSTEEL_PCP_ordensFabApontEnt->Persistencia->adicionaFiltro('op', $aCampos['op']);
                $oDadosOrdensFabApontEnt = $oSTEEL_PCP_ordensFabApontEnt->Persistencia->consultarWhere();
                if ($oDadosOrdensFabApontEnt->getSituacao() !== 'Finalizado') {
                    $oModal = new Modal('Atenção!', 'Ordem de produção não está com seu apontamento finalizado!', Modal::TIPO_AVISO, false, true, true);
                    echo $oModal->getRender();
                    exit();
                }
            }
        }

        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //verifica se há validacao no lado do servidor
        $this->getVal($sDados . ',' . $iCont);
        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //se cont = 0 segue ação incluir
        if ($iCont == 0) {
            $this->acaoIncluirDetalheSteel($sDados, $sCampos);
        } else {
            $this->acaoAlterarDetSteel($sDados, $sCampos);
        }
    }

    /**
     * Método para incluir dados nas tabelas detalhe
     */
    public function acaoIncluirDetSteel($sId, $sCampos) {
        $aChave = explode(',', $sCampos);
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
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
        $oPevCabDados = $oPevCab->Persistencia->consultarWhere();
        //
        //carrega tabela de preço
        $oTab = Fabrica::FabricarController('STEEL_PCP_TabCabPreco');
        $oTab->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $oTab->Persistencia->adicionaFiltro('sit', 'INATIVA', 0, 10);
        $oTabela = $oTab->Persistencia->consultarWhere();


        //atualiza observações do item retorno traz a nota fiscal
        $oOp = Fabrica::FabricarController('STEEL_PCP_ordensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpdados = $oOp->Persistencia->consultarWhere();


        //valida se há algum valor zerado
        $this->validaZero($aCampos);

        //DEFINE O ARRAY PARA CONTROLAR OS SERVIÇOS E INSUMOS
        //$aInsumosServ = array('RETORNO','INSUMO','SERVIÇO');
        // $aInsumosServ = array('SERVIÇO','INSUMO','RETORNO');
        $aInsumosServ = array('RETORNO', 'INSUMO', 'SERVIÇO');
        foreach ($aInsumosServ as $key => $value) {

            switch ($value) {
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
                    $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                    $oProdDados = $oProdUn->Persistencia->consultarWhere();
                    $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                    //seta valores específicos do retorno da mercadoria
                    $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                    $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                    $this->Model->setPDV_PedidoItemConsideraVenda('N');

                    //gera o valor total
                    $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                    $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                    $ValorTotal = ($Qt * $ValorUni);
                    $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                    //analisar o pq disso
                    // 
                    //seta as informacoes adicionais 
                    $sInfAdicional = '';
                    if ($oTabela->getConcatena() == true) {
                        $sInfAdicional = 'Seu Prod.-> ' . $oOpdados->getReferencia() . ' ' . $oOpdados->getProdesFinal();
                        $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                    } else {
                        $this->Model->setPDV_PedidoItemObsDescricao('');
                    }

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
                    $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                    $oProdDados = $oProdUn->Persistencia->consultarWhere();
                    $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                    //seta valores específicos do retorno da mercadoria
                    $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                    $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                    $this->Model->setPDV_PedidoItemConsideraVenda('N');

                    //gera o valor total
                    $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                    $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                    $ValorTotal = ($Qt * $ValorUni);
                    $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                    //seta as informacoes adicionais 
                    $sInfAdicional = '';
                    if ($oTabela->getConcatena() == true) {
                        $sInfAdicional = 'Seu Prod.-> ' . $oOpdados->getReferencia() . ' ' . $oOpdados->getProdesFinal();
                        $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                    } else {
                        $this->Model->setPDV_PedidoItemObsDescricao('');
                    }

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
                    $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                    $oProdDados = $oProdUn->Persistencia->consultarWhere();
                    $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                    //seta valores específicos do retorno da mercadoria
                    $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                    $this->Model->setPDV_PedidoItemGeraFinanceiro('N');
                    $this->Model->setPDV_PedidoItemConsideraVenda('N');

                    //gera o valor total
                    $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                    $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                    $ValorTotal = ($Qt * $ValorUni);
                    $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                    //insere os filtros
                    $this->insereFiltrosInsert();

                    //atualiza o nr da carga na ordem de produção
                    $oOrdemProd = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
                    $oOrdemProd->Persistencia->nrCarga($aCampos['op'], $aCampos['pdv_pedidocodigo']);

                    //caso não seja metalbo carrega o código do produto do cliente
                    $sInfAdicional = '';
                    if ($oOpdados->getEmp_codigo() !== '75483040000211') {
                        $sInfAdicional = 'Seu Prod.-> ' . $oOpdados->getReferencia();
                        $sInfAdicional .= ' Sua NF-> ' . $oOpdados->getDocumento();
                    }
                    $sInfAdicional .= 'Sua NF->' . $oOpdados->getDocumento();
                    $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);

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
        $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
        $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
        $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
        $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCabTot->Persistencia->geraTotaliza($iValorTot, $aCampos);
        //gera o totalizador para a tela
        $aTotal = $this->Persistencia->pesoInsumo($aChave);
        $sInsumo = '0';
        $sRetorno = '0';
        $sServico = '0';
        foreach ($aTotal as $key => $value) {
            switch ($value->pdv_insserv) {
                case 'INSUMO':
                    $sInsumo = number_format($value->total, 2, ',', '.');
                    break;
                case 'RETORNO':
                    $sRetorno = number_format($value->total, 2, ',', '.');
                    break;
                case 'SERVIÇO':
                    $sServico = number_format($value->total, 2, ',', '.');
                    break;
            }
        }
        //aplica os valores
        echo '$("#' . $aDados[4] . '").text("RETORNO: ' . number_format($sRetorno, 2, ',', '.') . '");';
        echo '$("#' . $aDados[5] . '").text("INSUMO: ' . number_format($sInsumo, 2, ',', '.') . '");';
        echo '$("#' . $aDados[6] . '").text("SERVIÇO: ' . number_format($sServico, 2, ',', '.') . '");';
        //vamos gerar as parcelas do financeiro
        $this->parcelaPedido($aChave);
    }

    /**
     * NOVA FUNÇÃO PARA INSERIR ORDENS DE PRODUÇÃO
     * @param type $sId
     * @param type $sCampos
     */
    public function acaoIncluirDetalheSteel($sId, $sCampos) {
        $aChave = explode(',', $sCampos);
        $aDados = explode(',', $sId);
        $this->parametros = $sCampos;
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //busca cabeçalho do pedido
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
        $oPevCabDados = $oPevCab->Persistencia->consultarWhere();

        //busca a tabela do cliente
        $oTabCli = Fabrica::FabricarController('STEEL_PCP_TabCabPreco');
        $oTabCli->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $oTabCli->Persistencia->adicionaFiltro('sit', 'INATIVA', 0, 10);
        $oTabCliDados = $oTabCli->Persistencia->consultarWhere();

        //busca ordem de fabricação
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpSteel->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpSteel->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $oDadosOp = $oOpSteel->Persistencia->consultarWhere();
        $iNrOp = $oOpSteel->Persistencia->getCount();
        //valida se op é do cliente
        if ($iNrOp == 0) {
            $oMensagem = new Modal('Atenção!', 'Esta ordem de produção não existe ou não pertence a empresa da carga, '
                    . 'verifique o número da ordem de produção!', Modal::TIPO_AVISO, false, true);
            echo $oMensagem->getRender();
            exit();
        }
        //busca tabela de produtos para unidades
        $oProdUn = Fabrica::FabricarController('DELX_PRO_Produtos');

        //função que seta os valores padrões 
        $this->setaPadraoItem();
//---------------INICIALMENTE VERIFICA SE É RETRABALHO SEM COBRANÇA SER FOR ENTRA E DA UM EXIT----------------------------------
        if ($oPevCabDados->getPDV_PedidoTipoMovimentoCodigo() == '304' || $oDadosOp->getRetrabalho() == 'Sim S/Cobrança' || $oDadosOp->getRetrabalho() == 'Retorno não Ind.') {
            $oMensagem = new Mensagem('Atenção', 'Carga de retrabalho sem cobrança ou não industrializado!', Mensagem::TIPO_INFO, '7000');
            echo $oMensagem->getRender();

            //inicialmente colocamos o retorno----------------------------------------------------------------------------------
            //busca o retorno da indutrialização
            $this->Model->setPDV_PedidoItemProduto($oDadosOp->getProdFinal());
            $this->Model->setPDV_PedidoItemProdutoNomeManua($oDadosOp->getProdesFinal());
            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getQuant());
            $this->Model->setPDV_PedidoItemValorUnitario($oDadosOp->getVlrNfEntUnit());
            $this->Model->setOp($aCampos['op']);
            $this->Model->setPdv_insserv('RETORNO');
            //seta o peso
            $this->Model->setPesoOp($oDadosOp->getPeso());

            //define a CFOP do retorno por hora vamos no tipo = do movimento
            $this->Model->setPDV_PedidoItemCFOP('5916');

            //busca a unidade de medida
            $oProdUn->Persistencia->limpaFiltro();
            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
            $oProdDados = $oProdUn->Persistencia->consultarWhere();
            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

            //seta valores específicos do retorno da mercadoria
            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
            $this->Model->setPDV_PedidoItemGeraFinanceiro('N');
            $this->Model->setPDV_PedidoItemConsideraVenda('N'); //CONSIDERA VENDA IGUAL A N LINHA 635
            //seta o Xped e NitemPed na nota fiscal
            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());

            //gera o valor total
            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
            $ValorTotal = ($Qt * $ValorUni);
            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

            //atualiza o nr da carga na ordem de produção
            $oOrdemProd = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOrdemProd->Persistencia->nrCarga($aCampos['op'], $aCampos['pdv_pedidocodigo']);

            //caso não seja metalbo carrega o código do produto do cliente
            $sInfAdicional = '';

            //$sInfAdicional .= 'Retrabalho sem cobrança->';
            //$this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
            //gera o insert do retorno
            //Filtros para reload
            //insere os filtros
            $this->insereFiltrosInsert();
            //Inicia processo de inserção
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
                $oFocus = new Base();
                echo $oFocus->focus($aDados[3]);
            } else {
                $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }

            //atualiza o grid
            //busca dados para o grid
            $this->getDadosConsulta($aDados[2], true, null);
            //gera o total na tabela de cabeçalho
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
            $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
            $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
            $oPevCabTot->Persistencia->geraTotaliza($iValorTot, $aCampos);
            //gera o total de peso líguido e peso bruto
            $iPesoLiq = $oPevCabTot->Persistencia->buscaPeso($aCampos);
            //busca nr caixas
            $iVolumes = $oPevCabTot->Persistencia->retornaVolumes($aCampos);
            //atualiza no cabecalho
            $oPevCabTot->Persistencia->atualizaPeso($aCampos, $iPesoLiq, $iVolumes, $oPevCabDados->getPDV_PedidoEmpCodigo());
            //gera o totalizador para a tela
            $aTotal = $this->Persistencia->pesoInsumo($aChave);
            $sInsumo = '0';
            $sRetorno = '0';
            $sServico = '0';
            foreach ($aTotal as $key => $value) {
                switch ($value->pdv_insserv) {
                    case 'INSUMO':
                        $sInsumo = number_format($value->total, 2, ',', '.');
                        break;
                    case 'RETORNO':
                        $sRetorno = number_format($value->total, 2, ',', '.');
                        break;
                    case 'SERVIÇO':
                        $sServico = number_format($value->total, 2, ',', '.');
                        break;
                }
            }
            //aplica os valores
            // echo '$("#' . $aDados[4] . '").text("PESO/QUANT. RETORNO: ' . number_format($sRetorno, 2, ',', '.'). '");';
            //aplica os valores
            echo '$("#' . $aDados[4] . '").val("' . number_format($iPesoLiq, 2, ',', '.') . '");';
            echo '$("#' . $aDados[5] . '").val("' . number_format($iVolumes, 2, ',', '.') . '");';
            //vamos gerar as parcelas do financeiro
            $this->parcelaPedido($aChave);
            //método que executa após limpar
            $this->afterResetForm($sId);

            //mostra modal certificado
            if ($aCampos['chkcert']) {
                echo '$("#modalApontaItem").modal("show");';
                echo 'requestAjax("","STEEL_PCP_Certificado","criaTelaModalAponta",'
                . '"modalApontaItem,id,pdv_pedidofilial=' . $this->Model->getPdv_PedidoFilial() . '&pdv_pedidocodigo=' . $this->Model->getPdv_pedidocodigo() . '&pdv_pedidoitemseq=' . $this->Model->getPdv_pedidoitemseq() . ',' . $aDados[3] . '");';
            }
            //finaliza o programa
            exit();
        }


//verifica se a op é padrão RETORNO,SERVIÇO,INSUMO, SERIA O MOVIMENTO 302-------------------------------------------------------------------------
        if ($oDadosOp->getTipoOrdem() == 'P' || $oDadosOp->getTipoOrdem() == 'TZ' || $oDadosOp->getTipoOrdem() == 'Z') {
            //valida se todos os itens estao cadastrados
            if ($this->paramInsumoEnergia() == 'SIM') {
                $aInsumosServParam = array('SERVIÇO', 'INSUMO', 'ENERGIA');
            } else {
                $aInsumosServParam = array('SERVIÇO', 'INSUMO');
            }
            //busca a unidade de medida
            $this->Model->setPDV_PedidoItemProduto($oDadosOp->getProdFinal());
            $oProdUn->Persistencia->limpaFiltro();
            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
            $oProdDados = $oProdUn->Persistencia->consultarWhere();

            if ($this->paramValidaTabPreco() == 'SIM') {
                foreach ($aInsumosServParam as $key => $value) {
                    //se op tipo tempera normal
                    if ($oDadosOp->getTipoOrdem() == 'P' || $oDadosOp->getTipoOrdem() == 'TZ') {
                        //primeiro buca com receita de zincagem
                        $this->validaTabelaPadrao($value, $oTabCliDados->getNr(), $oDadosOp->getReceita(), $oProdDados->getPro_ncm());
                        //se op for do tipo tempera e zincagem analisa tabela de preço da zincagem tbm
                        if ($oDadosOp->getTipoOrdem() == 'TZ') {
                            $this->validaTabelaPadrao($value, $oTabCliDados->getNr(), $oDadosOp->getReceita_zinc(), $oProdDados->getPro_ncm());
                        }
                    }
                    //se op de zincagem
                    if ($oDadosOp->getTipoOrdem() == 'Z') {
                        $this->validaTabelaPadrao($value, $oTabCliDados->getNr(), $oDadosOp->getReceita_zinc(), $oProdDados->getPro_ncm());
                    }
                }
            } //<== fim da validacao
            //verifica parametro se insere insumo de energia ou não 
            if ($this->paramInsumoEnergia() == 'SIM') {
                if ($oDadosOp->getTipoOrdem() == 'P') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇO', 'INSUMO', 'ENERGIA');
                }
                if ($oDadosOp->getTipoOrdem() == 'TZ') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇO', 'INSUMO', 'ENERGIA', 'SERVIÇOZ', 'INSUMOZ', 'ENERGIAZ');
                }
                if ($oDadosOp->getTipoOrdem() == 'Z') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇOZ', 'INSUMOZ', 'ENERGIAZ');
                }
            } else {
                // $aInsumosServ = array('RETORNO', 'SERVIÇO', 'INSUMO');
                if ($oDadosOp->getTipoOrdem() == 'P') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇO', 'INSUMO');
                }
                if ($oDadosOp->getTipoOrdem() == 'TZ') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇO', 'INSUMO', 'SERVIÇOZ', 'INSUMOZ');
                }
                if ($oDadosOp->getTipoOrdem() == 'Z') {
                    $aInsumosServ = array('RETORNO', 'SERVIÇOZ', 'INSUMOZ');
                }
            }
            //validação para ver se há todos os itens na tabela de preço

            foreach ($aInsumosServ as $key => $value) {
                switch ($value) {
                    case "RETORNO":
                        //busca o retorno da indutrialização
                        $this->Model->setPDV_PedidoItemProduto($oDadosOp->getProdFinal());
                        $this->Model->setPDV_PedidoItemProdutoNomeManua($oDadosOp->getProdesFinal());
                        $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getQuant());
                        $this->Model->setPDV_PedidoItemValorUnitario($oDadosOp->getVlrNfEntUnit());
                        $this->Model->setOp($aCampos['op']);

                        $this->Model->setPdv_insserv('RETORNO');
                        //seta o peso
                        $this->Model->setPesoOp($oDadosOp->getPeso());

                        //define a CFOP do retorno por hora vamos no tipo = do movimento
                        $this->Model->setPDV_PedidoItemCFOP('5902');

                        //busca a unidade de medida
                        $oProdUn->Persistencia->limpaFiltro();
                        $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                        $oProdDados = $oProdUn->Persistencia->consultarWhere();
                        $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                        //seta valores específicos do retorno da mercadoria
                        $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                        $this->Model->setPDV_PedidoItemGeraFinanceiro('N');
                        $this->Model->setPDV_PedidoItemConsideraVenda('N');

                        //seta o Xped e NitemPed na nota fiscal
                        $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                        $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());

                        //gera o valor total ele desconta a diferença do peso da balança
                        $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                        $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                        $ValorTotal = ($Qt * $ValorUni);
                        $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                        //atualiza o nr da carga na ordem de produção
                        $oOrdemProd = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
                        $oOrdemProd->Persistencia->nrCarga($aCampos['op'], $aCampos['pdv_pedidocodigo']);

                        //caso não seja metalbo carrega o código do produto do cliente
                        $sInfAdicional = '';
                        if ($oDadosOp->getEmp_codigo() !== '75483040000211') {
                            $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia();
                            $sInfAdicional .= ' Sua NF ' . $oDadosOp->getDocumento();
                            if ($oDadosOp->getEmp_codigo() == '76812379000104') {
                                $sInfAdicional .= ' Pedido ' . $oDadosOp->getXPed();
                            }
                        } else {
                            $sInfAdicional .= 'Sua NF - ' . $oDadosOp->getDocumento();
                            if ($oDadosOp->getXPed() !== null) {
                                $sInfAdicional .= ' OD ' . $oDadosOp->getXPed();
                            }
                        }
                        $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                        break;
//------------------faz a busca pelo insumo-------------------------------------------------------------
                    case "INSUMO":
                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'INSUMO');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();



                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv($value);

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            //$this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedInsumo());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;
//-----------------busca o serviço-------------------------------------------------------------------------------------------
                    case "SERVIÇO":
                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'SERVIÇO');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();


                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv($value);

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedServico());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;
                    //--------------------------BUSCA ENERGIA ELÉTRICA------------------------------------------------
                    case 'ENERGIA' :

                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'ENERGIA');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();



                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv($value);

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedEnergia());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro de insumo ENERGIA desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;
                    //busca o serviço referente a zincagem
                    //-----------------busca o serviço-------------------------------------------------------------------------------------------
                    case "SERVIÇOZ":
                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita_zinc());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'SERVIÇO');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();


                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv('SERVIÇO');

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedServico());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;

                    //carrega o insumo de zincagem
                    case "INSUMOZ":
                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita_zinc());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'INSUMO');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();



                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv('INSUMO');

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            //$this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedInsumo());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;
                    //--------------------------BUSCA ENERGIA ELÉTRICA ZINCATEM------------------------------------------------
                    case 'ENERGIAZ' :

                        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                        $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
                        $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita_zinc());
                        $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'ENERGIA');
                        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
                        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();



                        if ($oDadosInsumo->getProd() !== null) {
                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();

                            $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                            $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                            $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                            $this->Model->setOp($aCampos['op']);
                            $this->Model->setPdv_insserv('ENERGIA');

                            //define a CFOP do retorno por hora vamos no tipo = do movimento
                            $this->Model->setPDV_PedidoItemCFOP('5902');

                            //busca a unidade de medida
                            $oProdUn->Persistencia->limpaFiltro();
                            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                            $oProdDados = $oProdUn->Persistencia->consultarWhere();
                            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                            //seta valores específicos do retorno da mercadoria
                            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                            $this->Model->setPDV_PedidoItemConsideraVenda('S');

                            //seta o Xped e NitemPed na nota fiscal
                            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                            // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedEnergia());

                            //gera o valor total
                            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                            $ValorTotal = ($Qt * $ValorUni);
                            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                            //seta informações adicionais
                            $sInfAdicional = '';
                            if ($oTabCliDados->getConcatena() == true) {
                                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                            } else {
                                $this->Model->setPDV_PedidoItemObsDescricao('');
                            }

                            //insere os filtros
                            $this->insereFiltrosInsert();
                        } else {
                            $oModal = new Modal('Atenção', 'Não há cadastro de insumo ENERGIA desse produto, analise a tabela '
                                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                            echo $oModal->getRender();
                            exit();
                        }

                        break;
                }
                //Filtros para reload
                //insere os filtros
                $this->insereFiltrosInsert();
                //Inicia processo de inserção
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

                    //retorna aut incremento
                    $iAutoInc = $this->retornaValuInc();
                    //monta a mensagem

                    $msg = "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
                    echo $msg;
                    echo $oMsg->getRender();
                    $oFocus = new Base();
                    echo $oFocus->focus($aDados[3]);
                } else {
                    $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                    echo $oMsg->getRender();
                }
            }
            //busca dados para o grid
            $this->getDadosConsulta($aDados[2], true, null);
            //gera o total na tabela de cabeçalho
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
            $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
            $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
            $oPevCabTot->Persistencia->geraTotaliza($iValorTot, $aCampos);
            //gera o total de peso líguido e peso bruto
            $iPesoLiq = $oPevCabTot->Persistencia->buscaPeso($aCampos);
            //busca nr caixas
            $iVolumes = $oPevCabTot->Persistencia->retornaVolumes($aCampos);
            //atualiza no cabecalho
            $oPevCabTot->Persistencia->atualizaPeso($aCampos, $iPesoLiq, $iVolumes, $oPevCabDados->getPDV_PedidoEmpCodigo());
            //gera o totalizador para a tela
            $aTotal = $this->Persistencia->pesoInsumo($aChave);
            $sInsumo = '0';
            $sRetorno = '0';
            $sServico = '0';
            foreach ($aTotal as $key => $value) {
                switch ($value->pdv_insserv) {
                    case 'INSUMO':
                        $sInsumo = number_format($value->total, 2, ',', '.');
                        break;
                    case 'RETORNO':
                        $sRetorno = number_format($value->total, 2, ',', '.');
                        break;
                    case 'SERVIÇO':
                        $sServico = number_format($value->total, 2, ',', '.');
                        break;
                }
            }
            //aplica os valores
            echo '$("#' . $aDados[4] . '").val("' . number_format($iPesoLiq, 2, ',', '.') . '");';
            echo '$("#' . $aDados[5] . '").val("' . number_format($iVolumes, 2, ',', '.') . '");';
            //vamos gerar as parcelas do financeiro
            $this->parcelaPedido($aChave);
            //método que executa após limpar
            $this->afterResetForm($sId);

            //mostra modal certificado
            if ($aCampos['chkcert']) {
                echo '$("#modalApontaItem").modal("show");';
                echo 'requestAjax("","STEEL_PCP_Certificado","criaTelaModalAponta",'
                . '"modalApontaItem,id,pdv_pedidofilial=' . $this->Model->getPdv_PedidoFilial() . '&pdv_pedidocodigo=' . $this->Model->getPdv_pedidocodigo() . '&pdv_pedidoitemseq=' . $this->Model->getPdv_pedidoitemseq() . ',' . $aDados[3] . '");';
            }

            //insere as informações adicionais
            //$oCargaInsumoInf = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
        }
//------CASO O TIPO DA ORDEM DE PRODUÇÃO É DO TIPO FIO MÁQUINA ------------------------------------------------------------------        
        if ($oDadosOp->getTipoOrdem() == 'F') {

            //busca o retorno da indutrialização
            $this->Model->setPDV_PedidoItemProduto($oDadosOp->getProdFinal());
            $this->Model->setPDV_PedidoItemProdutoNomeManua($oDadosOp->getProdesFinal());
            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getQuant());
            $this->Model->setPDV_PedidoItemValorUnitario($oDadosOp->getVlrNfEntUnit());
            $this->Model->setOp($aCampos['op']);
            $this->Model->setPdv_insserv('RETORNO');
            //seta o peso
            $this->Model->setPesoOp($oDadosOp->getPeso());

            //define a CFOP do retorno por hora vamos no tipo = do movimento
            $this->Model->setPDV_PedidoItemCFOP('5902');



            //busca a unidade de medida
            $oProdUn->Persistencia->limpaFiltro();
            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
            $oProdDados = $oProdUn->Persistencia->consultarWhere();
            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

            //valida se há todos os itens cadastrados na tabela de preço

            if ($this->paramInsumoEnergia() == 'SIM') {
                $aInsumosServParam = array('SERVIÇO', 'INSUMO', 'ENERGIA');
            } else {
                $aInsumosServParam = array('SERVIÇO', 'INSUMO');
            }
            $oItensReceitaParam = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
            $oItensReceitaParam->Persistencia->adicionaFiltro('cod', $oDadosOp->getReceita());
            //gera os items da receita de modo distinc
            $aDadosItensReceitaParam = $oItensReceitaParam->Persistencia->distinctItemReceita($oDadosOp->getReceita());
            if ($this->paramValidaTabPreco() == 'SIM') {
                foreach ($aDadosItensReceitaParam as $key => $oTratParam) {
                    foreach ($aInsumosServParam as $key => $value) {
                        $this->validaTabelaFio($value, $oTabCliDados->getNr(), $oDadosOp->getReceita(), $oTratParam->tratcod, $oProdDados->getPro_ncm());
                    }
                }
            } //====>Fim da validacao se há tudo cadastrado na tabela
            //seta valores específicos do retorno da mercadoria
            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
            $this->Model->setPDV_PedidoItemGeraFinanceiro('N');
            $this->Model->setPDV_PedidoItemConsideraVenda('N');

            //seta o Xped e NitemPed na nota fiscal
            $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
            $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());

            //gera o valor total
            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
            $ValorTotal = ($Qt * $ValorUni);
            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

            //atualiza o nr da carga na ordem de produção
            $oOrdemProd = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOrdemProd->Persistencia->nrCarga($aCampos['op'], $aCampos['pdv_pedidocodigo']);

            //caso não seja metalbo carrega o código do produto do cliente
            $sInfAdicional = '';
            if ($oDadosOp->getEmp_codigo() !== '75483040000211') {
                $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia();
                $sInfAdicional .= ' Sua NF ' . $oDadosOp->getDocumento();
                if ($oDadosOp->getEmp_codigo() == '76812379000104') {
                    $sInfAdicional .= ' Pedido ' . $oDadosOp->getXPed();
                }
            } else {
                $sInfAdicional .= 'Sua NF ' . $oDadosOp->getDocumento();
                if ($oDadosOp->getXPed() !== null) {
                    $sInfAdicional .= ' OD ' . $oDadosOp->getXPed();
                }
            }
            $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
            //gera o insert do retorno
            //Filtros para reload
            //insere os filtros
            $this->insereFiltrosInsert();
            //Inicia processo de inserção
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

                //retorna aut incremento
                $iAutoInc = $this->retornaValuInc();
                //monta a mensagem

                $msg = "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
                echo $msg;
                echo $oMsg->getRender();
                $oFocus = new Base();
                echo $oFocus->focus($aDados[3]);
            } else {
                $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }




//--------------------------------------------------------------------------------------------------------------------------- 
            //novo método para inserir dando um foreach
            $oItensReceita = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
            $oItensReceita->Persistencia->adicionaFiltro('cod', $oDadosOp->getReceita());
            //gera os items da receita de modo distinc
            $aDadosItensReceita = $oItensReceita->Persistencia->distinctItemReceita($oDadosOp->getReceita());

            //verifica parametro se insere insumo de energia ou não 
            if ($this->paramInsumoEnergia() == 'SIM') {
                $aInsumosServ = array('SERVIÇO', 'INSUMO', 'ENERGIA');
            } else {
                $aInsumosServ = array('SERVIÇO', 'INSUMO');
            }

            //valida se está tudo cadastrado na tabela de preço
            /*  if($this->paramValidaTabPreco()=='SIM'){
              foreach ($aDadosItensReceita as $key => $oTratParam) {
              foreach ($aInsumosServ as $key => $value) {
              $this->validaTabelaFio($value,$oTabCliDados->getNr(),$oDadosOp->getReceita(),$oTratParam->tratcod,$oProdDados->getPro_ncm());
              }
              }
              } */

            foreach ($aDadosItensReceita as $key => $oTrat) {
                //gera o contator de quantos tratamentos há  
                $oItensReceita->Persistencia->limpaFiltro();
                $oItensReceita->Persistencia->adicionaFiltro('cod', $oDadosOp->getReceita());
                $oItensReceita->Persistencia->adicionaFiltro('tratcod', $oTrat->tratcod);
                //gera o total desse serviço para multiplicar com o valor encontrado na tabela de preço
                $iContServ = $oItensReceita->Persistencia->getCount();

                foreach ($aInsumosServ as $keyInsumoServ => $sAcao) {
                    switch ($sAcao) {
//------------------busca o serviço na tabela de preço -------------------------------------------------------                        
                        case "SERVIÇO":
                            $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                            $oItemsTabela->Persistencia->limpafiltro();
                            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());  //tabela de preco
                            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita()); //receita
                            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'SERVIÇO'); //insumo ou serviço
                            $oItemsTabela->Persistencia->adicionaFiltro('cod', $oTrat->tratcod); //codigo do tratamento somente qdo for op fio
                            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm()); //ncm
                            $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();  //consulta

                            if ($oDadosInsumo->getProd() !== null) {
                                //busca a unidade de medida e dados do produto
                                $oProdUn->Persistencia->limpaFiltro();
                                $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                                $oProdDados = $oProdUn->Persistencia->consultarWhere();

                                $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                                $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                                $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                                $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                                $this->Model->setOp($aCampos['op']);
                                $this->Model->setPdv_insserv('SERVIÇO');

                                //define a CFOP do retorno por hora vamos no tipo = do movimento
                                $this->Model->setPDV_PedidoItemCFOP('5902');

                                //seta unidade do produto
                                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                                //seta valores específicos do retorno da mercadoria
                                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                                $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                                $this->Model->setPDV_PedidoItemConsideraVenda('S');

                                //seta o Xped e NitemPed na nota fiscal
                                $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                                // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                                $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedServico());

                                //gera o valor total
                                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                                //multiplica a quantidade de serviço ou insumo
                                $ValorTotal = $Qt * ($iContServ * $ValorUni);
                                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);
                                //seta o valor unitário
                                $this->Model->setPDV_PedidoItemValorUnitario($iContServ * $ValorUni);
                                //se contador de serviços for >1 coloca no alerta a multiplicacao
                                if ($iContServ > 1) {
                                    $this->Model->setAlerta('Preço unitário ' . $ValorUni . ' * ' . $iContServ);
                                }


                                //seta informações adicionais
                                $sInfAdicional = '';
                                if ($oTabCliDados->getConcatena() == true) {
                                    $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                    $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                                } else {
                                    $this->Model->setPDV_PedidoItemObsDescricao('');
                                }

                                //insere os filtros
                                $this->insereFiltrosInsert();
                            } else {
                                $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                                echo $oModal->getRender();
                                exit();
                            }

                            break;
                        //------------------faz a busca pelo insumo-------------------------------------------------------------
                        case "INSUMO":
                            $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                            $oItemsTabela->Persistencia->limpafiltro();
                            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());  //tabela de preco
                            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita()); //receita
                            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'INSUMO'); //insumo ou serviço
                            $oItemsTabela->Persistencia->adicionaFiltro('cod', $oTrat->tratcod); //codigo do tratamento somente qdo for op fio
                            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm()); //ncm
                            $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();  //consulta

                            if ($oDadosInsumo->getProd() !== null) {
                                //busca a unidade de medida e os dados do produto
                                $oProdUn->Persistencia->limpaFiltro();
                                $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                                $oProdDados = $oProdUn->Persistencia->consultarWhere();

                                $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                                $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                                $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                                $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                                $this->Model->setOp($aCampos['op']);
                                $this->Model->setPdv_insserv('INSUMO');

                                //define a CFOP do retorno por hora vamos no tipo = do movimento
                                $this->Model->setPDV_PedidoItemCFOP('5902');

                                //seta a unidade de medida
                                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                                //seta valores específicos do retorno da mercadoria
                                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                                $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                                $this->Model->setPDV_PedidoItemConsideraVenda('S');

                                //seta o Xped e NitemPed na nota fiscal
                                $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                                //$this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                                $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedInsumo());

                                //gera o valor total
                                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                                $ValorTotal = $Qt * ($iContServ * $ValorUni);
                                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);
                                //seta valor unitário atualizado
                                $this->Model->setPDV_PedidoItemValorUnitario($iContServ * $ValorUni);
                                //se contador de serviços for >1 coloca no alerta a multiplicacao
                                if ($iContServ > 1) {
                                    $this->Model->setAlerta('Preço unitário ' . $ValorUni . ' * ' . $iContServ);
                                }

                                //seta informações adicionais
                                $sInfAdicional = '';
                                if ($oTabCliDados->getConcatena() == true) {
                                    $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                    $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                                } else {
                                    $this->Model->setPDV_PedidoItemObsDescricao('');
                                }

                                //insere os filtros
                                $this->insereFiltrosInsert();
                            } else {
                                $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                                echo $oModal->getRender();
                                exit();
                            }

                            break;

                        //--------------------------BUSCA ENERGIA ELÉTRICA------------------------------------------------
                        case 'ENERGIA' :

                            $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
                            $oItemsTabela->Persistencia->limpafiltro();
                            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());  //tabela de preco
                            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita()); //receita
                            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'ENERGIA'); //insumo ou serviço
                            $oItemsTabela->Persistencia->adicionaFiltro('cod', $oTrat->tratcod); //codigo do tratamento somente qdo for op fio
                            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm()); //ncm
                            $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();  //consulta*/



                            if ($oDadosInsumo->getProd() !== null) {
                                //busca a unidade de medida
                                $oProdUn->Persistencia->limpaFiltro();
                                $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                                $oProdDados = $oProdUn->Persistencia->consultarWhere();

                                $this->Model->setPDV_PedidoItemProduto($oDadosInsumo->getProd());
                                $this->Model->setPDV_PedidoItemProdutoNomeManua($oProdDados->getPro_descricao());
                                $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getPeso() - ($oDadosOp->getPesoDif()));
                                $this->Model->setPDV_PedidoItemValorUnitario($oDadosInsumo->getPreco());
                                $this->Model->setOp($aCampos['op']);
                                $this->Model->setPdv_insserv('ENERGIA');

                                //define a CFOP do retorno por hora vamos no tipo = do movimento
                                $this->Model->setPDV_PedidoItemCFOP('5902');

                                //busca a unidade de medida
                                $oProdUn->Persistencia->limpaFiltro();
                                $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
                                $oProdDados = $oProdUn->Persistencia->consultarWhere();
                                $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

                                //seta valores específicos do retorno da mercadoria
                                $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
                                $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
                                $this->Model->setPDV_PedidoItemConsideraVenda('S');

                                //seta o Xped e NitemPed na nota fiscal
                                $this->Model->setPDV_PedidoItemOrdemCompra($oDadosOp->getXPed());
                                // $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPed());
                                $this->Model->setPDV_PedidoItemSeqOrdemCompra($oDadosOp->getNItemPedEnergia());

                                //gera o valor total
                                $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
                                $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
                                $ValorTotal = ($Qt * $ValorUni);
                                $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

                                //seta informações adicionais
                                $sInfAdicional = '';
                                if ($oTabCliDados->getConcatena() == true) {
                                    $sInfAdicional = 'Seu Prod. ' . $oDadosOp->getReferencia() . ' ' . $oDadosOp->getProdesFinal();
                                    $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
                                } else {
                                    $this->Model->setPDV_PedidoItemObsDescricao('');
                                }

                                //insere os filtros
                                $this->insereFiltrosInsert();
                            } else {
                                $oModal = new Modal('Atenção', 'Não há cadastro de insumo ENERGIA desse produto, analise a tabela '
                                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                                echo $oModal->getRender();
                                exit();
                            }

                            break;
                    }
                    //Filtros para reload
                    //insere os filtros
                    $this->insereFiltrosInsert();
                    //Inicia processo de inserção
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
                        $oFocus = new Base();
                        echo $oFocus->focus($aDados[3]);
                    } else {
                        $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                        echo $oMsg->getRender();
                    }
                }
            }

            //atualiza o grid
            //busca dados para o grid
            $this->getDadosConsulta($aDados[2], true, null);
            //gera o total na tabela de cabeçalho
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
            $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
            $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
            $oPevCabTot->Persistencia->geraTotaliza($iValorTot, $aCampos);
            //gera o total de peso líguido e peso bruto
            $iPesoLiq = $oPevCabTot->Persistencia->buscaPeso($aCampos);
            //busca nr caixas
            $iVolumes = $oPevCabTot->Persistencia->retornaVolumes($aCampos);
            //atualiza no cabecalho
            $oPevCabTot->Persistencia->atualizaPeso($aCampos, $iPesoLiq, $iVolumes, $oPevCabDados->getPDV_PedidoEmpCodigo(), $oDadosOp->getTipoOrdem());
            //gera o totalizador para a tela
            $aTotal = $this->Persistencia->pesoInsumo($aChave);

            $sInsumo = '0';
            $sRetorno = '0';
            $sServico = '0';
            foreach ($aTotal as $key => $value) {
                switch ($value->pdv_insserv) {
                    case 'INSUMO':
                        $sInsumo = number_format($value->total, 2, ',', '.');
                        break;
                    case 'RETORNO':
                        $sRetorno = number_format($value->total, 2, ',', '.');
                        break;
                    case 'SERVIÇO':
                        $sServico = number_format($value->total, 2, ',', '.');
                        break;
                }
            }

            //aplica os valores
            echo '$("#' . $aDados[4] . '").val("' . number_format($iPesoLiq, 2, ',', '.') . '");';
            echo '$("#' . $aDados[5] . '").val("' . number_format($iVolumes, 2, ',', '.') . '");';
            //vamos gerar as parcelas do financeiro
            $this->parcelaPedido($aChave);
            //método que executa após limpar
            $this->afterResetForm($sId);

            //mostra modal certificado
            if ($aCampos['chkcert']) {
                echo '$("#modalApontaItem").modal("show");';
                echo 'requestAjax("","STEEL_PCP_Certificado","criaTelaModalAponta",'
                . '"modalApontaItem,id,pdv_pedidofilial=' . $this->Model->getPdv_PedidoFilial() . '&pdv_pedidocodigo=' . $this->Model->getPdv_pedidocodigo() . '&pdv_pedidoitemseq=' . $this->Model->getPdv_pedidoitemseq() . ',' . $aDados[3] . '");';
            }
        }

        //CASO O TIPO DA ORDEM É VENDA DE ARAME NESTE CASO DEVERIA SER O MOVIMENTO DE VENDA DE MERCADORIA
        if ($oDadosOp->getTipoOrdem() == 'A') {
            //inicialmente colocamos o retorno----------------------------------------------------------------------------------
            //busca o retorno da indutrialização
            $this->Model->setPDV_PedidoItemProduto($oDadosOp->getProdFinal());
            $this->Model->setPDV_PedidoItemProdutoNomeManua($oDadosOp->getProdesFinal());
            $this->Model->setPDV_PedidoItemQtdPedida($oDadosOp->getQuant());
            $this->Model->setPDV_PedidoItemValorUnitario($oDadosOp->getVlrNfEntUnit());
            $this->Model->setOp($aCampos['op']);
            $this->Model->setPdv_insserv('RETORNO');
            //seta o peso
            $this->Model->setPesoOp($oDadosOp->getPeso());

            //define a CFOP do retorno por hora vamos no tipo = do movimento
            $this->Model->setPDV_PedidoItemCFOP('5902');

            //busca a unidade de medida
            $oProdUn->Persistencia->limpaFiltro();
            $oProdUn->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPDV_PedidoItemProduto());
            $oProdDados = $oProdUn->Persistencia->consultarWhere();
            $this->Model->setPDV_PedidoItemProdutoUnidadeMa($oProdDados->getDELX_PRO_UnidadeMedida()->getPro_unidademedida());

            //seta valores específicos do retorno da mercadoria
            $this->Model->setPDV_PedidoItemMovimentaEstoque('N');
            $this->Model->setPDV_PedidoItemGeraFinanceiro('S');
            $this->Model->setPDV_PedidoItemConsideraVenda('S');

            //gera o valor total
            $Qt = $this->Model->getPDV_PedidoItemQtdPedida();
            $ValorUni = $this->Model->getPDV_PedidoItemValorUnitario();
            $ValorTotal = ($Qt * $ValorUni);
            $this->Model->setPDV_PedidoItemValorTotal($ValorTotal);

            //atualiza o nr da carga na ordem de produção
            $oOrdemProd = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOrdemProd->Persistencia->nrCarga($aCampos['op'], $aCampos['pdv_pedidocodigo']);

            //caso não seja metalbo carrega o código do produto do cliente
            $sInfAdicional = '';
            /* if($oDadosOp->getEmp_codigo()!=='75483040000211'){
              $sInfAdicional = 'Seu Prod.-> '.$oDadosOp->getReferencia();
              $sInfAdicional .= ' Sua NF-> '.$oDadosOp->getDocumento();
              } */
            $sInfAdicional .= 'Sua OC-' . $oDadosOp->getDocumento();
            if ($oDadosOp->getXPed() !== null) {
                $sInfAdicional .= ' Pedido ' . $oDadosOp->getXPed();
            }
            $this->Model->setPDV_PedidoItemObsDescricao($sInfAdicional);
            //gera o insert do retorno
            //Filtros para reload
            //insere os filtros
            $this->insereFiltrosInsert();
            //Inicia processo de inserção
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
                $oFocus = new Base();
                echo $oFocus->focus($aDados[3]);
            } else {
                $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }

            //atualiza o grid
            //busca dados para o grid
            $this->getDadosConsulta($aDados[2], true, null);
            //gera o total na tabela de cabeçalho
            $this->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
            $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
            $iValorTot = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');
            $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
            $oPevCabTot->Persistencia->geraTotaliza($iValorTot, $aCampos);
            //gera o total de peso líguido e peso bruto
            $iPesoLiq = $oPevCabTot->Persistencia->buscaPeso($aCampos);
            //busca nr caixas
            $iVolumes = $oPevCabTot->Persistencia->retornaVolumes($aCampos);
            //atualiza no cabecalho
            $oPevCabTot->Persistencia->atualizaPeso($aCampos, $iPesoLiq, $iVolumes, $oPevCabDados->getPDV_PedidoEmpCodigo());
            //gera o totalizador para a tela
            $aTotal = $this->Persistencia->pesoInsumo($aChave);
            $sInsumo = '0';
            $sRetorno = '0';
            $sServico = '0';
            foreach ($aTotal as $key => $value) {
                switch ($value->pdv_insserv) {
                    case 'INSUMO':
                        $sInsumo = number_format($value->total, 2, ',', '.');
                        break;
                    case 'RETORNO':
                        $sRetorno = number_format($value->total, 2, ',', '.');
                        break;
                    case 'SERVIÇO':
                        $sServico = number_format($value->total, 2, ',', '.');
                        break;
                }
            }
            //aplica os valores
            echo '$("#' . $aDados[4] . '").val("' . number_format($iPesoLiq, 2, ',', '.') . '");';
            echo '$("#' . $aDados[5] . '").val("' . number_format($iVolumes, 2, ',', '.') . '");';

            //vamos gerar as parcelas do financeiro
            $this->parcelaPedido($aChave);
            //método que executa após limpar
            $this->afterResetForm($sId);

            //mostra modal certificado
            if ($aCampos['chkcert']) {
                echo '$("#modalApontaItem").modal("show");';
                echo 'requestAjax("","STEEL_PCP_Certificado","criaTelaModalAponta",'
                . '"modalApontaItem,id,pdv_pedidofilial=' . $this->Model->getPdv_PedidoFilial() . '&pdv_pedidocodigo=' . $this->Model->getPdv_pedidocodigo() . '&pdv_pedidoitemseq=' . $this->Model->getPdv_pedidoitemseq() . ',' . $aDados[3] . '");';
            }
        }
    }

    /**
     * Seta valores padroes para os itens que não passam na tabela de parametros
     */
    public function setaPadraoItem() {
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
    public function validaZero($aCampos) {
        //verifica valor zerado no retorno
        $sErro = '';
        if ($aCampos['PDV_PedidoItemQtdPedida'] == '0,00' || $aCampos['PDV_PedidoItemQtdPedida'] == '' || $aCampos['PDV_PedidoItemQtdPedida'] == '0') {
            $sErro .= 'Quantidade pedida do RETORNO não pode ser zero! ';
        }
        if ($aCampos['PDV_PedidoItemValorUnitario'] == '0,00' || $aCampos['PDV_PedidoItemValorUnitario'] == '' || $aCampos['PDV_PedidoItemValorUnitario'] == '0') {
            $sErro .= 'Valor unitário do RETORNO não pode ser zero! ';
        }
        if ($aCampos['insumoQt'] == '0,00' || $aCampos['insumoQt'] == '' || $aCampos['insumoQt'] == '0') {
            $sErro .= 'Quantidade do insumo não pode ser zero! ';
        }
        if ($aCampos['insumoVlr'] == '0,00' || $aCampos['insumoVlr'] == '' || $aCampos['insumoVlr'] == '0') {
            $sErro .= 'Valor do insumo não pode ser zero! ';
        }
        if ($aCampos['servicoQt'] == '0,00' || $aCampos['servicoQt'] == '' || $aCampos['servicoQt'] == '0') {
            $sErro .= 'Quantidade do serviço não pode ser zero! ';
        }
        if ($aCampos['servicoVlr'] == '0,00' || $aCampos['servicoVlr'] == '' || $aCampos['servicoVlr'] == '0') {
            $sErro .= 'Valor do serviço não pode ser zero! ';
        }


        if ($sErro !== '') {
            $oMensagem = new Modal('Atenção', $sErro, Modal::TIPO_ERRO, false, true, false);
            echo $oMensagem->getRender();
            exit();
        }
    }

    /**
     * Filtros para o foreach
     */
    public function insereFiltrosInsert() {
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
        $oCargaInsumos->Model->setAlerta($this->Model->getAlerta());
        $oCargaInsumos->Model->setPesoOp($this->Model->getPesoOp());

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
        $aInsumosServ = array('RETORNO', 'INSUMO', 'SERVIÇO');
        foreach ($aInsumosServ as $key => $value) {

            switch ($value) {
                case "INSUMO":
                    $this->Model->setPDV_PedidoItemProduto($aCampos['insumoCod']);
                    $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['insumoNome']);
                    $this->Model->setPDV_PedidoItemQtdPedida(str_replace(',', '.', $aCampos['insumoQt']));
                    $this->Model->setPDV_PedidoItemValorUnitario(str_replace(',', '.', $aCampos['insumoVlr']));
                    //$this->Model->setPdv_pedidoitemseq($this->Model->getPdv_pedidoitemseq()+1);
                    break;
                case "SERVIÇO":
                    $this->Model->setPDV_PedidoItemProduto($aCampos['servicoCod']);
                    $this->Model->setPDV_PedidoItemProdutoNomeManua($aCampos['servicoDes']);
                    $this->Model->setPDV_PedidoItemQtdPedida(str_replace(',', '.', $aCampos['servicoQt']));
                    $this->Model->setPDV_PedidoItemValorUnitario(str_replace(',', '.', $aCampos['servicoVlr']));
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

    public function carregaDefault() {
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

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }

    /**
     * Método que mostra a mensagem do excluir 
     */
    public function msgExcluirItensCarga($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Atenção', 'Será deletado os insumos e os serviços desse item.', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("' . $aDados[1] . '-form","' . $sClasse . '","excluirItensCarga","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    /**
     * Método excluir especial 
     */
    public function excluirItensCarga($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //consulta qual é sua op
        $oCargaInsumos = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
        //seta o model os dados do model PedCargaItens
        $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCamposChave['pdv_pedidofilial']);
        $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCamposChave['pdv_pedidocodigo']);
        $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $aCamposChave['pdv_pedidoitemseq']);
        //vamos consultar a op base

        $oOp = $oCargaInsumos->Persistencia->consultarWhere();

        //consulta as sequencias da ordem de carga a serem deletadas

        $oCargaInsumos->Persistencia->limpaFiltro();
        //vai verificar se tem ordem de produção neste item

        $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCamposChave['pdv_pedidofilial']);
        $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCamposChave['pdv_pedidocodigo']);
        $oCargaInsumos->Persistencia->adicionaFiltro('op', $oOp->getOp());

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
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidofilial', $oValue->getPdv_pedidofilial());
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidocodigo', $oValue->getPdv_pedidocodigo());
            $oCargaInsumos->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $oValue->getPdv_pedidoitemseq());
            $oCargaInsumos->Persistencia->excluir();
        }
        // Retorna Mensagem Informando o Sucesso da Exlusão do registro
        $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
        echo $oMensagemSucesso->getRender();

        //atualiza o valor total do cabeçalho
        $oPedItens = Fabrica::FabricarController('STEEL_PCP_PedCargaItens');
        $oPedItens->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCamposChave['pdv_pedidofilial']);
        $oPedItens->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCamposChave['pdv_pedidocodigo']);
        $iTotalItens = $oPedItens->Persistencia->getSoma('PDV_PedidoItemValorTotal');
        //gera update no cabeçalho
        $oPevCabTot = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCabTot->Persistencia->geraTotaliza($iTotalItens, $aCamposChave);
        //atualiza a ordem de produçao
        $oOpCarga = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpCarga->Persistencia->limpaCarga($oOp->getOp());

        //se necessário adiciona filtro de reload
        $this->filtroReload($sChave);

        //Atualiza o Grid
        $this->getDadosConsulta($aDados[1], false, null);
        //atualiza os contadores
        //gera o totalizador para a tela
        $aChave[0] = $aCamposChave['pdv_pedidofilial'];
        $aChave[1] = $aCamposChave['pdv_pedidocodigo'];
        $aTotal = $this->Persistencia->pesoInsumo($aChave);
        $sInsumo = '0';
        $sRetorno = '0';
        $sServico = '0';
        foreach ($aTotal as $key => $value) {
            switch ($value->pdv_insserv) {
                case 'INSUMO':
                    $sInsumo = number_format($value->total, 2, ',', '.');
                    break;
                case 'RETORNO':
                    $sRetorno = number_format($value->total, 2, ',', '.');
                    break;
                case 'SERVIÇO':
                    $sServico = number_format($value->total, 2, ',', '.');
                    break;
            }
        }
        //aplica os valores
        //echo '$("[name=retorno]").text("PESO/QUANT. RETORNO: ' .$sRetorno. '");';

        $this->parcelaPedido($aChave);
        //atualiza o peso
        //consulta a tabela de preço
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aChave[0]);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aChave[1]);
        $oPevDadosCab = $oPevCab->Persistencia->consultarWhere();

        //gera o total de peso líguido e peso bruto
        $iPesoLiq = $oPevCabTot->Persistencia->buscaPeso($aCamposChave);
        //busca nr caixas
        $iVolumes = $oPevCabTot->Persistencia->retornaVolumes($aCamposChave);
        //atualiza no cabecalho
        $oPevCabTot->Persistencia->atualizaPeso($aCamposChave, $iPesoLiq, $iVolumes, $oPevDadosCab->getPDV_PedidoEmpCodigo());

        //joga dados na tela
        //aplica os valores
        echo '$("[name=retorno]").val("' . number_format($iPesoLiq, 2, ',', '.') . '");';
        echo '$("[name=volumes]").val("' . number_format($iVolumes, 2, ',', '.') . '");';
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
    public function parcelaPedido($aChave) {
        //pegamos o valor total a gerar as parcelas
        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('pdv_pedidofilial', '8993358000174');
        $this->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aChave[1]);
        $this->Persistencia->adicionaFiltro('pdv_pedidoitemgerafinanceiro', 'S');

        $iTotal = $this->Persistencia->getSoma('PDV_PedidoItemValorTotal');

        //consulta a tabela de preço
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aChave[0]);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aChave[1]);
        $oPevDadosCab = $oPevCab->Persistencia->consultarWhere();
        $iCondPag = $oPevDadosCab->getPDV_PedidoCondicaoPgtoCodigo();


        $aChave[3] = $iCondPag;
        //define valor da percela 
        $oCondPag = Fabrica::FabricarController('DELX_CPG_CondicaoPagamento');
        $oCondPag->Persistencia->adicionaFiltro('cpg_codigo', $iCondPag);
        $oCondPagDados = $oCondPag->Persistencia->consultarWhere();
        $iNrParcela = $oCondPagDados->getCpg_numeroparcelas();
        $iValorParc = $iTotal / $iNrParcela;

        //busca as parcelas 
        $aParcelas = $this->Persistencia->parcCondPag($aChave);
        //fabrica a parcela 
        $oParcelaPed = Fabrica::FabricarController('STEEL_PCP_PedidoParcela');
        $oParcelaPed->Persistencia->adicionaFiltro('pdv_pedidofilial', $aChave[0]);
        $oParcelaPed->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aChave[1]);
        //deleta parcelas existentes!!!!!!!!!!!!!!!!
        $oParcelaPed->Persistencia->excluir();


        //vai gerar o insert da parcela no pedido
        if ($iTotal > 0) {
            foreach ($aParcelas as $key => $oValue) {

                //seta o model para inserção
                $oParcelaPed->Model->setPdv_pedidofilial($aChave[0]);
                $oParcelaPed->Model->setPdv_pedidocodigo($aChave[1]);
                $oParcelaPed->Model->setPdv_pedidoparcelaseq($oValue->cpg_numeroparcela);
                $oParcelaPed->Persistencia->setModel($oParcelaPed->Model);
                //faz o cálculo da data 
                $dataAtual = date('d/m/Y');
                $data = date('d/m/Y', strtotime("+" . $oValue->cpg_diasparcela . " days")); //date('d/m/Y',strtotime("+".$oValue->cpg_diasparcela." day", strtotime($dataAtual)));

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

    public function telaInsert($sDados) {
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aOp = explode('=', $aChave[0]);

        $aDadosTela = $this->buscaCargaModal();
        //busca lista pela op
        $this->View->criaTelaInsert($aDadosTela);

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    /**
     * busca os dados para montar o retorno
     */
    public function buscaCargaModal() {
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //monta mvc do cabecalho
        $oPevCab = Fabrica::FabricarController('STEEL_PCP_PedCarga');
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidofilial', $aCampos['pdv_pedidofilial']);
        $oPevCab->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aCampos['pdv_pedidocodigo']);
        $oPevCabDados = $oPevCab->Persistencia->consultarWhere();

        //busca a tabela do cliente
        $oTabCli = Fabrica::FabricarController('STEEL_PCP_TabCabPreco');
        $oTabCli->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $oTabCli->Persistencia->adicionaFiltro('sit', 'INATIVA', 0, 10);
        $oTabCliDados = $oTabCli->Persistencia->consultarWhere();


        //Fabrica a controller STEEL_PCP_OrdensFab e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOpSteel->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpSteel->Persistencia->adicionaFiltro('emp_codigo', $oPevCabDados->getPDV_PedidoEmpCodigo());
        $iNrOp = $oOpSteel->Persistencia->getCount();
        if ($iNrOp > 0) {
            //---------------------BUSCA O RETORNO, quant, valor, verifica quando é arame------------------------
            $aDadosTela = array();
            $oDadosOp = $oOpSteel->Persistencia->consultarWhere();
            $oProdutoFinal = Fabrica::FabricarController('DELX_PRO_Produtos');
            $oProdutoFinal->Persistencia->adicionaFiltro('pro_codigo', $oDadosOp->getProdFinal());
            $oDadosProdFinal = $oProdutoFinal->Persistencia->consultarWhere();
            $aDadosTela['ProdutoFinal'] = $oDadosOp->getProdFinal();
            $aDadosTela['ProdutoFinalDes'] = $oDadosOp->getProdesFinal();
            $aDadosTela['Quant'] = $oDadosOp->getQuant();
            $aDadosTela['ValorEnt'] = $oDadosOp->getVlrNfEntUnit();
            $aDadosTela['TotalRetorno'] = $oDadosOp->getVlrNfEnt();
            //--------------------BUSCA O INSUMO------------------------------------------------------------------
            $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'INSUMO');
            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oDadosProdFinal->getPro_ncm());
            $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();
            //verifica se há cadastro do insumo
            if ($oDadosInsumo->getProd() !== null) {
                $aDadosTela['codInsumo'] = $oDadosInsumo->getProd();
                //busca descrição do insumo
                $oProd = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oProd->Persistencia->adicionaFiltro('pro_codigo', $oDadosInsumo->getProd());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['insumoDes'] = $oProdDados->getPro_descricao();
                //busca peso
                $aDadosTela['insumoQt'] = $oDadosOp->getPeso();
                $aDadosTela['insumoVlr'] = $oDadosInsumo->getPreco();
                $aDadosTela['insumoTotal'] = $aDadosTela['insumoQt'] * $aDadosTela['insumoVlr'];
            } else {
                $oModal = new Modal('Atenção', 'Não há cadastro do insumo desse produto, analise a tabela '
                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                echo $oModal->getRender();
            }
            // -----------------------Fim do insumo---------------------------------------------------------------
            //------------------------BUSCA O SERVIÇO---------------------------------------------------------------
            $oItemsTabela->Persistencia->limpaFiltro();
            $oItemsTabela->Persistencia->adicionaFiltro('nr', $oTabCliDados->getNr());
            $oItemsTabela->Persistencia->adicionaFiltro('receita', $oDadosOp->getReceita());
            $oItemsTabela->Persistencia->adicionaFiltro('tipo', 'SERVIÇO');
            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oDadosProdFinal->getPro_ncm());
            $oDadosServico = $oItemsTabela->Persistencia->consultarWhere();

            if ($oDadosServico->getProd() !== null) {
                //Servico
                $aDadosTela['codServ'] = $oDadosServico->getProd();
                $oProd = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oProd->Persistencia->adicionaFiltro('pro_codigo', $oDadosServico->getProd());
                $oProdDados = $oProd->Persistencia->consultarWhere();
                $aDadosTela['codServDes'] = $oProdDados->getPro_descricao();
                $aDadosTela['ServicoQt'] = $oDadosOp->getPeso();
                $aDadosTela['ServicoVlr'] = $oDadosServico->getPreco();
                $aDadosTela['ServicoTotal'] = $aDadosTela['ServicoQt'] * $aDadosTela['ServicoVlr'];
            } else {
                $oModal = new Modal('Atenção', 'Não há cadastro de serviço desse produto, analise a tabela '
                        . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                        . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
                echo $oModal->getRender();
            }
        } else {
            $oMensagem = new Modal('Atenção!', 'Esta ordem de produção não existe ou não pertence a empresa da carga, '
                    . 'verifique o número da ordem de produção!', Modal::TIPO_AVISO, false, true);
            echo $oMensagem->getRender();
        }
        return $aDadosTela;
    }

    /**
     * Método após resetar form
     */
    public function afterResetForm($sDados) {
        parent::afterResetForm($sDados);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aParam = explode(',', $sDados);
        //style224095c927ce998d42
        if ($aCampos['chkcert']) {
            echo '$("#' . $aParam[7] . '").attr("checked", true);';
        } else {
            echo '$("#' . $aParam[7] . '").attr("checked", false);';
        }
    }

    /**
     * Verifica parametro insumo energia
     */
    public function paramInsumoEnergia() {
        $oSTEEL_PCP_ParametrosProd = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
        $oSTEEL_PCP_ParametrosProd->Persistencia->adicionaFiltro('parametro', 'ATIVA FATURAMENTO INSUMO ENERGIA');
        $oSteelDados = $oSTEEL_PCP_ParametrosProd->Persistencia->consultarWhere();
        $sRetorno = $oSteelDados->getValor();
        return $sRetorno;
    }

    /**
     * Verifica parametro insumo energia
     */
    public function paramValidaTabPreco() {
        $oSTEEL_PCP_ParametrosProd = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
        $oSTEEL_PCP_ParametrosProd->Persistencia->adicionaFiltro('parametro', 'ATIVA VALIDACAO TABELA DE PRECO NA CARGA');
        $oSteelDados = $oSTEEL_PCP_ParametrosProd->Persistencia->consultarWhere();
        $sRetorno = $oSteelDados->getValor();
        return $sRetorno;
    }

    /**
     * Valida tabela de preço retorno fio máquina tipo op F
     */
    public function validaTabelaFio($sTipo, $sTabela, $sReceita, $sTratcod, $sNcm) {
        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
        $oItemsTabela->Persistencia->limpafiltro();
        $oItemsTabela->Persistencia->adicionaFiltro('nr', $sTabela);  //tabela de preco
        $oItemsTabela->Persistencia->adicionaFiltro('receita', $sReceita); //receita
        $oItemsTabela->Persistencia->adicionaFiltro('tipo', $sTipo); //insumo ou serviço
        $oItemsTabela->Persistencia->adicionaFiltro('cod', $sTratcod); //codigo do tratamento somente qdo for op fio
        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $sNcm); //ncm
        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();  //consulta

        if ($oDadosInsumo->getProd() == null) {
            $oModal = new Modal('Atenção', 'Não há cadastro de ' . $sTipo . ' desse produto, analise a tabela '
                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
            echo $oModal->getRender();
            exit();
        }
    }

    /**
     * Valida tabela de preço retorno fio máquina tipo op F
     */
    public function validaTabelaPadrao($sTipo, $sTabela, $sReceita, $sNcm) {
        $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
        $oItemsTabela->Persistencia->adicionaFiltro('nr', $sTabela);
        $oItemsTabela->Persistencia->adicionaFiltro('receita', $sReceita);
        $oItemsTabela->Persistencia->adicionaFiltro('tipo', $sTipo);
        $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $sNcm);
        $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();


        if ($oDadosInsumo->getProd() == null) {
            $oModal = new Modal('Atenção', 'Não há cadastro de ' . $sTipo . ' desse produto, analise a tabela '
                    . 'de preço se há o devido cadastro, verifique se há o cadastro referente a NCM. '
                    . 'Se optar poderá inserir o insumo manualmente!', Modal::TIPO_AVISO, false, true, false);
            echo $oModal->getRender();
            exit();
        }
    }

    public function gravaOd($sDados) {
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]);
        $aRetorno = $this->Persistencia->alteraOd($aDados[2], $this->Model->getPdv_PedidoFilial(), $this->Model->getPdv_pedidocodigo(), $this->Model->getPdv_pedidoitemseq());
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Valor alterado.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Valor não foi alterado, é necessário informar um valor válido para alterar!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function gravaSeqOd($sDados) {
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]);
        $aRetorno = $this->Persistencia->alteraSeqOd(number_format($aDados[2]), $this->Model->getPdv_PedidoFilial(), $this->Model->getPdv_pedidocodigo(), $this->Model->getPdv_pedidoitemseq());
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Valor alterado.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Valor não foi alterado, é necessário informar um número válido para alterar a sequência!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

}
