<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualNovoProjProd extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        /**
         *  private $resp_venda_cod;
          private $resp_venda_nome;
         */
        $this->setBScrollInf(true);
        $this->getTela()->setILarguraGrid(1500);
        $this->getTela()->setBGridResponsivo(false);

        $oData = new CampoConsulta('Data', 'dtimp', CampoConsulta::TIPO_DATA);
        $oData->setILargura(60);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNr->setILargura(10);
        $oNr->setSOperacao('personalizado');

        $oRespProj = new CampoConsulta('RespProj', 'resp_proj_nome');
        $oRespProj->setILargura(60);

        $oRespVenda = new CampoConsulta('RespVenda', 'resp_venda_nome');
        $oRespVenda->setILargura(100);

        $oNovoProd = new CampoConsulta('DescProd', 'desc_novo_prod');
        $oNovoProd->setILargura(1000);

        $oObsCli = new CampoConsulta('ObsCliente', 'obsaprovcli');
        $oObsCli->setILargura(200);

        $oSitGeral = new CampoConsulta('Sit.Geral', 'sitgeralproj');
        $oSitGeral->addComparacao('Lib.Cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->setBComparacaoColuna(true);
        $oSitGeral->setILargura(20);

        $this->addCampos($oNr, $oData, $oRespProj, $oRespVenda, $oNovoProd, $oObsCli, $oSitGeral);

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Produto', Dropdown::TIPO_PRIMARY);

        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Cadastro de produto', 'QualNovoProjProd', 'TelaCadProd', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_FILE) . 'Detalhamento de projeto', 'QualNovoProjDet', 'TelaCadEtapa', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Controle e verificação de projeto', 'QualNovoProjVerif', 'TelaCadVerif', '', true, '');

        $oDrop2 = new Dropdown('Finalizar', Dropdown::TIPO_SUCESSO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Finalizar projeto', 'QualNovoProjProd', 'msgFinalizar', '', false, '');

        $this->addDropdown($oDrop1, $oDrop2);

        $oFSitProj = new Filtro($oSitGeral, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFSitProj->addItemSelect('Todos', 'Todos');
        $oFSitProj->addItemSelect('Lib.Cadastro', 'Lib.Cadastro');
        $oFSitProj->addItemSelect('Finalizado', 'Finalizado');
        $oFSitProj->addItemSelect('Aprovado', 'Aprovado');
        $oFSitProj->addItemSelect('Representante', 'Representante');
        $oFSitProj->setSLabel('');
        //TelaCadVerif

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);
        $oFiltroNr->setSLabel('Número');

        $oFiltroProd = new Filtro($oNovoProd, Filtro::CAMPO_TEXTO, 8, 8, 12, 12);
        $oFiltroProd->setSLabel('Descrição');
        $this->addFiltro($oFiltroNr, $oFiltroProd, $oFSitProj);

        //$aInicial[0] = 'sitgeralproj,Todos';
        //$this->getTela()->setAParametros($aInicial);




        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","QualNovoProjProd","renderTempo",chave+",qualnovoprojprodtempo");');
    }

    public function criaTelaProd() {
        parent::criaTela();

        $oFilcgc = new Campo('Empresa', 'EmpRex.filcgc', Campo::TIPO_TEXTO, 2);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oDtimp = new Campo('Implantaçao', 'dtimp', Campo::TIPO_TEXTO, 1);
        $oDtimp->setBCampoBloqueado(true);

        $oResp_proj_nome = new Campo('Resp.Proj', 'resp_proj_nome', Campo::TIPO_TEXTO, 2);
        $oResp_proj_nome->setBCampoBloqueado(true);

        $oResp_venda_nome = new Campo('Resp.Venda', 'resp_venda_nome', Campo::TIPO_TEXTO, 2);
        $oResp_venda_nome->setBCampoBloqueado(true);

        $oSitgeralproj = new campo('Situaçao', 'sitgeralproj', Campo::TIPO_TEXTO, 1);
        $oSitgeralproj->setBCampoBloqueado(true);

        $oObsCli = new campo('Observação do cliente', 'obsaprovcli', Campo::TIPO_TEXTAREA, 9, 9, 12, 12);
        $oObsCli->setBCampoBloqueado(true);

        $oProcod = new campo('Código', 'procod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDesc_novo_prod = new campo('Novo Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 7, 7, 12, 12);

        $oProcodSimilar = new campo('Código similar', 'procodsimilar', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oProdsimilar = new campo('Produto similar', 'prodsimilar', Campo::TIPO_BUSCADOBANCO, 7, 7, 12, 12);
        $oProdsimilar->setSIdPk($oProcodSimilar->getId());
        $oProdsimilar->setClasseBusca('Produto');
        $oProdsimilar->addCampoBusca('procod', '', '');
        $oProdsimilar->addCampoBusca('prodes', '', '');
        $oProcodSimilar->setSIdTela($this->getTela()->getid());

        $oProcodSimilar->setClasseBusca('Produto');
        $oProcodSimilar->setSCampoRetorno('procod', $this->getTela()->getid());
        $oProcodSimilar->addCampoBusca('prodes', $oProdsimilar->getId(), $this->getTela()->getid());

        $oFieldDimen = new FieldSet('Especificações dimensionais');
        $oFieldDimen->setOculto(true);

        $oChaveMin = new campo('Chave Mín.', 'chavemin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oChaveMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oChaveMin->setSValor('0');
        $oChaveMax = new campo('Chave Max.', 'chavemax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oChaveMax->setSValor('0');
        $oChaveMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oAltMin = new Campo('Alt. Mín', 'altmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAltMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAltMin->setSValor('0');
        $oAltMax = new Campo('Alt. Máx', 'altmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAltMax->setSValor('0');
        $oAltMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamFmin = new campo('Diâm. Furo Mín', 'diamfmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamFmin->setSValor('0');
        $oDiamFmin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamFmax = new campo('Diâm. Furo Máx', 'diamfmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamFmax->setSValor('0');
        $oDiamFmax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompMin = new campo('Comp. Mín', 'compmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompMin->setSValor('0');
        $oCompMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCompMax = new campo('Comp .Máx', 'compmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompMax->setSValor('0');
        $oCompMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamPriMin = new Campo('Diâm. Prim. Mín', 'diampmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamPriMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamPriMin->setSValor('0');
        $oDiamPriMax = new Campo('Diâm. Prim. Máx', 'diampmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamPriMax->setSValor('0');
        $oDiamPriMax->setSCorFundo(Campo::FUNDO_AMARELO);


        $oDiamExtMin = new campo('Diâm. Ext. Mín', 'diamexmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamExtMin->setSValor('0');
        $oDiamExtMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamExtMax = new campo('Diâm. Ext. Máx', 'diamexmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamExtMax->setSValor('0');
        $oDiamExtMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompRMin = new campo('Com. Rosc. Mín', 'comprmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompRMin->setSValor('0');
        $oCompRMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCompRMax = new campo('Com. Rosc. Máx', 'comprmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompRMax->setSValor('0');
        $oCompRMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompHasteMin = new Campo('Com. Hast. Mín', 'comphmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompHasteMin->setSValor('0');
        $oCompHasteMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCompHasteMax = new Campo('Com. Hast. Máx', 'comphmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCompHasteMax->setSValor('0');
        $oCompHasteMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamHasteMin = new campo('Diâm. Haste. Mín', 'diamhmin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamHasteMin->setSValor('0');
        $oDiamHasteMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamHasteMax = new campo('Diâm. Haste. Máx', 'diamhmax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiamHasteMax->setSValor('0');
        $oDiamHasteMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oAngHelice = new campo('Âng. Helice', 'anghelice', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oAcab = new Campo('Acab.', 'acab', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMaterial = new campo('Material', 'material', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oClasse = new campo('Classe', 'classe', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        //executa esta funcao ao sair dos campos
        $sAcaoExit = 'dimenNewProj("' . $oChaveMin->getId() . '","' . $oChaveMax->getId() . '","' . $oAltMin->getId() . '","' . $oAltMax->getId() . '",'
                . '"' . $oDiamFmin->getId() . '","' . $oDiamFmax->getId() . '","' . $oCompMin->getId() . '",'
                . '"' . $oCompMax->getId() . '","' . $oDiamPriMin->getId() . '",'
                . '"' . $oDiamPriMax->getId() . '","' . $oDiamExtMin->getId() . '",'
                . '"' . $oDiamExtMax->getId() . '","' . $oCompRMin->getId() . '",'
                . '"' . $oCompRMax->getId() . '","' . $oCompHasteMin->getId() . '",'
                . '"' . $oCompHasteMax->getId() . '","' . $oDiamHasteMin->getId() . '",'
                . '"' . $oDiamHasteMax->getId() . '","' . $oAngHelice->getId() . '","' . $oAcab->getId() . '");';   //$oCompRMin
        $oChaveMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oChaveMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oAltMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oAltMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamFmin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamFmax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamPriMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamPriMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamExtMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamExtMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompRMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompRMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompHasteMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCompHasteMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamHasteMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oDiamHasteMax->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oAngHelice->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oProcod->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oProcod->setBFocus(true);




        $oFieldDimen->addCampos(array($oChaveMin, $oChaveMax, $oAltMin, $oAltMax), array($oDiamFmin, $oDiamFmax, $oCompMin, $oCompMax), array($oDiamPriMin, $oDiamPriMax, $oDiamExtMin, $oDiamExtMax), array($oCompRMin, $oCompRMax, $oCompHasteMin, $oCompHasteMax), array($oDiamHasteMin, $oDiamHasteMax, $oAngHelice, $oAcab, $oMaterial, $oClasse));

        /* private $tiprosca;
          private $normadimen;
          private $normarosca;
          private $normapropmec; */

        $oTipRosca = new campo('Tipo de rosca', 'tiprosca', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oNormaDimem = new campo('Norma Dimensional', 'normadimen', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oNormaRosca = new campo('Norma Rosca', 'normarosca', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oNormaMec = new campo('Norma Prop.Mecânica', 'normapropmec', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oPpap = new campo('Requer PPAP?', 'ppap', Campo::TIPO_SELECT, 1);
        $oPpap->addItemSelect('Sim', 'Sim');
        $oPpap->addItemSelect('Não', 'Não');

        $oVolVenda = new Campo('Volume de venda previsto', 'vendaprev', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oVolVenda->setIMarginTop(7);

        $oReqCli = new Campo('Requisito adicional solicitado pelo cliente', 'reqcli', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);

        $oRespProj = new campo('...', 'codresproj', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 112, 112);


        $oRespProjNome = new Campo('Resp. Projetos', 'respproj', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespProjNome->setSIdPk($oRespProj->getId());
        $oRespProjNome->setClasseBusca('User');
        $oRespProjNome->addCampoBusca('usucodigo', '', '');
        $oRespProjNome->addCampoBusca('usunome', '', '');
        $oRespProjNome->setSIdTela($this->getTela()->getid());


        $oRespProj->setClasseBusca('User');
        $oRespProj->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespProj->addCampoBusca('usunome', $oRespProjNome->getId(), $this->getTela()->getId());

        $oDataProd = new Campo('Data cadastro', 'dataprod', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oFieldAnaliseCri = new FieldSet('Análise crítica de entrada');
        $oFieldAnaliseCri->setOculto(true);


        $oLabel1 = new Campo('Requisitos análisados', 'label1', Campo::TIPO_LABEL, 4, 4, 12, 12);

        $oLabel3 = new campo('Observação', 'label3', Campo::TIPO_LABEL, 4, 4, 12, 12);

        $oDadosEnt = new campo('Os dados de entrada são adequados e suficientes?', 'dadosent', Campo::TIPO_SELECT, 4);
        $oDadosEnt->addItemSelect('Na', 'Na');
        $oDadosEnt->addItemSelect('Sim', 'Sim');
        $oDadosEnt->addItemSelect('Não', 'Não');

        $oDadosEnt_obs = new campo('', 'dadosent_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oDadosEnt_obs->setIMarginTop(35);
        $oDadosEnt_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oReqLegal = new campo('Os requisitos legais aplicáveis foram levantados?', 'reqlegal', Campo::TIPO_SELECT, 4);
        $oReqLegal->addItemSelect('Na', 'Na');
        $oReqLegal->addItemSelect('Sim', 'Sim');
        $oReqLegal->addItemSelect('Não', 'Não');

        $oReqLegal_obs = new campo('', 'reqlegal_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqLegal_obs->setIMarginTop(35);
        $oReqLegal_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oReqadicional = new campo('Algum requisito adicional de clientes?', 'reqadicional', Campo::TIPO_SELECT, 4);
        $oReqadicional->addItemSelect('Na', 'Na');
        $oReqadicional->addItemSelect('Sim', 'Sim');
        $oReqadicional->addItemSelect('Não', 'Não');

        $oReqadicional_obs = new Campo('', 'reqadicional_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadicional_obs->setIMarginTop(35);
        $oReqadicional_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oReqadverif = new Campo('Algum requisito adicional de verificação?', 'reqadverif', Campo::TIPO_SELECT, 4);
        $oReqadverif->addItemSelect('Na', 'Na');
        $oReqadverif->addItemSelect('Sim', 'Sim');
        $oReqadverif->addItemSelect('Não', 'Não');

        $oReqadverif_obs = new Campo('', 'reqadverif_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadverif_obs->setIMarginTop(35);
        $oReqadverif_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oReqadval = new Campo('Algum requisito adicional de validação?', 'reqadval', Campo::TIPO_SELECT, 4);
        $oReqadval->addItemSelect('Na', 'Na');
        $oReqadval->addItemSelect('Sim', 'Sim');
        $oReqadval->addItemSelect('Não', 'Não');

        $oReqadval_obs = new Campo('', 'reqadval_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadval_obs->setIMarginTop(35);
        $oReqadval_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oReqproblem = new Campo('Consideramos que o produto não terá problemas com dimensional e montabilidade?', 'reqproblem', Campo::TIPO_SELECT, 4);
        $oReqproblem->addItemSelect('Na', 'Na');
        $oReqproblem->addItemSelect('Sim', 'Sim');
        $oReqproblem->addItemSelect('Não', 'Não');

        $oReqproblem_obs = new Campo('', 'reqproblem_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqproblem_obs->setIMarginTop(58);
        $oReqproblem_obs->setSCorFundo(Campo::FUNDO_VERDE);

        $oComen = new Campo('Comentários', 'comem', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);


        $oFieldAnaliseCri->addCampos(array($oLabel1, $oLabel3), array($oDadosEnt, $oDadosEnt_obs), array($oReqLegal, $oReqLegal_obs), array($oReqadicional, $oReqadicional_obs), array($oReqadverif, $oReqadverif_obs), array($oReqadval, $oReqadval_obs), array($oReqproblem, $oReqproblem_obs), $oComen);

        $this->addCampos(array($oFilcgc, $oNr, $oDtimp, $oResp_proj_nome, $oResp_venda_nome, $oSitgeralproj), $oObsCli, array($oProcod, $oDesc_novo_prod), array($oProcodSimilar, $oProdsimilar), $oFieldDimen, array($oTipRosca, $oNormaDimem), array($oNormaRosca, $oNormaMec), array($oPpap, $oVolVenda), $oReqCli, array($oRespProj, $oRespProjNome, $oDataProd), $oFieldAnaliseCri);
    }

}