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

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBGridResponsivo(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaDropdown(true);

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

        $oSitCli = new CampoConsulta('SitCliente', 'sitcliente', CampoConsulta::TIPO_TEXTO);
        $oSitCli->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Expirado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSitCli->setBComparacaoColuna(true);
        $oSitCli->setILargura(20);

        $oSitGeral = new CampoConsulta('SitGeral', 'sitgeralproj', CampoConsulta::TIPO_TEXTO);
        $oSitGeral->addComparacao('Cadastrado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_MARROM, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Lib.Cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Em execução', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Produzido', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Faturado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA);
        $oSitGeral->setBComparacaoColuna(true);
        $oSitGeral->setILargura(20);


        $oDrop1 = new Dropdown('Produto', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Cadastro de produto', 'QualNovoProjProd', 'TelaCadProd', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_FILE) . 'Detalhamento de projeto', 'QualNovoProjDet', 'TelaCadEtapa', '', true, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Controle e verificação de projeto', 'QualNovoProjVerif', 'TelaCadVerif', '', true, '');

        $oDrop2 = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO, Dropdown::ICON_POSITIVO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Liberar código', 'QualNovoProjProd', 'msgLibCod', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Listagem de processos', 'QualNovoProjProd', 'criaTelaModalSeqProc', '', false, '', false, 'criaTelaModalSeqProc', true, 'Listagem de processos');

        $oDrop3 = new Dropdown('E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Reenvia código', 'QualNovoProjProd', 'reenviaCodigo', '', false, '');

        $this->addDropdown($oDrop1, $oDrop2, $oDrop3);

        $oFSitProj = new Filtro($oSitGeral, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFSitProj->addItemSelect('Todos', 'Todos');
        $oFSitProj->addItemSelect('Em execução', 'Em execução');
        $oFSitProj->addItemSelect('Lib.Cadastro', 'Lib.Cadastro');
        $oFSitProj->addItemSelect('Lib.Projetos', 'Lib.Projetos');
        $oFSitProj->addItemSelect('Finalizado', 'Finalizado');
        $oFSitProj->addItemSelect('Aprovado', 'Aprovado');
        $oFSitProj->addItemSelect('Representante', 'Representante');
        $oFSitProj->setSLabel('');

        //TelaCadVerif

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);
        $oFiltroNr->setSLabel('Número');

        $oFiltroProd = new Filtro($oNovoProd, Filtro::CAMPO_TEXTO, 8, 8, 12, 12);
        $oFiltroProd->setSLabel('Descrição');
        $this->addFiltro($oFSitProj, $oFiltroNr, $oFiltroProd);

        //$aInicial[0] = 'sitgeralproj,Todos';
        //$this->getTela()->setAParametros($aInicial);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","QualNovoProjProd","renderTempo",chave+",qualnovoprojprodtempo");');

        $this->addCampos($oNr, $oData, $oSitCli, $oSitGeral, $oRespProj, $oRespVenda, $oNovoProd, $oObsCli);
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

        $oSitCliente = new Campo('Sit.Cliente', 'sitcliente', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitCliente->setBCampoBloqueado(true);

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

        $oAngHelice = new campo('Âng. Helice', 'anghelice', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oAcab = new Campo('Acab.', 'acab', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oMaterial = new campo('Material', 'material', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oDiamMat = new Campo('Bitola Mat.', 'metmat', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamMat->setSCorFundo(Campo::FUNDO_AMARELO);        
        $oDiamMat->setSValor('0');

        $oClasse = new campo('Classe', 'classe', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oChaveMin = new campo('Chave Mín.', 'chavemin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oChaveMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oChaveMin->setSValor('0');

        $oChaveMax = new campo('Chave Max.', 'chavemax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oChaveMax->setSValor('0');
        $oChaveMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oAltMin = new Campo('Alt. Mín', 'altmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oAltMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAltMin->setSValor('0');

        $oAltMax = new Campo('Alt. Máx', 'altmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oAltMax->setSValor('0');
        $oAltMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamFmin = new campo('Diâm. Furo Mín', 'diamfmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamFmin->setSValor('0');
        $oDiamFmin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamFmax = new campo('Diâm. Furo Máx', 'diamfmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamFmax->setSValor('0');
        $oDiamFmax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompMin = new campo('Comp. Mín', 'compmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompMin->setSValor('0');
        $oCompMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompMax = new campo('Comp .Máx', 'compmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompMax->setSValor('0');
        $oCompMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamPriMin = new Campo('Diâm. Prim. Mín', 'diampmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamPriMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamPriMin->setSValor('0');

        $oDiamPriMax = new Campo('Diâm. Prim. Máx', 'diampmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamPriMax->setSValor('0');
        $oDiamPriMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamExtMin = new campo('Diâm. Ext. Mín', 'diamexmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamExtMin->setSValor('0');
        $oDiamExtMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamExtMax = new campo('Diâm. Ext. Máx', 'diamexmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamExtMax->setSValor('0');
        $oDiamExtMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompRMin = new campo('Com. Rosc. Mín', 'comprmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompRMin->setSValor('0');
        $oCompRMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompRMax = new campo('Com. Rosc. Máx', 'comprmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompRMax->setSValor('0');
        $oCompRMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompHasteMin = new Campo('Com. Hast. Mín', 'comphmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompHasteMin->setSValor('0');
        $oCompHasteMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCompHasteMax = new Campo('Com. Hast. Máx', 'comphmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oCompHasteMax->setSValor('0');
        $oCompHasteMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamHasteMin = new campo('Diâm. Haste. Mín', 'diamhmin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamHasteMin->setSValor('0');
        $oDiamHasteMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDiamHasteMax = new campo('Diâm. Haste. Máx', 'diamhmax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oDiamHasteMax->setSValor('0');
        $oDiamHasteMax->setSCorFundo(Campo::FUNDO_AMARELO);

        $oProfCanecoMin = new Campo('Prof.Caneco Min.', 'profcanecomin', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oProfCanecoMin->setSValor('0');
        $oProfCanecoMin->setSCorFundo(Campo::FUNDO_AMARELO);

        $oProfCanecoMax = new Campo('Prof.Caneco Max.', 'profcanecomax', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oProfCanecoMax->setSValor('0');
        $oProfCanecoMax->setSCorFundo(Campo::FUNDO_AMARELO);



        //executa esta funcao ao sair dos campos
        $sAcaoExit = 'dimenNewProj($("#' . $oProcodSimilar->getId() . '").val(),'
                . '"' . $oChaveMin->getId() . '","' . $oChaveMax->getId() . '","' . $oAltMin->getId() . '","' . $oAltMax->getId() . '","' . $oDiamFmin->getId() . '",'
                . '"' . $oDiamFmax->getId() . '","' . $oCompMin->getId() . '","' . $oCompMax->getId() . '","' . $oDiamPriMin->getId() . '",' . '"' . $oDiamPriMax->getId() . '",'
                . '"' . $oDiamExtMin->getId() . '","' . $oDiamExtMax->getId() . '","' . $oCompRMin->getId() . '","' . $oCompRMax->getId() . '","' . $oCompHasteMin->getId() . '",'
                . '"' . $oCompHasteMax->getId() . '","' . $oDiamHasteMin->getId() . '","' . $oDiamHasteMax->getId() . '","' . $oProfCanecoMin->getId() . '","' . $oProfCanecoMax->getId() . '",'
                . '"' . $oAngHelice->getId() . '","' . $oAcab->getId() . '","' . $oMaterial->getId() . '","' . $oClasse->getId() . '","' . $this->getController() . '","' . $oDiamMat->getId() . '",'
                . '$("#' . $oProcod->getId() . '").val());';   //$oCompRMin
        $oProcodSimilar->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);


        $oFieldDimen->addCampos(
                array($oAcab, $oMaterial, $oDiamMat, $oClasse, $oAngHelice), array($oChaveMin, $oChaveMax, $oAltMin, $oAltMax), array($oDiamFmin, $oDiamFmax, $oCompMin, $oCompMax), array($oDiamPriMin, $oDiamPriMax, $oDiamExtMin, $oDiamExtMax), array($oCompHasteMin, $oCompHasteMax, $oCompRMin, $oCompRMax), array($oDiamHasteMin, $oDiamHasteMax, $oProfCanecoMin, $oProfCanecoMax));

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
        $oDadosEnt_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oDadosEnt_obs->setIMarginTop(22);

        $oReqLegal = new campo('Os requisitos legais aplicáveis foram levantados?', 'reqlegal', Campo::TIPO_SELECT, 4);
        $oReqLegal->addItemSelect('Na', 'Na');
        $oReqLegal->addItemSelect('Sim', 'Sim');
        $oReqLegal->addItemSelect('Não', 'Não');

        $oReqLegal_obs = new campo('', 'reqlegal_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqLegal_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oReqLegal_obs->setIMarginTop(22);

        $oReqadicional = new campo('Algum requisito adicional de clientes?', 'reqadicional', Campo::TIPO_SELECT, 4);
        $oReqadicional->addItemSelect('Na', 'Na');
        $oReqadicional->addItemSelect('Sim', 'Sim');
        $oReqadicional->addItemSelect('Não', 'Não');

        $oReqadicional_obs = new Campo('', 'reqadicional_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadicional_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oReqadicional_obs->setIMarginTop(22);

        $oReqadverif = new Campo('Algum requisito adicional de verificação?', 'reqadverif', Campo::TIPO_SELECT, 4);
        $oReqadverif->addItemSelect('Na', 'Na');
        $oReqadverif->addItemSelect('Sim', 'Sim');
        $oReqadverif->addItemSelect('Não', 'Não');

        $oReqadverif_obs = new Campo('', 'reqadverif_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadverif_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oReqadverif_obs->setIMarginTop(22);

        $oReqadval = new Campo('Algum requisito adicional de validação?', 'reqadval', Campo::TIPO_SELECT, 4);
        $oReqadval->addItemSelect('Na', 'Na');
        $oReqadval->addItemSelect('Sim', 'Sim');
        $oReqadval->addItemSelect('Não', 'Não');

        $oReqadval_obs = new Campo('', 'reqadval_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqadval_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oReqadval_obs->setIMarginTop(22);

        $oReqproblem = new Campo('Consideramos que o produto não terá problemas com dimensional e montabilidade?', 'reqproblem', Campo::TIPO_SELECT, 4);
        $oReqproblem->addItemSelect('Na', 'Na');
        $oReqproblem->addItemSelect('Sim', 'Sim');
        $oReqproblem->addItemSelect('Não', 'Não');

        $oReqproblem_obs = new Campo('', 'reqproblem_obs', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oReqproblem_obs->setSCorFundo(Campo::FUNDO_VERDE);
        $oReqproblem_obs->setIMarginTop(22);

        $oComen = new Campo('Comentários', 'comem', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);

        $oFieldAnaliseCri->addCampos(array($oLabel1, $oLabel3), array($oDadosEnt, $oDadosEnt_obs), array($oReqLegal, $oReqLegal_obs), array($oReqadicional, $oReqadicional_obs), array($oReqadverif, $oReqadverif_obs), array($oReqadval, $oReqadval_obs), array($oReqproblem, $oReqproblem_obs), $oComen);

        $this->addCampos(array($oFilcgc, $oNr, $oDtimp, $oResp_proj_nome, $oResp_venda_nome, $oSitgeralproj, $oSitCliente), $oObsCli, array($oProcod, $oDesc_novo_prod), array($oProcodSimilar, $oProdsimilar), $oFieldDimen, array($oTipRosca, $oNormaDimem), array($oNormaRosca, $oNormaMec), array($oPpap, $oVolVenda), $oReqCli, array($oRespProj, $oRespProjNome, $oDataProd), $oFieldAnaliseCri);
    }

    public function criaTelaModalSeqProc($sDados) {
        parent::criaModal();

        $this->setBTela(true);

        $oDados = $this->getAParametrosExtras();

        $oNr = new campo('Nrº', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new campo('', 'EmpRex_filcgc', Campo::TIPO_TEXTO, 1);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBOculto(true);

        $oEmpcod = new Campo('Cliente', 'empcod', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpcod->setSValor($oDados->empcod);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new campo('...', 'empdes', Campo::TIPO_TEXTO, 8, 8, 12, 12);
        $oEmpdes->setSValor($oDados->empdes);
        $oEmpdes->setBCampoBloqueado(true);

        $oProcod = new Campo('Cód.', 'procod', Campo::TIPO_TEXTO, 1);
        $oProcod->setSValor($oDados->procod);
        $oProcod->setBCampoBloqueado(true);

        $oProduto = new campo('Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 11);
        $oProduto->setSValor($oDados->desc_novo_prod);
        $oProduto->setBCampoBloqueado(true);

        $oProcessos = new Campo('Conf. a frio', '1', Campo::TIPO_CHECK, 3);
        $oProcessos1 = new Campo('Conf. a quente', '2', Campo::TIPO_CHECK, 3);
        $oProcessos2 = new Campo('Corte barra - PF frio', '3', Campo::TIPO_CHECK, 3);
        $oProcessos3 = new Campo('Corte barra - PF quente', '4', Campo::TIPO_CHECK, 3);
        $oProcessos4 = new Campo('Revenimento', '5', Campo::TIPO_CHECK, 3);
        $oProcessos5 = new Campo('CNC', '6', Campo::TIPO_CHECK, 3);
        $oProcessos6 = new Campo('CNC - Terceiros', '7', Campo::TIPO_CHECK, 3);
        $oProcessos7 = new Campo('Rosqueamento', '8', Campo::TIPO_CHECK, 3);
        $oProcessos8 = new Campo('Laminação', '9', Campo::TIPO_CHECK, 3);
        $oProcessos9 = new Campo('Processos especiais', '10', Campo::TIPO_CHECK, 3);
        $oProcessos10 = new Campo('Tr. térmico', '11', Campo::TIPO_CHECK, 3);
        $oProcessos11 = new Campo('Tr. térmico - Terceiros', '12', Campo::TIPO_CHECK, 3);
        $oProcessos12 = new Campo('Óleo rustilo', '13', Campo::TIPO_CHECK, 3);
        $oProcessos13 = new Campo('Granalha', '14', Campo::TIPO_CHECK, 3);
        $oProcessos14 = new Campo('Galvanização', '15', Campo::TIPO_CHECK, 3);
        $oProcessos15 = new Campo('Zincagem', '16', Campo::TIPO_CHECK, 3);
        $oProcessos16 = new Campo('Zincagem - Terceiros', '17', Campo::TIPO_CHECK, 3);
        $oProcessos17 = new Campo('Embalagem', '18', Campo::TIPO_CHECK, 3);


        $oBtnInserir = new Campo('EMITIR', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","QualNovoProjProd","geraEtapaProcesso","' . $this->getTela()->getId() . '-form","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(
                array($oNr, $oEmpcod, $oEmpdes), array($oProcod, $oProduto), array($oProcessos, $oProcessos2, $oProcessos5, $oProcessos4), array($oProcessos1, $oProcessos3, $oProcessos6, $oProcessos7), array($oProcessos10, $oProcessos8, $oProcessos9, $oProcessos12), array($oProcessos11, $oProcessos15, $oProcessos13), array($oProcessos17, $oProcessos16, $oProcessos14), array($oBtnInserir, $oFilcgc));
    }

}
