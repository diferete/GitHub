<?php

class ViewQualGerenProj extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);
        $this->setUsaAcaoIncluir(FALSE);
        $this->setUsaAcaoExcluir(FALSE);
        $this->setUsaAcaoAlterar(FALSE);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(false);
        $this->setBScrollInf(true);

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(20);
        $oNr->setSOperacao('personalizado');

        $oFilcgc = new CampoConsulta('filcgc', 'EmpRex.filcgc');
        $oFilcgc->setILargura(70);

        $oProdDesc = new CampoConsulta('Produto', 'desc_novo_prod');
        $oProdDesc->setILargura(520);

        $oRespVenda = new CampoConsulta('Resp.Venda', 'resp_venda_nome');
        $oRespVenda->setILargura(70);

        $oRespProj = new CampoConsulta('Resp.Proj', 'resp_proj_nome');
        $oRespProj->setILargura(50);

        $oRepNome = new CampoConsulta('Representante', 'repnome');
        $oRepNome->setILargura(70);

        $oSitGeral = new CampoConsulta('Sit.Proj', 'sitgeralproj');
        $oSitGeral->setILargura(50);

        $oDrop = new Dropdown('Agendamentos', Dropdown::TIPO_PRIMARY);
        $this->addDropdown($oDrop);
        $oDrop->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Teste agenda', 'Agendamentos', 'atualizaEntProj', '', false, '');


        $oFilRepNome = new Filtro($oRepNome, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 2, 2);

        $oFilProdDesc = new Filtro($oProdDesc, Filtro::CAMPO_TEXTO, 2, 2, 2, 2);

        $oFRespVenda = new Filtro($oRespVenda, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 2, 2);

        $this->addFiltro($oFilProdDesc);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","QualGerenProj","renderTempo",chave+",qualgerenprojtempo");');

        $this->addCampos($oNr, $oFilcgc, $oProdDesc, $oRespProj, $oRespVenda, $oRepNome, $oSitGeral);
    }

    public function criaTela() {
        parent::criaTela();

        //field de informações
        $oFieldInf = new FieldSet('Informações');

        $oDataImp = new campo('Implantação', 'dtimp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataImp->setSValor(date('d/m/Y'));
        $oDataImp->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horaimp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oSit = new campo('Sit.Projetos', 'sitproj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSit->setSValor('Lib.Projetos');
        $oSit->setBCampoBloqueado(true);

        $oFilcgc = new Campo('CNPJ', 'EmpRex.filcgc', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oFilDes = new campo('Empresa', 'EmpRex.fildes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('EmpRex');
        $oFilDes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oFilDes->addCampoBusca('filcgc', '', '');
        $oFilDes->addCampoBusca('fildes', '', '');
        $oFilDes->setSIdTela($this->getTela()->getid());
        $oFilDes->setSValor('REX MÁQUINAS E EQUIPAMENTOS LTDA');
        $oFilDes->setBCampoBloqueado(true);

        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('fildes', $oFilDes->getId(), $this->getTela()->getId());

        $oSitGeral = new campo('Sit.Geral', 'sitgeralproj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitGeral->setBCampoBloqueado(true);
        $oSitGeral->setSValor('Lib.Projetos');

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oOfficeDes->setBCampoBloqueado(true);

        $oRepCod = new Campo('Rep.Cod', 'repcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRepCod->setBCampoBloqueado(true);

        $oRepNome = new campo('Representante', 'repnome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRepNome->setBCampoBloqueado(true);

        $oSitVenda = new campo('Sit.Vendas', 'sitvendas', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitVenda->setBCampoBloqueado(true);

        $oSitCliente = new campo('Sit.Cliente', 'sitcliente', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitCliente->setBCampoBloqueado(true);

        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oRespProj = new campo('...', 'resp_proj_cod', Campo::TIPO_BUSCADOBANCO, 1, 1, 12, 12);
        $oRespProj->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespProj->setBFocus(true);
        $oRespProj->setBCampoBloqueado(true);

        $oRespProjNome = new Campo('Resp. Projetos', 'resp_proj_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespProjNome->setSIdPk($oRespProj->getId());
        $oRespProjNome->setClasseBusca('User');
        $oRespProjNome->addCampoBusca('usucodigo', '', '');
        $oRespProjNome->addCampoBusca('usunome', '', '');
        $oRespProjNome->setSIdTela($this->getTela()->getid());
        $oRespProjNome->setBCampoBloqueado(true);

        $oRespProj->setClasseBusca('User');
        $oRespProj->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespProj->addCampoBusca('usunome', $oRespProjNome->getId(), $this->getTela()->getId());

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_BUSCADOBANCO, 1, 1, 12, 12);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespVenda->setBCampoBloqueado(true);

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespVendaNome->setSIdPk($oRespVenda->getId());
        $oRespVendaNome->setClasseBusca('User');
        $oRespVendaNome->addCampoBusca('usucodigo', '', '');
        $oRespVendaNome->addCampoBusca('usunome', '', '');
        $oRespVendaNome->setSIdTela($this->getTela()->getid());
        $oRespVendaNome->setBCampoBloqueado(true);

        $oRespVenda->setClasseBusca('User');
        $oRespVenda->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespVenda->addCampoBusca('usunome', $oRespVendaNome->getId(), $this->getTela()->getId());

        $oEmpcod = new Campo('CNPJ Cliente', 'Pessoa.empcod', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new Campo('Cliente', 'Pessoa.empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpdes->setBCampoBloqueado(true);

        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());

        $oEmail = new Campo('Email', 'emailCli', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmail->setBCampoBloqueado(true);

        $oDescProd = new campo('Descrição do produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oDescProd->setBCampoBloqueado(true);
        $oDescProd->setIMarginTop(8);


        $oAcaba = new Campo('Acabamento do Produto', 'acabamento', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oAcaba->addItemSelect('POL', 'Polido');
        $oAcaba->addItemSelect('ZINC', 'Branco');
        $oAcaba->addItemSelect('BICR', 'Bicromatizado');
        $oAcaba->addItemSelect('G.FOG', 'PO Galvanizado Fogo');
        $oAcaba->addItemSelect('GALV.FOG', 'PF Galvanizado Fogo');
        $oAcaba->addItemSelect('Z.FE.PRT', 'Zinc. Ferro Preto');
        $oAcaba->addItemSelect('Z.FE.AMARL', 'Zinc. Ferro Amarelo');
        $oAcaba->addItemSelect('ORG.MET', 'Org. Metalico');
        $oAcaba->addItemSelect('ZINC.PRT', 'Zin. Preto');
        $oAcaba->addItemSelect('BICR.TRIV', 'Bic. Trivalente');
        $oAcaba->setSCorFundo(Campo::FUNDO_VERDE);
        $oAcaba->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');

        $sBuscaCli = 'var empcod = $("#' . $oEmpcod->getId() . '").val();  '
                . ' if($("#' . $oEmpcod->getId() . '").val()!==""){requestAjax("","QualNovoProj","acaoExitEmp",""+empcod+",' . $oEmail->getId() . '");}';

        $oEmpcod->addEvento(Campo::EVENTO_SAIR, $sBuscaCli);

        $oRepLibObs = new Campo('Observação Representante', 'replibobs', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oRepLibObs->setILinhasTextArea(5);
        $oRepLibObs->setBCampoBloqueado(true);

        $oReprovaObs = new Campo('Observação se Reprovado', 'obsreprovcli', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oReprovaObs->setILinhasTextArea(5);
        $oReprovaObs->setBCampoBloqueado(TRUE);

        $oQuant = new campo('Quant/Cnt.', 'quant_pc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oQuant->setSValor('0');
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);
        $oQuant->setIMarginTop(8);

        $oEquipamento = new Campo('Temos equipamento correspondente', 'equip_corresp', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oEquipamento->addItemSelect('Sim', 'Sim');
        $oEquipamento->addItemSelect('Não', 'Não');

        $oEquipEvidencia = new campo('Evidência', 'equip_corresp_evid', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oEquipEvidencia->setIMarginTop(7);

        $oMatPrima = new Campo('Temos matéria prima correspondente', 'mat_prima', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oMatPrima->addItemSelect('Sim', 'Sim');
        $oMatPrima->addItemSelect('Não', 'Não');

        $oEquipMatPrima = new campo('Evidência', 'mat_prima_evid', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oEquipMatPrima->setIMarginTop(7);

        //estudo_proc
        $oEstudoProc = new Campo('Requer estudo de processo', 'estudo_proc', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oEstudoProc->addItemSelect('Sim', 'Sim');
        $oEstudoProc->addItemSelect('Não', 'Não');

        $oEstudoEvid = new Campo('Evidência', 'estudo_proc_evid', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oEstudoEvid->setIMarginTop(7);

        //prod_sim
        $oProdSimilar = new Campo('Existe produto similar?', 'prod_sim', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oProdSimilar->addItemSelect('Sim', 'Sim');
        $oProdSimilar->addItemSelect('Não', 'Não');
        //prod_sim_evid

        $oProdSimilarEvid = new Campo('Evidência', 'prod_sim_evid', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oProdSimilarEvid->setIMarginTop(7);

        //desen_ferram
        $oDesenFerram = new Campo('Precisa desenvolver ferramental?', 'desen_ferram', Campo::TIPO_SELECT, 3);
        $oDesenFerram->addItemSelect('Sim', 'Sim');
        $oDesenFerram->addItemSelect('Não', 'Não');
        //desen_ferram_evid
        $oDesenFerramEvid = new Campo('Evidência', 'desen_ferram_evid', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oDesenFerramEvid->setIMarginTop(7);

        $oObs_viavel = new Campo('Observação', 'sol_viavel_obs', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oObs_viavel->setILinhasTextArea(5);
        $oObs_viavel->setBCampoBloqueado(true);

        $oViavel = new Campo('A solicitação é considerada viável operacionalmente?', 'sol_viavel', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oViavel->addItenRadio('Sim', 'Sim');
        $oViavel->addItenRadio('Não', 'Não');

        $oFieldOperacao = new FieldSet('Análise operacional da solicitação');
        $oFieldOperacao->setOculto(true);
        $oFieldOperacao->addCampos(array($oEquipamento, $oEquipEvidencia), array($oMatPrima, $oEquipMatPrima), array($oEstudoProc, $oEstudoEvid), array($oProdSimilar, $oProdSimilarEvid), array($oDesenFerram, $oDesenFerramEvid), $oViavel, $oObs_viavel);

        $oLabel1 = new Campo('Requisitos analisados', 'label1', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oLabel1->setIMarginTop(15);
        $oLabel2 = new Campo('Valor', 'label2', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oLabel2->setIMarginTop(15);

        $oLabel3 = new campo('Planejamento e desenvolvimento do projeto', 'label3', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oVlrDesenProj = new Campo('', 'vlrDesenProj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVlrDesenProj->setIMarginTop(2);
        $oVlrDesenProj->setSValor('0');

        $oLabel4 = new campo('Ferramental', 'label4', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oVlrFerra = new campo('', 'vlrFerramen', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVlrFerra->setIMarginTop(2);
        $oVlrFerra->setSValor('0');

        $oLabel5 = new campo('Matéria Prima', 'label5', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $ovlrMatPrima = new campo('', 'vlrMatPrima', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ovlrMatPrima->setIMarginTop(2);
        $ovlrMatPrima->setSValor('0');

        $oLabel6 = new campo('Acabamento Superfícial', 'label6', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $ovlrAcabSuper = new campo('', 'vlrAcabSuper', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ovlrAcabSuper->setIMarginTop(2);
        $ovlrAcabSuper->setSValor('0');

        $oLabel7 = new campo('Tratamento térmico', 'label7', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $ovlrTratTer = new campo('', 'vlrTratTer', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ovlrTratTer->setIMarginTop(2);
        $ovlrTratTer->setSValor('0');

        $oLabel8 = new campo('Custo de produção', 'label8', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $ovlrCustProd = new campo('', 'vlrCustProd', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ovlrCustProd->setSValor(0);
        $ovlrCustProd->setIMarginTop(2);

        $oLabel9 = new campo('Estimativa de custo total', 'label9', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oCustTotal = new Campo('', 'custtot', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCustTotal->setSValor('0');
        $oCustTotal->setApenasTela(true);
        $oCustTotal->setIMarginTop(3);
        $oCustTotal->setSCorFundo(Campo::FUNDO_VERDE);
        $oCustTotal->setBCampoBloqueado(true);

        $oLinha2 = new campo('', 'linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha2->setApenasTela(true);

        $oFiledCusto = new FieldSet('Análise e estimativa de custo');
        $oFiledCusto->setOculto(true);
        $oFiledCusto->addCampos(array($oLabel1, $oLabel2), array($oLabel3, $oVlrDesenProj), array($oLabel4, $oVlrFerra), array($oLabel5, $ovlrMatPrima), array($oLabel6, $ovlrAcabSuper), array($oLabel7, $ovlrTratTer), array($oLabel8, $ovlrCustProd), $oLinha2, array($oLabel9, $oCustTotal));

        $oLoteMin = new Campo('Lote mínimo', 'lotemin', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oLoteMin->setIMarginTop(0);

        $oPeso = new Campo('Peso/cento/Kg', 'pesoct', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oObsGeral = new Campo('Observação Projetos/Motivo Reprovção', 'obs_geral', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oObsGeral->setILinhasTextArea(5);
        $oObsGeral->setBCampoBloqueado(true);

        $oFiledVendal = new FieldSet('Definições comerciais finais');
        $oFiledVendal->setOculto(true);

        $oFieldFinalProj = new FieldSet('Análise final projetos');
        $oFieldFinalProj->addCampos($oObsGeral, array($oLoteMin, $oPeso));
        $oFieldFinalProj->setOculto(true);

        $oPrecoFinal = new campo('Preço Final', 'precofinal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPrecoFinal->setSCorFundo(Campo::FUNDO_MONEY);
        $oPrecoFinal->setSValor('0');

        $oPrazoEnt = new campo('Prazo entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oLinha1 = new Campo('', 'linha2', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oViavelFinan = new Campo('A solicitação é considerada viável financeiramente?', 'sol_viavel_fin', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oViavelFinan->addItenRadio('Sim', 'Sim');
        $oViavelFinan->addItenRadio('Não', 'Não');

        $oObsFinan = new campo('Observação Vendas/Motivo Reprovação', 'fin_obs', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oObsFinan->setILinhasTextArea(5);
        $oObsFinan->setBCampoBloqueado(true);

        /* $oObsVenda = new campo('Observações vendas', 'obsvenda', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
          $oObsVenda->setILinhasTextArea(5);
          $oObsVenda->setBCampoBloqueado(true);
         * 
         */

        $oFiledVendal->addCampos(array($oPrazoEnt, $oPrecoFinal), /* $oObsVenda, */ $oLinha1, $oViavelFinan, $oObsFinan);

        //executa esta funcao ao sair dos campos
        $sAcaoExit = 'calcNewproj("' . $oVlrDesenProj->getId() . '","' . $oVlrFerra->getId() . '","' . $ovlrMatPrima->getId() . '","' . $ovlrAcabSuper->getId() . '",'
                . '"' . $ovlrTratTer->getId() . '","' . $ovlrCustProd->getId() . '","' . $oCustTotal->getId() . '",'
                . '"' . $oQuant->getId() . '","' . $oLoteMin->getId() . '","' . $oPeso->getId() . '","' . $oPrecoFinal->getId() . '");';
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

        $oDataEnvProp = new Campo('', 'dtenvprop', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataEnvProp->setBOculto(true);
        $oHoraEnv = new campo('', 'horaenvprop', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraEnv->setBOculto(true);
        $oUserEnvPropv = new campo('', 'userenvprop', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUserEnvPropv->setBOculto(true);

        $oDtaprovaProj = new Campo('', 'dtaprovaproj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDtaprovaProj->setBOculto(true);
        $oHoraAprovProj = new Campo('', 'horaaprovproj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraAprovProj->setBOculto(true);
        $oUseraprovproj = new campo('', 'useraprovproj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUseraprovproj->setBOculto(true);

        $oDtareprovcli = new Campo('', 'dtareprovcli', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDtareprovcli->setBOculto(true);
        $oHorareprovcli = new Campo('', 'horareprovcli', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHorareprovcli->setBOculto(true);
        $oUserreprovcli = new Campo('', 'userreprovcli', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUserreprovcli->setBOculto(TRUE);
        $oObsreprovcli = new Campo('', 'obsreprovcli', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oObsreprovcli->setBOculto(true);

        //adiciona as informações
        $oFieldInf->addCampos(array($oDataImp, $oHora, $oOfficeDes, $oRepCod, $oRepNome), array($oFilcgc, $oFilDes, $oSit, $oSitVenda, $oSitCliente, $oSitGeral));
        $oFieldInf->setOculto(true);

        $this->addCampos($oFieldInf, $oNr, array($oRespProj, $oRespProjNome, $oRespVenda, $oRespVendaNome), array($oEmpcod, $oEmpdes, $oEmail), array($oDescProd, $oAcaba, $oQuant), $oRepLibObs, $oReprovaObs, $oFieldOperacao, $oFiledCusto, $oFieldFinalProj, $oFiledVendal, array($oDataEnvProp, $oHoraEnv, $oUserEnvPropv, $oDtaprovaProj, $oHoraAprovProj, $oUseraprovproj,
            $oDtareprovcli, $oHorareprovcli, $oUserreprovcli, $oObsreprovcli));
    }

    public function relNovoProjeto() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Projetos');
        $this->setBTela(true);

        $oFieldRel = new FieldSet('Situações por setor');


        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataFin->setSValor(Util::getDataAtual());
        $oDataFin->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 1);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","QualGerenProj","relProjXls");';
        $oXls->getOBotao()->addAcao($sAcaoLib);

        $oRelPrj = new Campo('Projetos', 'ordsit1', Campo::TIPO_SELECT, 3);
        $oRelPrj->addItemSelect('', 'Todos');
        $oRelPrj->addItemSelect('Aprovado', 'Aprovado');
        $oRelPrj->addItemSelect('Reprovado', 'Reprovado');

        $oRelVend = new Campo('Vendas', 'ordsit2', Campo::TIPO_SELECT, 3);
        $oRelVend->addItemSelect('', 'Todos');
        $oRelVend->addItemSelect('Aprovado', 'Aprovado');
        $oRelVend->addItemSelect('Reprovado', 'Reprovado');

        $oRelCli = new Campo('Cliente', 'ordsit3', Campo::TIPO_SELECT, 3);
        $oRelCli->addItemSelect('', 'Todos');
        $oRelCli->addItemSelect('Aprovado', 'Aprovado');
        $oRelCli->addItemSelect('Reprovado', 'Reprovado');

        $oFieldRel->addCampos(array($oRelPrj, $oRelVend, $oRelCli));

        $oFieldRel2 = new FieldSet('Situações gerais');

        $oSitGRel = new campo('Geral', 'geralsit', Campo::TIPO_SELECT);
        $oSitGRel->addItemSelect('', 'Todos');
        $oSitGRel->addItemSelect('Faturado', 'Faturado');
        $oSitGRel->addItemSelect('Cadastrado', 'Cadastrado');
        $oSitGRel->addItemSelect('Produzido', 'Produzido');

        $oFieldRel2->addCampos(array($oSitGRel));

        $this->addCampos(array($oDataIni, $oDataFin), $oFieldRel, $oFieldRel2, $oXls);
    }

}
