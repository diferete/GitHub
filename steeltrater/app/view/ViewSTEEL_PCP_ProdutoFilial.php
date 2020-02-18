<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 15/02/2019
 */

class ViewSTEEL_PCP_ProdutoFilial extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oProduto = new CampoConsulta('Produto', 'pro_codigo');
        $oProdutoFiltro = new Filtro($oProduto, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);
        $oFantasia = new CampoConsulta('Fantasia', 'DELX_FIL_Empresa.fil_fantasia');
        $oFiltroFant = new Filtro($oFantasia, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oGrupo = new CampoConsulta('Grupo', 'DELX_PRO_Produtos.pro_grupocodigo');
        $oSubGrupo = new CampoConsulta('SubGrupo', 'DELX_PRO_Produtos.pro_subgrupocodigo');
        $oFamilia = new CampoConsulta('Família', 'DELX_PRO_Produtos.pro_familiacodigo');
        $oSubFamilia = new CampoConsulta('SubFamília', 'DELX_PRO_Produtos.pro_subfamiliacodigo');
        $oDataBloqueio = new CampoConsulta('Data de Bloqueio', 'pro_filialdtbloqueado', CampoConsulta::TIPO_DATA);
        $oItemMovEst = new CampoConsulta('Item Movimenta Estoque', 'pro_filialestoque');
        $oProdutoComp = new CampoConsulta('Produto Composto', 'pro_filialitemcomposto');
        $oTipoContFat = new CampoConsulta('Tipo de Controle para Faturamento Pedido/Controle', 'pro_filialcontrolasaldo');
        $oResEstEstPedid = new CampoConsulta('Reserva Estoque da Estrutura no Pedido de Venda', 'pro_filialreservaestoqueestrut');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oProdutoFiltro, $oFiltroFant);

        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setiAltura(400);
        $this->getTela()->setBGridResponsivo(false);

        $this->setBScrollInf(false);
        $this->addCampos($oFantasia, $oGrupo, $oSubGrupo, $oFamilia, $oSubFamilia, $oDataBloqueio, $oItemMovEst, $oProdutoComp, $oTipoContFat, $oResEstEstPedid);
    }

    public function criaTela() {
        parent::criaTela();

        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Geral');
        $oAbaGeral->setBActive(true);

        $oAbaAlmox = new AbaTabPanel('Almoxarifados');
        $oAbaDespe = new AbaTabPanel('Despesas');
        $oAbaForne = new AbaTabPanel('Fornecedores');
        $oAbaClien = new AbaTabPanel('Clientes');
        $oAbaEstGrad = new AbaTabPanel('Estoque Mín/Máx na Grade');
        $oAbaFecEst = new AbaTabPanel('Fechamento de Estoque');
        $oAbaBloqMod = new AbaTabPanel('Bloqueio do Módulo');

        $this->addLayoutPadrao('Aba');


        $oL = new Campo('', 'label1', Campo::TIPO_LINHA);
        $oL->setApenasTela(true);
        $oB = new Campo('', 'label1', Campo::TIPO_LINHABRANCO);
        $oB->setApenasTela(true);

        $oProduto = new Campo('Produto', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProduto->setBCampoBloqueado(true);
        $oProdutoDes = new Campo('Descrição', 'DELX_PRO_Produtos.pro_descricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oProdutoDes->setBCampoBloqueado(true);
        $oFantasia = new Campo('Filial', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFantasia->setBCampoBloqueado(true);

        $sTituloA = new Campo('Informações Gerais', 'label1', Campo::TIPO_LABEL);
        $sTituloA->setApenasTela(true);


        $oGrupo = new Campo('Grupo', 'DELX_PRO_Produtos.pro_grupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oGrupo->setBCampoBloqueado(true);
        $oSubGrupo = new Campo('SubGrupo', 'DELX_PRO_Produtos.pro_subgrupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSubGrupo->setBCampoBloqueado(true);
        $oFamilia = new Campo('Família', 'DELX_PRO_Produtos.pro_familiacodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFamilia->setBCampoBloqueado(true);
        $oSubFamilia = new Campo('SubFamília', 'DELX_PRO_Produtos.pro_subfamiliacodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSubFamilia->setBCampoBloqueado(true);

        $oTipoGrupo = new Campo('Tipo do Grupo', 'pro_produtofilialgrupotipo', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oTipoGrupo->addItemSelect(' ', 'Não Informado');
        $oTipoGrupo->addItemSelect('00', 'Mercadoria para Revenda');
        $oTipoGrupo->addItemSelect('01', 'Matéria-prima');
        $oTipoGrupo->addItemSelect('02', 'Embalagem');
        $oTipoGrupo->addItemSelect('03', 'Produto em Processo');
        $oTipoGrupo->addItemSelect('04', 'Produto Acabado');
        $oTipoGrupo->addItemSelect('05', 'SubProduto');
        $oTipoGrupo->addItemSelect('06', 'Produto Intermediário');
        $oTipoGrupo->addItemSelect('07', 'Material de Uso e Consumo');
        $oTipoGrupo->addItemSelect('08', 'Ativo Imobilizado');
        $oTipoGrupo->addItemSelect('09', 'Serviços');
        $oTipoGrupo->addItemSelect('10', 'Outros Insumos');
        $oTipoGrupo->addItemSelect('99', 'Outros');

        $oDataBloqueio = new Campo('Data de Bloqueio', 'pro_filialdtbloqueado', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oMotivoBloqueio = new Campo('Motivo Bloqueio', 'pro_filialmotivobloqueio', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oItemMovEst = new Campo('Item Mov. Est.', 'pro_filialestoque', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oItemMovEst->addItemSelect('S', 'Sim');
        $oItemMovEst->addItemSelect('N', 'Não');

        $oPermEstNeg = new Campo('Per.Est.Neg.', 'pro_filialnegativo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEstMin = new Campo('Estoque Mín.', 'pro_filialestminimo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDiasEstMin = new Campo('Dias Est. Mín.', 'pro_filialestminimodias', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPontRepos = new Campo('Pont. Repos.', 'pro_filialestpontorep', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEstMax = new Campo('Estoque Máx.', 'pro_filialestmaximo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDiasEstMax = new Campo('Dias Est. Máx.', 'pro_filialestmaximodias', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataUltInvRot = new Campo('Data do Últ. Invent. Rot.', 'pro_filialdtinventariorota', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oProdutoComp = new Campo('Prod. Comp.', 'pro_filialitemcomposto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipoContFat = new Campo('Tip.Contr.Fatur.Ped/Cont', 'pro_filialcontrolasaldo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoContFat->addItemSelect('Q', 'Quantidade');
        $oTipoContFat->addItemSelect('V', 'Valor');

        $oResEstEstPedid = new Campo('Reser.Est.Estrut.Ped.Venda', 'pro_filialreservaestoqueestrut', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQntMultPad = new Campo('Quant. Mult. Pad.', 'pro_filialquantidademultpadrao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProdututividade = new Campo('Produtividade', 'pro_filialqtdprodutividade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProContVeiculo = new Campo('Prod.Controlado Veículo?', 'pro_filialveiculo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        // $sTituloB = new Campo('Compras','label1', Campo::TIPO_LABEL);
        // $sTituloB->setApenasTela(true); 

        $sTituloB = new FieldSet('Compras');
        $sTituloB->setOculto(true);

        $oPrior = new Campo('Prioridade', 'pro_filialprioridade', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPrior->addItemSelect('1', 'PADRÃO');

        $oFilialComp = new Campo('Comprador', 'pro_filialcomprador', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPerExValUn = new Campo('Percentual Excedente de Valor Unitário', 'pro_filialcomprapercdifvalor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPerExQnt = new Campo('Percentual Excedente de Quantidade', 'pro_filialcomprapercdifqtd', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        // $sTituloC = new Campo('MRP','label1', Campo::TIPO_LABEL);
        // $sTituloC->setApenasTela(true);

        $sTituloC = new FieldSet('MRP');
        $sTituloC->setOculto(true);

        $oPlan = new Campo('Planejamento no MRP', 'pro_filialmrpplanejamento', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oPlan->addItemSelect('S', 'Considerar no MRP');
        $oPlan->addItemSelect('M', 'Considerar no MRP com Estoque de Segurança');
        $oPlan->addItemSelect('A', 'Considerar no MRP sem Considerar Entradas');
        $oPlan->addItemSelect('N', 'Não Considerar no MRP');
        $oPlan->addItemSelect('E', 'Não Considerar no MRP expludindo Estrutura');

        $oTipOrd = new Campo('Tipo de Ordem', 'pro_filialmrptipoordem', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipOrd->addItemSelect('A', 'Automática');
        $oTipOrd->addItemSelect('M', 'Manual');

        $oDcomp = new Campo('Dias de Compra', 'pro_filialmrpdiascompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDprod = new Campo('Dias de Produção', 'pro_filialmrpdiasproducao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDqntd = new Campo('Dias na Qualidade', 'pro_filialmrpdiasqualidade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDforn = new Campo('Dias de Fornecedor', 'pro_filialmrpdiasfornecedor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTipEstMin = new Campo('Tipo do Estoque Mínimo', 'pro_filialestminimotipo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPerEstMin = new Campo('Períodos do Estoque Mínimo', 'pro_filialestminimoperiodo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQntLotMin = new Campo('Quantidade Lote Mínimo', 'pro_filialmrploteminimoqtd', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQntLotMul = new Campo('Quantidade Lote Múltiplo', 'pro_filialmrplotemultiploqtd', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiasAgrup = new Campo('Dias de Agrupamento', 'pro_filialmrpdiasagrupamento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQntLotPro = new Campo('Quantidade Lote Produção', 'pro_filialloteproducaoqtd', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAcaoMrp = new Campo('Ação no MRP', 'pro_filialmrpacao', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oAcaoMrp->addItemSelect('P', 'Produzir');
        $oAcaoMrp->addItemSelect('C', 'Comprar');

        $oFilialPro = new Campo('Filial da Produção', 'pro_filialmrpfilial', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        // $sTituloD = new Campo('FINAME','label1', Campo::TIPO_LABEL);
        // $sTituloD->setApenasTela(true); 

        $sTituloD = new FieldSet('FINAME');
        $sTituloD->setOculto(true);

        $oCod = new Campo('Código', 'pro_filialcodigofiname', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oDes = new Campo('Descrição', 'pro_filialdescricaofiname', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        //$sTituloE = new Campo('Controle de Números de Série','label1', Campo::TIPO_LABEL);
        //$sTituloE->setApenasTela(true); 

        $sTituloE = new FieldSet('Controle de Números de Série');
        $sTituloE->setOculto(true);

        $oRefSer = new Campo('Referência de Número de Série', 'pro_filialreferenciaserie', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        //$sTituloF = new Campo('Espécie Padão Nota Fiscal','label1', Campo::TIPO_LABEL);
        //$sTituloF->setApenasTela(true);

        $sTituloF = new FieldSet('Espécie Padão Nota Fiscal');
        $sTituloF->setOculto(true);

        $oEspPad = new Campo('Espécie padrão na nota fiscal', 'pro_filialespeciepadrao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEspCap = new Campo('Capacidade', 'pro_filialespeciecapacidade', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $sTituloB->addCampos(array($oPrior, $oFilialComp, $oPerExValUn, $oPerExQnt));

        $sTituloC->addCampos(array($oPlan, $oTipOrd), array($oDcomp, $oDprod, $oDqntd, $oDforn), $oB, array($oTipEstMin, $oPerEstMin, $oQntLotMin, $oQntLotMul), $oB, array($oDiasAgrup, $oQntLotPro, $oAcaoMrp, $oFilialPro));

        $sTituloD->addCampos(array($oCod, $oDes));

        $sTituloE->addCampos($oRefSer);

        $sTituloF->addCampos(array($oEspPad, $oEspCap));

        $oAbaGeral->addCampos(array($oProduto, $oProdutoDes), $oFantasia, $oL, $sTituloA, array($oGrupo, $oSubGrupo, $oFamilia, $oSubFamilia), $oB, array($oTipoGrupo, $oDataBloqueio, $oMotivoBloqueio), $oB, array($oItemMovEst, $oPermEstNeg, $oEstMin, $oDiasEstMin, $oPontRepos, $oEstMax, $oDiasEstMax), $oB, array($oDataUltInvRot, $oProdutoComp, $oTipoContFat, $oResEstEstPedid, $oQntMultPad, $oProdututividade, $oProContVeiculo), $oB, $sTituloB, $oB, $sTituloC, $oB, $sTituloD, $oB, $sTituloE, $oB, $sTituloF);


        $oQntProdRatCoProd = new Campo('Cons.Qtde Prod.p/Rateio Co-Produto', 'pro_filialconsqtdeprodcoprodut', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCustoCoProd = new Campo('Capacidade', 'pro_filialpercustocoproduto', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oAbaFecEst->addCampos($oQntProdRatCoProd, $oB, $oCustoCoProd);


        $oTab->addItems($oAbaGeral, $oAbaAlmox, $oAbaDespe, $oAbaForne, $oAbaClien, $oAbaEstGrad, $oAbaFecEst, $oAbaBloqMod);

        $this->addCampos($oTab);
    }

    public function criaModalFilial($sProCod) {
        parent::criaModal($sProCod);

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        $sProCod = rtrim($sProCod);

        $oProduto = new Campo('', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProduto->setSValor($sProCod);
        $oProduto->setBOculto(true);

        $this->setTituloTela("BLOQUEAR PRODUTO");
        $oData = new Campo('Data', 'data', Campo::TIPO_DATA, 3, 3, 3, 3);
        $oData->addValidacao(false, Validacao::TIPO_STRING);
        if (date('d/m/Y', strtotime($oDados->getPro_filialdtbloqueado())) == '31/12/1969') {
            $oData->setSValor(date('d/m/Y'));
        } else {
            $oData->setSValor(date('d/m/Y', strtotime($oDados->getPro_filialdtbloqueado())));
        }
        $oMotivo = new Campo('Motivo Bloqueio', 'motivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING);
        $oMotivo->setSValor($oDados->getPro_filialmotivobloqueio());

        $oBloquear = new Campo('Bloquear', 'btn1', Campo::TIPO_BOTAOSMALL, 2, 2, 2, 2);
        $oBloquear->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ProdutoFilial","bloquearProd","' . $oProduto->getId() . ',' . $oData->getId() . ',' . $oMotivo->getId() . '");';
        $oBloquear->getOBotao()->addAcao($sAcao);

        $oDesbloquear = new Campo('Desbloquear', 'btn2', Campo::TIPO_BOTAOSMALL, 2, 2, 2, 2);
        $oDesbloquear->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $sAcao2 = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ProdutoFilial","desBloquearProd","' . $oProduto->getId() . ',' . $oData->getId() . ',' . $oMotivo->getId() . '");';
        $oDesbloquear->getOBotao()->addAcao($sAcao2);

        $sEspaço = new Campo('', 'esp', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $sEspaço->setBOculto(true);
        $sEspaço->setApenasTela(true);

        $sLinha = new Campo('', 'label', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);

        $this->addCampos($oData, $sLinha, $oMotivo, $sLinha, array($oBloquear, $sEspaço, $oDesbloquear, $oProduto));
    }

}
