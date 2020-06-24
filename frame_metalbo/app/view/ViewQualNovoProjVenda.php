<?php

/*
 * Implementa a view da classe QualNovoProjVenda
 * 
 * @author Avanei Martendal
 * @since 09/08/2017
 */

class ViewQualNovoProjVenda extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $this->getTela()->setBGridResponsivo(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaDropdown(true);

        $oData = new CampoConsulta('Data', 'dtimp', CampoConsulta::TIPO_DATA);
        $oData->setILargura(15);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNr->setILargura(1);

        $oEmpDes = new CampoConsulta('Cliente', 'Pessoa.empdes');
        $oEmpDes->setILargura(300);

        $oRepNome = new CampoConsulta('Rep.', 'repnome');
        $oRepNome->setILargura(100);

        $oQuantPc = new CampoConsulta('Quant.Cnt/Mês', 'quant_pc', CampoConsulta::TIPO_DECIMAL);
        $oQuantPc->setILargura(30);

        $oDescProdNew = new CampoConsulta('Novo produto', 'desc_novo_prod');
        $oDescProdNew->setILargura(1000);

        $oSitProj = new CampoConsulta('SitProjetos', 'sitproj', CampoConsulta::TIPO_TEXTO);
        $oSitProj->addComparacao('Cód. enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSitProj->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSitProj->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitProj->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSitProj->setBComparacaoColuna(true);
        $oSitProj->setILargura(11);

        $oSitVendas = new CampoConsulta('SitVendas', 'sitvendas', CampoConsulta::TIPO_TEXTO);
        $oSitVendas->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitVendas->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitVendas->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSitVendas->setBComparacaoColuna(true);
        $oSitVendas->setILargura(11);

        $oSitCli = new CampoConsulta('SitCliente', 'sitcliente', CampoConsulta::TIPO_TEXTO);
        $oSitCli->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitCli->addComparacao('Enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSitCli->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSitCli->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitCli->addComparacao('Expirado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_COLUNA, false, null);
        $oSitCli->setBComparacaoColuna(true);
        $oSitCli->setILargura(11);

        $oSitGeral = new CampoConsulta('SitGeral', 'sitgeralproj', CampoConsulta::TIPO_TEXTO);
        $oSitGeral->addComparacao('Cadastrado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_MARROM, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Lib.Cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Em execução', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Produzido', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->addComparacao('Faturado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, false, null);
        $oSitGeral->setBComparacaoColuna(true);
        $oSitGeral->setILargura(11);

        $oOfficeDes = new CampoConsulta('Escritório', 'officedes');

        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aprovar projeto (Liberar representante)', 'QualNovoProjVenda', 'msgAprov', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Reprova projetos', 'QualNovoProjVenda', 'msgReprovaProjVenda', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Retorna para projetos', 'QualNovoProjVenda', 'msgRetProj', '', false, '', false, '', false, '', false, false);

        $oDrop2 = new Dropdown('E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Reenviar e-mail aprovação', 'QualNovoProjVenda', 'reenviaAprovaVenda', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Reenviar e-mail reprovação', 'QualNovoProjVenda', 'reenviaReprovaVenda', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_RECARREGAR) . 'Reennvia retorno para Projetos', 'QualNovoProjVenda', 'reenviaRetornoProj', '', false, '', false, '', false, '', false, false);

        $this->addDropdown($oDrop1, $oDrop2);

        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);

        $oFilDescProdNew = new Filtro($oDescProdNew, Filtro::CAMPO_TEXTO, 8, 8, 12, 12, false);

        $oFSitVendas = new Filtro($oSitVendas, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFSitVendas->addItemSelect('Todos', 'Todos');
        $oFSitVendas->addItemSelect('Lib.Projetos', 'Lib.Projetos');
        $oFSitVendas->addItemSelect('Aprovado', 'Aprovado');
        $oFSitVendas->addItemSelect('Reprovado', 'Reprovado');
        $oFSitVendas->setSLabel('');

        $oFilEmpDes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $this->addFiltro($oFSitVendas, $oFilNr, $oFilData, $oFilEmpDes, $oFilDescProdNew);

        $this->addCampos($oNr, $oSitProj, $oSitVendas, $oSitCli, $oSitGeral, $oData, $oEmpDes, $oRepNome, $oDescProdNew, $oQuantPc);


        /* $aInicial[0] = 'sitvendas,Aguardando';
          $this->getTela()->setAParametros($aInicial);
         * 
         */
    }

    public function criaTela() {
        parent::criaTela();

        //field de informações
        $oFieldInf = new FieldSet('Informações');

        $oFilcgc = new Campo('Empresa', 'EmpRex.filcgc', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 2, 2);
        $oFilcgc->setSValor('75483040000211');

        $oFilDes = new campo('Empresa', 'EmpRex.fildes', Campo::TIPO_BUSCADOBANCO, 3, 3, 3, 3);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('EmpRex');
        $oFilDes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oFilDes->addCampoBusca('filcgc', '', '');
        $oFilDes->addCampoBusca('fildes', '', '');
        $oFilDes->setSIdTela($this->getTela()->getid());
        $oFilDes->setSValor('REX MÁQUINAS E EQUIPAMENTOS LTDA');

        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('fildes', $oFilDes->getId(), $this->getTela()->getId());

        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oDataImp = new campo('Implantação', 'dtimp', Campo::TIPO_TEXTO, 1, 2, 2, 2);
        $oDataImp->setSValor(date('d/m/Y'));
        $oDataImp->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horaimp', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oSit = new campo('Sit.Projetos', 'sitproj', Campo::TIPO_TEXTO, 1);
        $oSit->setSValor('Lib.Projetos');
        $oSit->setBCampoBloqueado(true);

        $oSitGeral = new campo('Sit.Geral', 'sitgeralproj', Campo::TIPO_TEXTO, 1);
        $oSitGeral->setBCampoBloqueado(true);
        $oSitGeral->setSValor('Lib.Projetos');

        $oSitVenda = new campo('Sit.Vendas', 'sitvendas', Campo::TIPO_TEXTO, 1);
        $oSitVenda->setSValor('Aguardando');
        $oSitVenda->setBCampoBloqueado(true);

        $oRespProj = new campo('...', 'resp_proj_cod', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oRespProj->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespProj->setBFocus(true);
        $oRespProj->setBCampoBloqueado(true);

        $oRespProjNome = new Campo('Resp. Projetos', 'resp_proj_nome', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        $oRespProjNome->setBCampoBloqueado(true);

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oRespVenda->setBCampoBloqueado(true);

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        $oRespVendaNome->setBCampoBloqueado(true);


        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_TEXTO, 2);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new Campo('Cliente', 'Pessoa.empdes', Campo::TIPO_TEXTO, 4);
        $oEmpdes->setBCampoBloqueado(true);
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmail = new Campo('Email', 'emailCli', Campo::TIPO_TEXTO, 3);
        $oEmail->setBCampoBloqueado(true);

        $oDescProd = new campo('Descrição do produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 6);
        $oDescProd->setIMarginTop(8);
        $oDescProd->setBCampoBloqueado(true);

        $oAcaba = new Campo('Acabamento do Produto', 'acabamento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAcaba->setSCorFundo(Campo::FUNDO_VERDE);
        $oAcaba->setBCampoBloqueado(true);
        $oAcaba->setIMarginTop(8);

        $sBuscaCli = 'var empcod = $("#' . $oEmpcod->getId() . '").val();  '
                . ' if($("#' . $oEmpcod->getId() . '").val()!==""){requestAjax("","QualNovoProj","acaoExitEmp",""+empcod+",' . $oEmail->getId() . '");}';

        $oEmpcod->addEvento(Campo::EVENTO_SAIR, $sBuscaCli);

        $oRepLibObs = new Campo('Observação Representante', 'replibobs', Campo::TIPO_TEXTAREA, 8);
        $oRepLibObs->setBCampoBloqueado(true);
        $oRepLibObs->setILinhasTextArea(5);

        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 1);
        $oQuant->setSValor('0');
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setIMarginTop(8);
        $oQuant->setBCampoBloqueado(true);

        $oAnexoDesenho = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 2);

        $oAnexoDoc = new campo('Anexo 2', 'anexo2', Campo::TIPO_UPLOAD, 2);

        $oAnexoFree = new campo('Anexo 3', 'anexo3', Campo::TIPO_UPLOAD, 2);

        $oFieldAnexo = new FieldSet('Anexos');
        $oFieldAnexo->addCampos(array($oAnexoDesenho, $oAnexoDoc, $oAnexoFree));
        $oFieldAnexo->setOculto(true);

        $oEquipamento = new Campo('Temos equipamento correspondente', 'equip_corresp', Campo::TIPO_TEXTO, 3);
        $oEquipamento->setBCampoBloqueado(true);

        $oEquipEvidencia = new campo('Evidência', 'equip_corresp_evid', Campo::TIPO_TEXTO, 5);
        $oEquipEvidencia->setBCampoBloqueado(true);

        $oMatPrima = new Campo('Temos matéria prima correspondente', 'mat_prima', Campo::TIPO_TEXTO, 3);
        $oMatPrima->setBCampoBloqueado(true);

        $oEquipMatPrima = new campo('Evidência', 'mat_prima_evid', Campo::TIPO_TEXTO, 5);
        $oEquipMatPrima->setBCampoBloqueado(true);

        //estudo_proc
        $oEstudoProc = new Campo('Requer estudo de processo', 'estudo_proc', Campo::TIPO_TEXTO, 3);
        $oEstudoProc->setBCampoBloqueado(true);

        $oEstudoEvid = new Campo('Evidência', 'estudo_proc_evid', Campo::TIPO_TEXTO, 5);
        $oEstudoEvid->setBCampoBloqueado(true);

        //prod_sim
        $oProdSimilar = new Campo('Existe produto similar?', 'prod_sim', Campo::TIPO_TEXTO, 3);
        $oProdSimilar->setBCampoBloqueado(true);

        //prod_sim_evid
        $oProdSimilarEvid = new Campo('Evidência', 'prod_sim_evid', Campo::TIPO_TEXTO, 5);
        $oProdSimilarEvid->setBCampoBloqueado(true);

        //desen_ferram
        $oDesenFerram = new Campo('Precisa desenvolver ferramental?', 'desen_ferram', Campo::TIPO_TEXTO, 3);
        $oDesenFerram->setBCampoBloqueado(true);

        //desen_ferram_evid
        $oDesenFerramEvid = new Campo('Evidência', 'desen_ferram_evid', Campo::TIPO_TEXTO, 5);
        $oDesenFerramEvid->setBCampoBloqueado(true);

        $oObs_viavel = new Campo('Observação', 'sol_viavel_obs', Campo::TIPO_TEXTAREA, 8);
        $oObs_viavel->setBCampoBloqueado(true);

        $oViavel = new Campo('É viável operacionalmente?', 'sol_viavel', Campo::TIPO_TEXTO, 2);
        $oViavel->setBCampoBloqueado(true);

        $oUsuAprovaOperacional = new Campo('Aprova operacional', 'usuaprovaoperacional', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuAprovaOperacional->setBCampoBloqueado(true);
        if ($_SESSION['codsetor'] == 9) {
            $oUsuAprovaOperacional->setSValor($_SESSION['nome']);
        }

        $oDataAprovaOperacional = new Campo('Data aprova', 'dtaprovaoperacional', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataAprovaOperacional->setBCampoBloqueado(true);
        if ($_SESSION['codsetor'] == 9) {
            $oDataAprovaOperacional->setSValor(date('d/m/Y'));
        }

        $oFieldOperacao = new FieldSet('Análise operacional da solicitação');
        $oFieldOperacao->setOculto(true);
        $oFieldOperacao->addCampos(array($oEquipamento, $oEquipEvidencia), array($oMatPrima, $oEquipMatPrima), array($oEstudoProc, $oEstudoEvid), array($oProdSimilar, $oProdSimilarEvid), array($oDesenFerram, $oDesenFerramEvid), $oViavel, array($oUsuAprovaOperacional, $oDataAprovaOperacional), $oObs_viavel);

        $oLabel1 = new Campo('Requisitos analisados', 'label1', Campo::TIPO_BADGE, 3);
        $oLabel1->setSEstiloBadge(Campo::BADGE_PRIMARY);
        $oLabel1->setITamMarginTopBadge(22);
        $oLabel1->setITamFonteBadge(18);
        $oLabel1->setApenasTela(true);

        $oLabel2 = new Campo('Valores', 'label2', Campo::TIPO_BADGE, 3);
        $oLabel2->setSEstiloBadge(Campo::BADGE_SUCCESS);
        $oLabel2->setITamMarginTopBadge(22);
        $oLabel2->setITamFonteBadge(18);
        $oLabel2->setApenasTela(true);

        $oLabel3 = new campo('Planejamento e desenvolvimento do projeto', 'label3', Campo::TIPO_LABEL, 3);
        $oVlrDesenProj = new Campo('', 'vlrDesenProj', Campo::TIPO_TEXTO, 1);
        $oVlrDesenProj->setIMarginTop(2);
        $oVlrDesenProj->setSValor('0');
        $oVlrDesenProj->setBCampoBloqueado(true);

        $oLabel4 = new campo('Ferramental', 'label4', Campo::TIPO_LABEL, 3);
        $oVlrFerra = new campo('', 'vlrFerramen', Campo::TIPO_TEXTO, 1);
        $oVlrFerra->setIMarginTop(2);
        $oVlrFerra->setSValor('0');
        $oVlrFerra->setBCampoBloqueado(true);

        $oLabel5 = new campo('Matéria Prima', 'label5', Campo::TIPO_LABEL, 3);
        $ovlrMatPrima = new campo('', 'vlrMatPrima', Campo::TIPO_TEXTO, 1);
        $ovlrMatPrima->setIMarginTop(2);
        $ovlrMatPrima->setSValor('0');
        $ovlrMatPrima->setBCampoBloqueado(true);

        $oLabel6 = new campo('Acabamento Superfícial', 'label6', Campo::TIPO_LABEL, 3);
        $ovlrAcabSuper = new campo('', 'vlrAcabSuper', Campo::TIPO_TEXTO, 1);
        $ovlrAcabSuper->setIMarginTop(2);
        $ovlrAcabSuper->setSValor('0');
        $ovlrAcabSuper->setBCampoBloqueado(true);

        $oLabel7 = new campo('Tratamento térmico', 'label7', Campo::TIPO_LABEL, 3);
        $ovlrTratTer = new campo('', 'vlrTratTer', Campo::TIPO_TEXTO, 1);
        $ovlrTratTer->setIMarginTop(2);
        $ovlrTratTer->setSValor('0');
        $ovlrTratTer->setBCampoBloqueado(true);

        $oLabel8 = new campo('Custo de produção', 'label8', Campo::TIPO_LABEL, 3);
        $ovlrCustProd = new campo('', 'vlrCustProd', Campo::TIPO_TEXTO, 1);
        $ovlrCustProd->setSValor(0);
        $ovlrCustProd->setIMarginTop(2);
        $ovlrCustProd->setBCampoBloqueado(true);

        $oLabel9 = new campo('Estimativa de custo total', 'label9', Campo::TIPO_LABEL, 3);
        $oCustTotal = new Campo('', 'custtot', Campo::TIPO_TEXTO, 1);
        $oCustTotal->setSValor('0');
        $oCustTotal->setApenasTela(true);
        $oCustTotal->setIMarginTop(3);
        $oCustTotal->setSCorFundo(Campo::FUNDO_VERDE);
        $oCustTotal->setBCampoBloqueado(true);

        $oLabel20 = new Campo('Custo por cento', 'label20', Campo::TIPO_LABEL, 3);
        $oCustoCento = new Campo('', 'custocento', Campo::TIPO_TEXTO, 1);
        $oCustoCento->setSValor('0');
        $oCustoCento->setApenasTela(true);
        $oCustoCento->setIMarginTop(3);
        $oCustoCento->setSCorFundo(Campo::FUNDO_VERDE);
        $oCustoCento->setBCampoBloqueado(true);

        $oLinha2 = new Campo('', 'linha2', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha2->setApenasTela(true);

        $oFiledCusto = new FieldSet('Análise e estimativa de custo');
        $oFiledCusto->setOculto(true);
        $oFiledCusto->addCampos(array($oLabel1, $oLabel2), array($oLabel3, $oVlrDesenProj), array($oLabel4, $oVlrFerra), array($oLabel5, $ovlrMatPrima), array($oLabel6, $ovlrAcabSuper), array($oLabel7, $ovlrTratTer), array($oLabel8, $ovlrCustProd), $oLinha2, array($oLabel9, $oCustTotal), array($oLabel20, $oCustoCento));

        $oQuantSolCli = new Campo('Quant.Sol.Cli.', 'quant_pc', Campo::TIPO_TEXTO, 1);
        $oQuantSolCli->setBCampoBloqueado(true);

        $oLoteMin = new Campo('Lote Min.', 'lotemin', Campo::TIPO_TEXTO, 1);
        $oLoteMin->setIMarginTop(0);
        $oLoteMin->setBCampoBloqueado(true);

        $oPeso = new Campo('Peso/cento/Kg', 'pesoct', Campo::TIPO_TEXTO, 1);
        $oPeso->setBCampoBloqueado(true);

        $oObsGeral = new Campo('Obs. final de projetos/Motivo da reprovação', 'obs_geral', Campo::TIPO_TEXTAREA, 12);
        $oObsGeral->setBCampoBloqueado(true);

        $oFiledVendal = new FieldSet('Definições comerciais finais');
        $oFiledVendal->setOculto(true);

        $oFieldFinalProj = new FieldSet('Análise final projetos');
        $oFieldFinalProj->addCampos($oObsGeral, array($oLoteMin, $oPeso));
        $oFieldFinalProj->setOculto(true);

        $oPrecoFinal = new campo('Preço Final', 'precofinal', Campo::TIPO_TEXTO, 1);
        $oPrecoFinal->setSCorFundo(Campo::FUNDO_MONEY);
        $oPrecoFinal->setSValor('0');

        $oPrazoEnt = new campo('Prazo entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPrazoEnt->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '1', '3');

        $oViavelFinan = new Campo('A solicitação é considerada viável financeiramente?', 'sol_viavel_fin', Campo::TIPO_RADIO, 6);
        $oViavelFinan->addItenRadio('Sim', 'Sim');
        $oViavelFinan->addItenRadio('Não', 'Não');

        $oUsuAprovaFinan = new Campo('Usu aprova', 'usuaprovafinanceiro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuAprovaFinan->setBCampoBloqueado(true);
        if ($_SESSION['codsetor'] == 34) {
            $oUsuAprovaFinan->setSValor($_SESSION['nome']);
        }

        $oDataAprovaFinan = new Campo('Data aprova', 'dtaprovafinanceiro', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataAprovaFinan->setBCampoBloqueado(true);
        if ($_SESSION['codsetor'] == 34) {
            $oDataAprovaFinan->setSValor(date('d/m/Y'));
        }

        $oObsFinan = new campo('Observação/Motivo da Reprovação', 'fin_obs', Campo::TIPO_TEXTAREA, 10);

        //$oObsVenda = new campo('Observações vendas', 'obsvenda', Campo::TIPO_TEXTAREA, 8);

        $oLinha1 = new campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);

        $oFiledVendal->addCampos(array($oPrazoEnt, $oPrecoFinal), /* $oObsVenda, */ $oLinha1, $oViavelFinan, array($oUsuAprovaFinan, $oDataAprovaFinan), $oObsFinan);

        //executa esta funcao ao sair dos campos
        $sAcaoExit = 'calcNewproj("' . $oVlrDesenProj->getId() . '",'
                . '"' . $oVlrFerra->getId() . '",'
                . '"' . $ovlrMatPrima->getId() . '",'
                . '"' . $ovlrAcabSuper->getId() . '",'
                . '"' . $ovlrTratTer->getId() . '",'
                . '"' . $ovlrCustProd->getId() . '",'
                . '"' . $oCustTotal->getId() . '",'
                . '"' . $oQuant->getId() . '",'
                . '"' . $oLoteMin->getId() . '",'
                . '"' . $oPeso->getId() . '",'
                . '"' . $oPrecoFinal->getId() . '",'
                . '"' . $oCustoCento->getId() . '",'
                . ');';
        $oVlrDesenProj->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oVlrFerra->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $ovlrMatPrima->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $ovlrAcabSuper->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $ovlrTratTer->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $ovlrCustProd->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oQuant->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oRespProj->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oLoteMin->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oPeso->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oPrecoFinal->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);
        $oCustoCento->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);

        $oDataEnvProp = new Campo('', 'dtenvprop', Campo::TIPO_TEXTO, 1);
        $oDataEnvProp->setBOculto(true);
        $oHoraEnv = new campo('', 'horaenvprop', Campo::TIPO_TEXTO, 1);
        $oHoraEnv->setBOculto(true);
        $oUserEnvPropv = new campo('', 'userenvprop', Campo::TIPO_TEXTO, 1);
        $oUserEnvPropv->setBOculto(true);

        $oDtaprovaProj = new Campo('', 'dtaprovaproj', Campo::TIPO_TEXTO, 1);
        $oDtaprovaProj->setBOculto(true);
        $oHoraAprovProj = new Campo('', 'horaaprovproj', Campo::TIPO_TEXTO, 1);
        $oHoraAprovProj->setBOculto(true);
        $oUseraprovproj = new campo('', 'useraprovproj', Campo::TIPO_TEXTO, 1);
        $oUseraprovproj->setBOculto(true);

        $oDtareprovcli = new Campo('', 'dtareprovcli', Campo::TIPO_TEXTO, 1);
        $oDtareprovcli->setBOculto(true);
        $oHorareprovcli = new Campo('', 'horareprovcli', Campo::TIPO_TEXTO, 1);
        $oHorareprovcli->setBOculto(true);
        $oUserreprovcli = new Campo('', 'userreprovcli', Campo::TIPO_TEXTO, 1);
        $oUserreprovcli->setBOculto(TRUE);
        $oObsreprovcli = new Campo('', 'obsreprovcli', Campo::TIPO_TEXTO, 1);
        $oObsreprovcli->setBOculto(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 2);
        $oOfficeDes->setBCampoBloqueado(true);

        $oRepCod = new Campo('Rep.Cod', 'repcod', Campo::TIPO_TEXTO, 1);
        $oRepCod->setBCampoBloqueado(true);

        $oRepNome = new campo('Representante', 'repnome', Campo::TIPO_TEXTO, 2);
        $oRepNome->setBCampoBloqueado(true);
        //sitcliente
        $oSitCliente = new campo('Sit.Cliente', 'sitcliente', Campo::TIPO_TEXTO, 2);
        $oSitCliente->setBCampoBloqueado(true);
        //adiciona as informações
        $oFieldInf->addCampos(array($oDataImp, $oHora, $oSit, $oFilcgc, $oFilDes, $oSitGeral), array($oOfficeDes, $oRepCod, $oRepNome, $oSitVenda, $oSitCliente));
        $oFieldInf->setOculto(true);

        $this->addCampos($oFieldInf, $oNr, array($oRespProj, $oRespProjNome, $oRespVenda, $oRespVendaNome), array($oEmpcod, $oEmpdes, $oEmail), array($oDescProd, $oAcaba, $oQuant), $oRepLibObs, $oFieldAnexo, $oFieldOperacao, $oFiledCusto, $oFieldFinalProj, $oFiledVendal, array($oDataEnvProp, $oHoraEnv, $oUserEnvPropv, $oDtaprovaProj, $oHoraAprovProj, $oUseraprovproj,
            $oDtareprovcli, $oHorareprovcli, $oUserreprovcli, $oObsreprovcli));
    }

}
