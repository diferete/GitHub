<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualNovoProj extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);

        $oData = new CampoConsulta('Data', 'dtimp', CampoConsulta::TIPO_DATA);
        $oData->setILargura(50);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNr->setILargura(20);

        $oEmpDes = new CampoConsulta('Cliente', 'Pessoa.empdes');
        $oEmpDes->setILargura(350);

        $oRepNome = new CampoConsulta('Rep.', 'repnome');
        $oRepNome->setILargura(100);

        $oQuantPc = new CampoConsulta('Quant.Cnt/Mês', 'quant_pc', CampoConsulta::TIPO_DECIMAL);
        $oQuantPc->setILargura(100);

        $oDescProdNew = new CampoConsulta('Novo produto', 'desc_novo_prod');

        $oSitProj = new CampoConsulta('SitProjetos', 'sitproj', CampoConsulta::TIPO_TEXTO);
        $oSitProj->addComparacao('Cód. enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitProj->setBComparacaoColuna(true);
        $oSitProj->setILargura(11);

        $oSitVendas = new CampoConsulta('SitVendas', 'sitvendas', CampoConsulta::TIPO_TEXTO);
        $oSitVendas->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitVendas->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitVendas->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitVendas->setBComparacaoColuna(true);
        $oSitVendas->setILargura(11);

        $oSitCli = new CampoConsulta('SitCliente', 'sitcliente', CampoConsulta::TIPO_TEXTO);
        $oSitCli->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitCli->addComparacao('Expirado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSitCli->setBComparacaoColuna(true);
        $oSitCli->setILargura(11);

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
        $oSitGeral->setILargura(11);


        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);

        $oFilDescProdNew = new Filtro($oDescProdNew, Filtro::CAMPO_TEXTO, 8, 8, 12, 12);
        /**
         * filtro referente a situação do projeto
         */
        $oFSitProj = new Filtro($oSitProj, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFSitProj->addItemSelect('Todos', 'Todos Projetos');
        $oFSitProj->addItemSelect('Lib.Projetos', 'Lib.Projetos');
        $oFSitProj->addItemSelect('Lib.Cadastro', 'Lib.Cadastro');
        $oFSitProj->addItemSelect('Aprovado', 'Aprovado');
        $oFSitProj->addItemSelect('Reprovado', 'Reprovado');
        $oFSitProj->addItemSelect('Cód. enviado', 'Cód. enviado');
        $oFSitProj->setSLabel('');

        $oFSitGeralProj = new Filtro($oSitGeral, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFSitGeralProj->addItemSelect('Todos', 'Todos Geral');
        $oFSitGeralProj->addItemSelect('Em execução', 'Em execução');
        $oFSitGeralProj->addItemSelect('Lib.Cadastro', 'Lib.Cadastro');
        $oFSitGeralProj->addItemSelect('Lib.Projetos', 'Lib.Projetos');
        $oFSitGeralProj->addItemSelect('Finalizado', 'Finalizado');
        $oFSitGeralProj->addItemSelect('Aprovado', 'Aprovado');
        $oFSitGeralProj->addItemSelect('Representante', 'Representante');
        $oFSitGeralProj->setSLabel('');

        $oFilEmpDes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12);

        $this->addFiltro($oFSitProj,$oFSitGeralProj, $oFilNr, $oFilData, $oFilEmpDes, $oFilDescProdNew);

        $this->addCampos($oNr, $oSitProj, $oSitVendas, $oSitCli, $oSitGeral, $oData, $oEmpDes, $oRepNome, $oDescProdNew, $oQuantPc);

        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY, Dropdown::ICON_POSITIVO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aprovar projeto', 'QualNovoProj', 'msAprovaProj', '', false, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Reprovar projeto', 'QualNovoProj', 'msgReprovaProj', '', false, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_RECARREGAR) . 'Retornar para representante', 'QualNovoProj', 'msgRetRep', '', false, '');

        $oDrop2 = new Dropdown('Proposta', Dropdown::TIPO_DARK, Dropdown::ICON_RANDOM);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Relatório da proposta', 'QualNovoProj', 'acaoMostraRelConsulta', '', false, 'relPropProj');

        $oDrop3 = new Dropdown('E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Reenviar e-mail aprovação', 'QualNovoProj', 'reenviaAprovaProj', '', false, '');
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Reenviar e-mail reprovação', 'QualNovoProj', 'reenviaReprovaProj', '', false, '');
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_RECARREGAR) . 'Reennvia retorno para representante', 'QualNovoProj', 'reenviaRetornoRep', '', false, '');

        $this->addDropdown($oDrop1, $oDrop2, $oDrop3);
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
        $oFilDes->setSValor('Metalbo Indústria de Fixadores Metálicos LTDA');

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

        $oRespProj = new campo('...', 'resp_proj_cod', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 1, 1);
        $oRespProj->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespProj->setBFocus(true);

        $oRespProjNome = new Campo('Resp. Projetos', 'resp_proj_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 3, 3);
        $oRespProjNome->setSIdPk($oRespProj->getId());
        $oRespProjNome->setClasseBusca('User');
        $oRespProjNome->addCampoBusca('usucodigo', '', '');
        $oRespProjNome->addCampoBusca('usunome', '', '');
        $oRespProjNome->setSIdTela($this->getTela()->getid());

        $oRespProj->setClasseBusca('User');
        $oRespProj->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespProj->addCampoBusca('usunome', $oRespProjNome->getId(), $this->getTela()->getId());

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oRespVenda->setBCampoBloqueado(true);
        /* $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
          $oRespVenda->setBFocus(true);
         */


        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        $oRespVendaNome->setBCampoBloqueado(true);
        /* $oRespVendaNome->setSIdPk($oRespVenda->getId());
          $oRespVendaNome->setClasseBusca('User');
          $oRespVendaNome->addCampoBusca('usucodigo', '', '');
          $oRespVendaNome->addCampoBusca('usunome', '', '');
          $oRespVendaNome->setSIdTela($this->getTela()->getid());

          $oRespVenda->setClasseBusca('User');
          $oRespVenda->setSCampoRetorno('usucodigo', $this->getTela()->getId());
          $oRespVenda->addCampoBusca('usunome', $oRespVendaNome->getId(), $this->getTela()->getId());
         */

        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_TEXTO, 2);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new Campo('Cliente', 'Pessoa.empdes', Campo::TIPO_TEXTO, 4);
        $oEmpdes->setBCampoBloqueado(true);
        /* $oEmpdes->setSIdPk($oEmpcod->getId());
          $oEmpdes->setClasseBusca('Pessoa');
          $oEmpdes->addCampoBusca('empcod', '', '');
          $oEmpdes->addCampoBusca('empdes', '', '');
          $oEmpdes->setSIdTela($this->getTela()->getid());
          $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);

          $oEmpcod->setClasseBusca('Pessoa');
          $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
          $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());
         * 
         */


        $oEmail = new Campo('Email', 'emailCli', Campo::TIPO_TEXTO, 3);
        $oEmail->setBCampoBloqueado(true);

        $oDescProd = new campo('Descrição do produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 6);

        $oAcaba = new Campo('Acabamento do Produto', 'acabamento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAcaba->setBCampoBloqueado(true);

        $sBuscaCli = 'var empcod = $("#' . $oEmpcod->getId() . '").val();  '
                . ' if($("#' . $oEmpcod->getId() . '").val()!==""){requestAjax("","QualNovoProj","acaoExitEmp",""+empcod+",' . $oEmail->getId() . '");}';

        $oEmpcod->addEvento(Campo::EVENTO_SAIR, $sBuscaCli);

        $oRepLibObs = new Campo('Observação Representante', 'replibobs', Campo::TIPO_TEXTAREA, 8);
        $oRepLibObs->setILinhasTextArea(5);
        $oRepLibObs->setBCampoBloqueado(true);


        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 1);
        $oQuant->setSValor('0');
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);

        $oAnexoDesenho = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 2);

        $oAnexoDoc = new campo('Anexo 2', 'anexo2', Campo::TIPO_UPLOAD, 2);

        $oAnexoFree = new campo('Anexo 3', 'anexo3', Campo::TIPO_UPLOAD, 2);

        $oFieldAnexo = new FieldSet('Anexos');
        $oFieldAnexo->addCampos(array($oAnexoDesenho, $oAnexoDoc, $oAnexoFree));
        $oFieldAnexo->setOculto(true);

        $oEquipamento = new Campo('Temos equipamento correspondente', 'equip_corresp', Campo::TIPO_SELECT, 3);
        $oEquipamento->addItemSelect('Sim', 'Sim');
        $oEquipamento->addItemSelect('Não', 'Não');

        $oEquipEvidencia = new campo('Evidência', 'equip_corresp_evid', Campo::TIPO_TEXTO, 5);
      
        $oMatPrima = new Campo('Temos matéria prima correspondente', 'mat_prima', Campo::TIPO_SELECT, 3);
        $oMatPrima->addItemSelect('Sim', 'Sim');
        $oMatPrima->addItemSelect('Não', 'Não');

        $oEquipMatPrima = new campo('Evidência', 'mat_prima_evid', Campo::TIPO_TEXTO, 5);
       
        //estudo_proc

        $oEstudoProc = new Campo('Requer estudo de processo', 'estudo_proc', Campo::TIPO_SELECT, 3);
        $oEstudoProc->addItemSelect('Sim', 'Sim');
        $oEstudoProc->addItemSelect('Não', 'Não');

        $oEstudoEvid = new Campo('Evidência', 'estudo_proc_evid', Campo::TIPO_TEXTO, 5);
     
        //prod_sim
        $oProdSimilar = new Campo('Existe produto similar?', 'prod_sim', Campo::TIPO_SELECT, 3);
        $oProdSimilar->addItemSelect('Sim', 'Sim');
        $oProdSimilar->addItemSelect('Não', 'Não');
        //prod_sim_evid

        $oProdSimilarEvid = new Campo('Evidência', 'prod_sim_evid', Campo::TIPO_TEXTO, 5);
      
        //desen_ferram
        $oDesenFerram = new Campo('Precisa desenvolver ferramental?', 'desen_ferram', Campo::TIPO_SELECT, 3);
        $oDesenFerram->addItemSelect('Sim', 'Sim');
        $oDesenFerram->addItemSelect('Não', 'Não');
        //desen_ferram_evid
        $oDesenFerramEvid = new Campo('Evidência', 'desen_ferram_evid', Campo::TIPO_TEXTO, 5);
      
        $oObs_viavel = new Campo('Observação', 'sol_viavel_obs', Campo::TIPO_TEXTAREA, 8);

        $oViavel = new Campo('A solicitação é considerada viável operacionalmente?', 'sol_viavel', Campo::TIPO_RADIO, 6);
        $oViavel->addItenRadio('Sim', 'Sim');
        $oViavel->addItenRadio('Não', 'Não');

        $oFieldOperacao = new FieldSet('Análise operacional da solicitação');
        $oFieldOperacao->setOculto(true);
        $oFieldOperacao->addCampos(array($oEquipamento, $oEquipEvidencia), array($oMatPrima, $oEquipMatPrima), array($oEstudoProc, $oEstudoEvid), array($oProdSimilar, $oProdSimilarEvid), array($oDesenFerram, $oDesenFerramEvid), $oViavel, $oObs_viavel);



        $oLabel1 = new Campo('Requisitos analisados', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel1->setIMarginTop(15);

        $oLabel2 = new Campo('Valor', 'label2', Campo::TIPO_LABEL, 3);
        $oLabel2->setIMarginTop(15);

        $oLabel3 = new campo('Planejamento e desenvolvimento do projeto', 'label3', Campo::TIPO_LABEL, 3);
        $oVlrDesenProj = new Campo('', 'vlrDesenProj', Campo::TIPO_TEXTO, 1);
        $oVlrDesenProj->setIMarginTop(2);
        $oVlrDesenProj->setSValor('0');


        $oLabel4 = new campo('Ferramental', 'label4', Campo::TIPO_LABEL, 3);
        $oVlrFerra = new campo('', 'vlrFerramen', Campo::TIPO_TEXTO, 1);
        $oVlrFerra->setIMarginTop(2);
        $oVlrFerra->setSValor('0');

        $oLabel5 = new campo('Matéria Prima', 'label5', Campo::TIPO_LABEL, 3);
        $ovlrMatPrima = new campo('', 'vlrMatPrima', Campo::TIPO_TEXTO, 1);
        $ovlrMatPrima->setIMarginTop(2);
        $ovlrMatPrima->setSValor('0');

        $oLabel6 = new campo('Acabamento Superfícial', 'label6', Campo::TIPO_LABEL, 3);
        $ovlrAcabSuper = new campo('', 'vlrAcabSuper', Campo::TIPO_TEXTO, 1);
        $ovlrAcabSuper->setIMarginTop(2);
        $ovlrAcabSuper->setSValor('0');

        $oLabel7 = new campo('Tratamento térmico', 'label7', Campo::TIPO_LABEL, 3);
        $ovlrTratTer = new campo('', 'vlrTratTer', Campo::TIPO_TEXTO, 1);
        $ovlrTratTer->setIMarginTop(2);
        $ovlrTratTer->setSValor('0');

        $oLabel8 = new campo('Custo de produção', 'label8', Campo::TIPO_LABEL, 3);
        $ovlrCustProd = new campo('', 'vlrCustProd', Campo::TIPO_TEXTO, 1);
        $ovlrCustProd->setSValor(0);
        $ovlrCustProd->setIMarginTop(2);

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

        $oQuantSolCli = new Campo('Quant.Sol.Cli.', 'quant_pc', Campo::TIPO_TEXTO, 1);
        $oQuantSolCli->setBCampoBloqueado(true);

        $oLoteMin = new Campo('Lote mínimo', 'lotemin', Campo::TIPO_TEXTO, 1);
        $oLoteMin->setIMarginTop(0);


        $oPeso = new Campo('Peso/cento/Kg', 'pesoct', Campo::TIPO_TEXTO, 1);

        $oObsGeral = new Campo('Observação projetos/Motivo reprovação', 'obs_geral', Campo::TIPO_TEXTAREA, 12);


        $oLinha2 = new Campo('', 'linha2', Campo::TIPO_LINHA, 12);
        $oLinha2->setApenasTela(true);

        $oLinha3 = new Campo('', 'linha3', Campo::TIPO_LINHA, 12);
        $oLinha3->setApenasTela(true);

        $oFiledCusto = new FieldSet('Análise econômica');
        $oFiledCusto->setOculto(true);
        $oFiledCusto->addCampos(
                array($oLabel1, $oLabel2), array($oLabel3, $oVlrDesenProj), array($oLabel4, $oVlrFerra), array($oLabel5, $ovlrMatPrima), array($oLabel6, $ovlrAcabSuper), array($oLabel7, $ovlrTratTer), array($oLabel8, $ovlrCustProd), $oLinha2, array($oLabel9, $oCustTotal), array($oLabel20, $oCustoCento), $oLinha3, array($oQuantSolCli, $oLoteMin, $oPeso), $oObsGeral);


        $oFiledVendal = new FieldSet('Definições comerciais finais');
        $oFiledVendal->setOculto(true);

        $oPrecoFinal = new campo('Preço Final', 'precofinal', Campo::TIPO_TEXTO, 1);
        $oPrecoFinal->setSCorFundo(Campo::FUNDO_MONEY);
        $oPrecoFinal->setSValor('0');
        $oPrecoFinal->setBCampoBloqueado(true);

        $oPrazoEnt = new campo('Prazo entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 2);
        $oPrazoEnt->setBCampoBloqueado(true);

        $oViavelFinan = new Campo('Viável financeiramente?', 'sol_viavel_fin', Campo::TIPO_TEXTO, 2);
        $oViavelFinan->setBCampoBloqueado(true);


        $oObsFinan = new campo('Observação vendas/Motivo reprovação', 'fin_obs', Campo::TIPO_TEXTAREA, 10);
        $oObsFinan->setBCampoBloqueado(true);

        //$oObsVenda = new campo('Observações vendas/Motivo reprovação', 'obsvenda', Campo::TIPO_TEXTAREA, 8);

        $oLinha1 = new campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);


        $oFiledVendal->addCampos(array($oPrazoEnt, $oPrecoFinal), /* $oObsVenda, */ $oLinha1, $oViavelFinan, $oObsFinan);


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

        //campos de situações
        $oSitVenda = new campo('Sit.Vendas', 'sitvendas', Campo::TIPO_TEXTO, 2);
        $oSitVenda->setBCampoBloqueado(true);
        $oSitCliente = new campo('Sit.Cliente', 'sitcliente', Campo::TIPO_TEXTO, 2);
        $oSitCliente->setBCampoBloqueado(true);

        //adiciona as informações
        $oFieldInf->addCampos(array($oDataImp, $oHora, $oSit, $oFilcgc, $oFilDes, $oSitGeral), array($oOfficeDes, $oRepCod, $oRepNome, $oSitVenda, $oSitCliente));
        $oFieldInf->setOculto(true);



        $this->addCampos($oFieldInf, $oNr, array($oRespProj, $oRespProjNome, $oRespVenda, $oRespVendaNome), array($oEmpcod, $oEmpdes, $oEmail), array($oDescProd, $oAcaba, $oQuant), $oRepLibObs, $oFieldAnexo, $oFieldOperacao, $oFiledCusto, /* $oFieldFinalProj, */ $oFiledVendal, array($oDataEnvProp, $oHoraEnv, $oUserEnvPropv, $oDtaprovaProj, $oHoraAprovProj, $oUseraprovproj,
            $oDtareprovcli, $oHorareprovcli, $oUserreprovcli, $oObsreprovcli));
    }

    public function criaModal() {
        parent::criaModal();

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 4);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBOculto(true);
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 2);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBOculto(true);


        $oBs = new Campo('Observação da reprovação', 'obsreprovproj', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $this->setBTela(true);
        $oBs->setILinhasTextArea(5);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        // $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","reprovaObsCli","' . $this->getTela()->getId() . '-form,' . $aDados['id'] . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);





        $this->addCampos($oBs, array($oBtnInserir, $oFilcgc, $oNr));
    }

    public function criaModal2() {
        parent::criaModal();

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 4);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBOculto(true);
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 2);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBOculto(true);

        $oObsAprovCli = new campo('Observação de aprovação', 'obsaprovcli', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsAprovCli->setILinhasTextArea(5);

        $this->setBTela(true);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        // $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","aprovaObsCli","' . $this->getTela()->getId() . '-form,' . $aDados['id'] . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);





        $this->addCampos($oObsAprovCli, array($oBtnInserir, $oFilcgc, $oNr));
    }

    public function criaModal3() {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oLabe1 = new Campo('Projeto nr: ' . $oDados->nr, 'nr', Campo::TIPO_LABEL, 3);
        $oLabe2 = new campo('Data: ' . $oDados->dtimp, 'dtimp', Campo::TIPO_LABEL, 3);
        $oLabe3 = new campo('Hora: ' . $oDados->horaimp, 'horaimp', Campo::TIPO_LABEL, 6);

        $oField1 = new FieldSet('Situação projetos');
        if ($oDados->sitproj == 'Aprovado') {
            $oLabe5 = new campo('Situação: ' . $oDados->sitproj, 'sitproj', Campo::TIPO_LABEL, 3);
            $oLabe6 = new campo('Data Aprov.: ' . $oDados->dtaprovaproj, 'sitproj', Campo::TIPO_LABEL, 5);
            $oLabe7 = new campo('Hora: ' . $oDados->horaaprovproj, 'hora', Campo::TIPO_LABEL, 4);
            $oLinha = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oLabe8 = new campo('Usuário: ' . $oDados->useraprovproj, 'useraprovproj', Campo::TIPO_LABEL, 5);
            $oField1->addCampos($oLinha, array($oLabe5, $oLabe6, $oLabe7), $oLabe8);
        }

        if ($oDados->sitproj == 'Aberto') {
            $oLabe5 = new campo('Situação: ' . $oDados->sitproj, 'sitproj', Campo::TIPO_LABEL, 3);
            $oLabe6 = new Campo('Projeto está em análise', 'sitproj', Campo::TIPO_LABEL, 5);
            $oLinha = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oField1->addCampos($oLinha, array($oLabe5, $oLabe6));
        }

        if ($oDados->sitproj == 'Reprovado') {
            $oLabe5 = new campo('Situação: ' . $oDados->sitproj, 'sitproj', Campo::TIPO_LABEL, 3);
            $oLabe6 = new Campo('Data reprov: ' . $oDados->dtareprovproj, 'dtsitproj', Campo::TIPO_LABEL, 5);
            $oLabe7 = new campo('Hora: ' . $oDados->horareprovproj, 'hora', Campo::TIPO_LABEL, 4);
            $oLabe8 = new campo('Usuário: ' . $oDados->userreprovproj, 'userreprovproj', Campo::TIPO_LABEL, 5);
            $oLinha = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oField1->addCampos($oLinha, array($oLabe5, $oLabe6, $oLabe7), $oLabe8);
        }

        $oField2 = new FieldSet('Situação cliente');
        if ($oDados->sitcliente == null) {
            $oLabe10 = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oLabe11 = new campo('Situação: ' . $oDados->sitcliente, 'sitcliente', Campo::TIPO_LABEL, 3);
            $oLabe12 = new Campo('Não encaminhado para o cliente', 'cli', Campo::TIPO_LABEL, 8);
            $oField2->addCampos($oLabe10, array($oLabe11, $oLabe12));
        }
        if ($oDados->sitcliente == 'Env.Proposta') {
            $oLabe10 = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oLabe11 = new campo('Situação: ' . $oDados->sitcliente, 'sitcliente', Campo::TIPO_LABEL, 4);
            $oLabe12 = new Campo('Data env: ' . $oDados->dtenvprop, 'dtenvprop', Campo::TIPO_LABEL, 4);
            $oLabe13 = new campo('Hora: ' . $oDados->horaenvprop, 'horaenvprop', Campo::TIPO_LABEL, 4);
            $oLabe14 = new campo('Usuário: ' . $oDados->userenvprop, 'userenvprop', Campo::TIPO_LABEL, 5);

            $oField2->addCampos($oLabe10, array($oLabe11, $oLabe12, $oLabe13), $oLabe14);
        }

        if ($oDados->sitcliente == 'Reprovado') {
            $oLabe10 = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oLabe11 = new campo('Situação: ' . $oDados->sitcliente, 'sitcliente', Campo::TIPO_LABEL, 4);
            $oLabe12 = new Campo('Data rep: ' . $oDados->dtareprovcli, 'dtareprovcli', Campo::TIPO_LABEL, 4);
            $oLabe13 = new campo('Hora: ' . $oDados->horareprovcli, 'horareprovcli', Campo::TIPO_LABEL, 4);
            $oLabe14 = new campo('Usuário: ' . $oDados->userreprovcli, 'userreprovcli', Campo::TIPO_LABEL, 5);

            $oField2->addCampos($oLabe10, array($oLabe11, $oLabe12, $oLabe13), $oLabe14);
        }
        if ($oDados->sitcliente == 'Aprovado') {
            $oLabe10 = new campo('', '', Campo::TIPO_LINHABRANCO, 12);
            $oLabe11 = new campo('Situação: ' . $oDados->sitcliente, 'sitcliente', Campo::TIPO_LABEL, 4);
            $oLabe12 = new Campo('Data env: ' . $oDados->dtaprovcli, 'dtenvprop', Campo::TIPO_LABEL, 4);
            $oLabe13 = new campo('Hora: ' . $oDados->horaprovcli, 'horaenvprop', Campo::TIPO_LABEL, 4);
            $oLabe14 = new campo('Usuário: ' . $oDados->useraprovcli, 'userenvprop', Campo::TIPO_LABEL, 5);

            $oField2->addCampos($oLabe10, array($oLabe11, $oLabe12, $oLabe13), $oLabe14);
        }


        $this->setBTela(true);

        //botão inserir os dados




        $this->addCampos(array($oLabe1, $oLabe2, $oLabe3), $oField1, $oField2);
    }

    public function criaModal4() {
        parent::criaModal();

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 4);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBOculto(true);
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 2);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBOculto(true);

        $oObsAprovCli = new campo('Observação de encerramento', 'encobs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsAprovCli->setILinhasTextArea(5);

        $this->setBTela(true);

        //botão inserir os dados
        $oBtnInserir = new Campo('Encerrar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        // $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","encerraEntrada","' . $this->getTela()->getId() . '-form,' . $aDados['id'] . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);





        $this->addCampos($oObsAprovCli, array($oBtnInserir, $oFilcgc, $oNr));
    }

    //tela de reprovaçao de projeto
    public function criaModalRepVenda() {
        parent::criaModal();

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 4);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBOculto(true);
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 2);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBOculto(true);

        $oObsAprovCli = new campo('Observação', 'obreprovendas', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsAprovCli->setILinhasTextArea(5);

        $this->setBTela(true);

        //botão inserir os dados
        $oBtnInserir = new Campo('Reprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        // $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","ReprovaEntrada","' . $this->getTela()->getId() . '-form,' . $aDados['id'] . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos($oObsAprovCli, array($oBtnInserir, $oFilcgc, $oNr));
    }

    /**
     * Função para cria a tela modal para vizualizar a proposta
     */
    public function criaModalProposta() {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oEmpcod = new Campo('Cliente', 'empcod', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpcod->setSValor($oDados->empcod);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new campo('...', 'empdes', Campo::TIPO_TEXTO, 9, 9, 12, 12);
        $oEmpdes->setSValor($oDados->empdes);
        $oEmpdes->setBCampoBloqueado(true);

        $oProduto = new campo('Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 12, 12, 12, 12);
        $oProduto->setSValor($oDados->desc_novo_prod);
        $oProduto->setBCampoBloqueado(true);

        $oAcaba = new campo('Acabamento', 'acabamento', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oAcaba->setSValor($oDados->acabamento);
        $oAcaba->setBCampoBloqueado(true);

        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQuant->setSValor(number_format($oDados->quant_pc, 2, ',', '.'));
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);

        $oLoteMin = new campo('Lote Mínimo', 'lotemin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oLoteMin->setSValor(number_format($oDados->lotemin, 2, ',', '.'));
        $oLoteMin->setBCampoBloqueado(true);

        $oPesoCt = new campo('Peso Ct', 'pesoct', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPesoCt->setSValor(number_format($oDados->pesoct, 2, ',', '.'));
        $oPesoCt->setBCampoBloqueado(true);

        $oPreco = new Campo('Preço R$:', 'precofinal', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPreco->setSValor(number_format($oDados->precofinal, 2, ',', '.'));
        $oPreco->setSCorFundo(Campo::FUNDO_VERDE);
        $oPreco->setBCampoBloqueado(true);

        $oPrazo = new Campo('Prazo entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oPrazo->setSValor($oDados->prazoentregautil);
        $oPrazo->setBCampoBloqueado(true);

        $oDataEntrega = new Campo('Dt. Entrega Antigo', 'prazoentrega', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oDataEntrega->setSValor($oDados->prazoentrega);
        $oDataEntrega->setBCampoBloqueado(true);

        $oData = new Campo('Aprovação Cliente', 'dtaprovcli', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oData->setSValor($oDados->dtaprovcli);
        $oData->setBCampoBloqueado(true);

        $oObsVenda = new campo('Obs. Vendas/Motivo Reprovação', 'fin_obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $sValor = $oDados->fin_obs;
        $sValor = str_replace("\n", " ", $sValor);
        $sValor = str_replace("'", "\'", $sValor);
        $sValor = str_replace("\r", "", $sValor);

        $oObsVenda->setSValor($sValor);
        $oObsVenda->setBCampoBloqueado(true);
        $oObsVenda->setILinhasTextArea(3);

        $oObsProj = new Campo('Obs. Projetos/Motivo Reprovação', 'obs_proj', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $sValorProj = $oDados->obs_proj;
        $sValorProj = str_replace("\n", " ", $sValorProj);
        $sValorProj = str_replace("'", "\'", $sValorProj);
        $sValorProj = str_replace("\r", "", $sValorProj);

        $oObsProj->setSValor($sValorProj);
        $oObsProj->setBCampoBloqueado(true);
        $oObsProj->setILinhasTextArea(3);

        $oObsReprova = new Campo('Obs. Cliente/Motivo Reprovação', 'obsreprovcli', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $sValorReprova = $oDados->obsreprovcli;
        $sValorReprova = str_replace("\n", " ", $sValorReprova);
        $sValorReprova = str_replace("'", "\'", $sValorReprova);
        $sValorReprova = str_replace("\r", "", $sValorReprova);

        $oObsReprova->setSValor($sValorReprova);
        $oObsReprova->setBCampoBloqueado(TRUE);
        $oObsReprova->setILinhasTextArea(3);

        $this->setBTela(true);

        $this->addCampos(array($oEmpcod, $oEmpdes), $oProduto, array($oAcaba, $oQuant, $oLoteMin, $oPesoCt, $oPreco), array($oData, $oPrazo, $oDataEntrega), $oObsProj, $oObsVenda, $oObsReprova);
    }

}
