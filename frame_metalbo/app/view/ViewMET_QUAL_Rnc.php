<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_Rnc extends View {

    public function __construct() {
        parent::__construct();
        $this->setTitulo('RNC');
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaDropdown(true);
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNome = new CampoConsulta('Usuário', 'userini');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oFilcgc = new CampoConsulta('Empresa Padrão', 'filcgc');
        $oCodProbl = new CampoConsulta('Cod Problema', 'codprobl');
        $oTipoRnc = new CampoConsulta('Tipo', 'tipornc');
        $oNomeFornecedor = new CampoConsulta('Fornecedor', 'fornec');
        //$oEmpDes = new CampoConsulta('Empresa', 'Pessoa.empdes');
        $oCodProd = new CampoConsulta('Cód.Prod.', 'codprod');
        $oDescprod = new CampoConsulta('Descrição', 'descprod');
        $oUserCausa = new CampoConsulta('Causadores', 'usercausa');

        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');
        $oSit->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, '');
        //$oSit->setBComparacaoColuna(true);

        $oDrop1 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar RNC', 'MET_QUAL_Rnc', 'acaoMostraRelEspecifico', 'TODOS', false, 'documentoRNC', false, '', false, '', true, false);

        $oDrop2 = new Dropdown('Ações', Dropdown::TIPO_SUCESSO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Finalizar', 'MET_QUAL_Rnc', 'acaoFinalizaRnc', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Cancelar', 'MET_QUAL_Rnc', 'acaoCancelaRnc', '', false, '', false, '', false, '', false, false);

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilCodProbl = new Filtro($oCodProbl, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFilFornecedor = new Filtro($oNomeFornecedor, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFiltroDescP = new Filtro($oDescprod, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $oFilCodProd = new Filtro($oCodProd, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFilCausadores = new Filtro($oUserCausa, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);

        $oFilTipoRnc = new Filtro($oTipoRnc, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilTipoRnc->addItemSelect('', 'Tipo - Todos');
        $oFilTipoRnc->addItemSelect('Interno', 'Tipo - Interno');
        $oFilTipoRnc->addItemSelect('Externo', 'Tipo - Externo');
        $oFilTipoRnc->setSLabel('');

        $oFilDatabert = new Filtro($oDatabert, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);


        $this->addFiltro($oFiltroNr, $oFilCodProd, $oFilCodProbl, $oFilFornecedor, $oFiltroDescP, $oFilCausadores, $oFilTipoRnc, $oFilDatabert);
        $this->addDropdown($oDrop1, $oDrop2);
        $this->addCampos($oNr, $oFilcgc, $oNome, $oTipoRnc, $oNomeFornecedor, $oSit, $oDatabert, $oCodProbl, $oCodProd, $oDescprod, $oUserCausa);
    }

    public function criaTela() {
        parent::criaTela();

        $oTab = new TabPanel();
        $oTabProbl = new AbaTabPanel('Dados Problema');
        $oTabProbl->setBActive(true);
        $oTabMatP = new AbaTabPanel('Dados Materia Prima');
        $oTabcausa = new AbaTabPanel('Causa da Rnc');
        $oTabdesc = new AbaTabPanel('Decisão Final');
        $oTabAnexo = new AbaTabPanel('Anexos');
        $this->addLayoutPadrao('Aba');


        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, true);
        $oNr->setBCampoBloqueado(true);
        //*busca por setor
        $oUsunome = new campo('Usuário', 'userini', Campo::TIPO_TEXTO, 2, 2, 12, 12); //userini
        $oUsunome->setSValor($_SESSION['nome']);
        $oUsunome->setBCampoBloqueado(true);

        $oCodSetorDetectou = new Campo('Cód.Setor', 'cod_set01', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oDescSetorDetectou = new Campo('Setor Detectou ', 'descset01', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetorDetectou->setSIdPk($oCodSetorDetectou->getId());
        $oDescSetorDetectou->setClasseBusca('Setor');
        $oDescSetorDetectou->addCampoBusca('codsetor', '', '');
        $oDescSetorDetectou->addCampoBusca('descsetor', '', '');
        $oDescSetorDetectou->setSIdTela($this->getTela()->getid());
        $oDescSetorDetectou->setBCampoBloqueado(true);

        $oCodSetorDetectou->setClasseBusca('Setor');
        $oCodSetorDetectou->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetorDetectou->addCampoBusca('descsetor', $oDescSetorDetectou->getId(), $this->getTela()->getId());
        //busca por funcionario 

        $oCodFuncDetectou = new Campo('Crachá', 'crachadetectou', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oNomeFuncDetectou = new Campo('Usuário que Detectou', 'lidercausa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12); //lidecausa
        $oNomeFuncDetectou->setSIdPk($oCodFuncDetectou->getId());
        $oNomeFuncDetectou->setClasseBusca('MET_RH_Colaboradores');
        $oNomeFuncDetectou->addCampoBusca('numcad', '', '');
        $oNomeFuncDetectou->addCampoBusca('nomfun', '', '');
        $oNomeFuncDetectou->setSIdTela($this->getTela()->getid());
        $oNomeFuncDetectou->setBCampoBloqueado(true);

        $oCodFuncDetectou->setClasseBusca('MET_RH_Colaboradores');
        $oCodFuncDetectou->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCodFuncDetectou->addCampoBusca('nomfun', $oNomeFuncDetectou->getId(), $this->getTela()->getId());
        //empresa
        $oFilcgc = new Campo('Empresa Padrão', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());
        //**
        $oDatabert = new Campo('Data do Abert', 'databert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDatabert->setSValor(date('d/m/Y'));
        $oDatabert->setBCampoBloqueado(true);

        $oHoraIni = new Campo('Hora', 'horaini', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraIni->setSValor(date('H:i:s'));
        $oHoraIni->setBCampoBloqueado(true);

        $oDivisor3 = new Campo(' Dados do Problema', 'dadorec', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);
        //*codprod
        /* $oCodProd = new Campo('Cód.Prod.', 'codprod', Campo::TIPO_TEXTO, 1, 1, 12, 12);

          $oProdDes = new campo('Desc.Prod', 'descprod', Campo::TIPO_TEXTO, 3, 3, 12, 12); */

        //campo código do produto
        $oCodProd = new Campo('Codigo', 'codprod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodProd->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodProd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodProd->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3');


        //campo descrição do produto adicionando o campo de busca
        $oProdDes = new Campo('Produto', 'descprod', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oProdDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdDes->setSIdPk($oCodProd->getId());
        $oProdDes->setClasseBusca('MET_PROD_Geral');
        $oProdDes->addCampoBusca('procod', '', '');
        $oProdDes->addCampoBusca('prodes', '', '');
        $oProdDes->setSIdTela($this->getTela()->getid());

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodProd->setClasseBusca('MET_PROD_Geral');
        $oCodProd->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodProd->addCampoBusca('prodes', $oProdDes->getId(), $this->getTela()->getId());


        $oCodmat = new Campo('Cód.Mat.Prima', 'codmat', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oProdDes2 = new campo('Desc.Mat.Prima', 'prodes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oProdDes2->setApenasTela(true);

        $oCodProbl = new campo('Cód.Problema', 'codprobl', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodProbl->setSValor('1');
        $oCodProblDes = new campo('Desc. Problema', 'MET_QUAL_Prob_Rnc.descprobl', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);

        $oCodProblDes->setSIdPk($oCodProbl->getId());
        $oCodProblDes->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProblDes->setSValor('Material Errado');
        $oCodProblDes->addCampoBusca('codprobl', '', '');
        $oCodProblDes->addCampoBusca('descprobl', '', '');
        $oCodProblDes->setSIdTela($this->getTela()->getid());

        $oCodProbl->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProbl->setSCampoRetorno('codprobl', $this->getTela()->getId());
        $oCodProbl->addCampoBusca('descprobl', $oCodProblDes->getId(), $this->getTela()->getId());

        $oSituaca = new Campo('', 'sit', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setSValor('Aguardando');
        $oSituaca->setBOculto(true);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oLote = new Campo('Lote', 'lote', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oQtLote = new Campo('Qt.Lote', 'qtlote', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oQtLoteRnc = new Campo('Qt.Defeito', 'qtloternc', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oLn = new Campo('', 'linha1', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLn->setApenasTela(true);

        $oTurno01 = new Campo('Turno', 'turno01', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTurno01->addItemSelect('Geral', 'Geral');
        $oTurno01->addItemSelect('1.ºTurno', '1.ºTurno');
        $oTurno01->addItemSelect('2.ºTurno', '2.ºTurno');

        $oTipoRnc = new Campo('Tipo Rnc', 'tipornc', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTipoRnc->addItemSelect('Interno', 'Interno');
        $oTipoRnc->addItemSelect('Externo', 'Externo');
        $oTipoRnc->addItemSelect('Processo', 'Processo');
        $oTipoRnc->addItemSelect('Fornecedor', 'Fornecedor');

        //fornecedor2
        $oCnpjFornecedor = new Campo('CNPJ', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oNomeFornecedor = new Campo('Fornecedor', 'fornec', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oNomeFornecedor->setSIdPk($oCnpjFornecedor->getId());
        $oNomeFornecedor->setClasseBusca('Pessoa');
        $oNomeFornecedor->addCampoBusca('empcod', '', '');
        $oNomeFornecedor->addCampoBusca('empdes', '', '');
        $oNomeFornecedor->setBCampoBloqueado(true);

        $oCnpjFornecedor->setClasseBusca('Pessoa');
        $oCnpjFornecedor->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpjFornecedor->addCampoBusca('empdes', $oNomeFornecedor->getId(), $this->getTela()->getId());
        //
        $oDescRnc = new Campo('Descrição da não conformidade', 'descrnc', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oDescRnc->setILinhasTextArea(3);

        $oDivisor2 = new Campo('Dados quem detectou ', 'dadorec1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oDivisor1 = new Campo('Origem da não Conformidade', 'dadorec2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $oUsercausa = new Campo('Crachá', 'crachacausou', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUsercausa->setApenasTela(true);
        $oUsercausa->setBOculto(true);

        $oPessoacausa = new Campo('Quem causou', 'nomfun', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoacausa->setSIdPk($oUsercausa->getId());
        $oPessoacausa->setClasseBusca('MET_RH_Colaboradores');
        $oPessoacausa->addCampoBusca('numcad', '', '');
        $oPessoacausa->addCampoBusca('nomfun', '', '');
        $oPessoacausa->setSIdTela($this->getTela()->getid());
        $oPessoacausa->setApenasTela(true);

        $oUsercausa->setClasseBusca('MET_RH_Colaboradores');
        $oUsercausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oUsercausa->addCampoBusca('nomfun', $oPessoacausa->getId(), $this->getTela()->getId());

        $oCampoCoaboradores = new Campo('Colaboradores', 'usercausa', Campo::TIPO_TAGS, 4, 4, 12, 12); //usercausa

        $oBotConf = new Campo('Adicionar', 'botao', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $sAcao = 'addColaborador($("#' . $oPessoacausa->getId() . '").val(),'
                . '"' . $oPessoacausa->getId() . '",'
                . '"' . $oCampoCoaboradores->getId() . '",'
                . '"' . $this->getController() . '")';
        $oBotConf->getOBotao()->addAcao($sAcao);
        $oBotConf->setApenasTela(true);
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oCodSetorCausou = new Campo('Cód.Setor', 'cod_set02', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oDescSetorCausou = new Campo('Setor Causou ', 'descset02', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetorCausou->setSIdPk($oCodSetorCausou->getId());
        $oDescSetorCausou->setClasseBusca('Setor');
        $oDescSetorCausou->addCampoBusca('codsetor', '', '');
        $oDescSetorCausou->addCampoBusca('descsetor', '', '');
        $oDescSetorCausou->setSIdTela($this->getTela()->getid());
        $oDescSetorCausou->setBCampoBloqueado(true);

        $oCodSetorCausou->setClasseBusca('Setor');
        $oCodSetorCausou->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetorCausou->addCampoBusca('descsetor', $oDescSetorCausou->getId(), $this->getTela()->getId());

        $oTurno02 = new Campo('Turno', 'turno02', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTurno02->addItemSelect('Geral', 'Geral');
        $oTurno02->addItemSelect('1.ºTurno', '1.ºTurno');
        $oTurno02->addItemSelect('2.ºTurno', '2.ºTurno');
        $oTurno02->addItemSelect('1º e 2º-Turno', '1º e 2º-Turno');
        $oTurno02->addItemSelect('1ºTurno e Geral ', '1ºTurno e Geral');
        $oTurno02->addItemSelect('2ºTurno e Geral', '2ºTurno e Geral');

        $oCodRespCausa = new Campo('Crachá', 'cracharesponsavel', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oNomePessoaRespCausa = new Campo('Responsável pelo Setor', 'respcausa', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12); //respcausa
        $oNomePessoaRespCausa->setSIdPk($oCodRespCausa->getId());
        $oNomePessoaRespCausa->setClasseBusca('MET_RH_Colaboradores');
        $oNomePessoaRespCausa->addCampoBusca('numcad', '', '');
        $oNomePessoaRespCausa->addCampoBusca('nomfun', '', '');
        $oNomePessoaRespCausa->setSIdTela($this->getTela()->getid());
        $oNomePessoaRespCausa->setBCampoBloqueado(true);

        $oCodRespCausa->setClasseBusca('MET_RH_Colaboradores');
        $oCodRespCausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCodRespCausa->addCampoBusca('nomfun', $oNomePessoaRespCausa->getId(), $this->getTela()->getId());

        $oDivisor4 = new Campo('Causa da não Conformidade', 'dadorec3', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor4->setApenasTela(true);
        //causa rnc
        $oCausaRnc = new Campo('Causa', 'causarnc', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCausaRnc->addItemSelect('Produto Final', 'Produto Final');
        $oCausaRnc->addItemSelect('Sistema', 'Sistema');
        $oCausaRnc->addItemSelect('Material Errado', 'Material Errado');

        $oDescCausa = new Campo('Descrição da Causa', 'desccausa', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescCausa->setILinhasTextArea(3);
        //decisao da correção    
        $oDivisor5 = new Campo('Decisão de Correção', 'dadorec10', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor5->setApenasTela(true);

        $oDecisao = new Campo('Decisão', 'decisaornc', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oDecisao->addItemSelect('Reclassificar', 'Reclassificar');
        $oDecisao->addItemSelect('Devolver ao Fonercedor', 'Devolver ao Fonercedor');
        $oDecisao->addItemSelect('Sucatear', 'Sucatear');
        $oDecisao->addItemSelect('Retrabalhar e Reinspecionar', 'Retrabalhar e Reinspecionar');
        $oDecisao->addItemSelect('Aprovar com Desvio', 'Aprovar com Desvio');
        $oDecisao->addItemSelect('Outros', 'Outros');

        $oDecisaornc = new Campo('Decisão Obs', 'descdescirnc', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDecisaornc->setILinhasTextArea(3);

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo4 = new Campo('Anexo4', 'anexo4', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        //seta ids uploads para enviar no request para limpar
        //////////////////////

        $oCodCorrida = new Campo('Cod.Material', 'cod_corrida', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oCorrida = new Campo('Material ', 'corrida', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oCorrida->setSIdPk($oCodCorrida->getId());
        $oCorrida->setClasseBusca('MET_QUAL_RncMaterial');
        $oCorrida->addCampoBusca('cod', '', '');
        $oCorrida->addCampoBusca('corrida', '', '');
        $oCorrida->setSIdTela($this->getTela()->getid());
        $oCorrida->setBCampoBloqueado(true);

        $oCodCorrida->setClasseBusca('MET_QUAL_RncMaterial');
        $oCodCorrida->setSCampoRetorno('cod', $this->getTela()->getId());
        $oCodCorrida->addCampoBusca('corrida', $oCorrida->getId(), $this->getTela()->getId());

//        $oCorrida02 = new Campo('Material', 'corrida', Campo::TIPO_SELECT, 2, 2, 12, 12);
//        $oCorrida02->addItemSelect('AÇO SAE 1004', 'AÇO SAE 1004');
//        $oCorrida02->addItemSelect('AÇO SAE 1006', 'AÇO SAE 1006');
//        $oCorrida02->addItemSelect('AÇO SAE PA03', 'AÇO SAE PA03');
//        $oCorrida02->addItemSelect('AÇO SAE 10B22/PL22', 'AÇO SAE 10B22/PL22');
//        $oCorrida02->addItemSelect('AÇO SAE 10B30/PL30', 'AÇO SAE 10B30/PL30	');
//        $oCorrida02->addItemSelect('AÇO SAE 10B21', 'AÇO SAE 10B21');
//        $oCorrida02->addItemSelect('AÇO SAE 1018', 'AÇO SAE 1018');
//        $oCorrida02->addItemSelect('AÇO SAE PL41', 'AÇO SAE PL41');
//        $oCorrida02->addItemSelect('AÇO SAE PL45', 'AÇO SAE PL45');
//        $oCorrida02->addItemSelect('AÇO SAE 5135', 'AÇO SAE 5135');
//        $oCorrida02->addItemSelect('AÇO SAE 1045', 'AÇO SAE 1045');
//        $oCorrida02->addItemSelect('AÇO SAE 4140', 'AÇO SAE 4140');
//        $oCorrida02->addItemSelect('VF 800', '  VF 800');
//        $oCorrida02->addItemSelect('M2', 'M2');
//        $oCorrida02->addItemSelect('H13', 'H13');
//        $oCorrida02->addItemSelect('AÇO SAE 1015', '  AÇO SAE 1015');
//        $oCorrida02->addItemSelect('AÇO SAE 1018', 'AÇO SAE 1018');
//        $oCorrida02->addItemSelect('PA03', 'PA03');
//        $oCorrida02->addItemSelect('SAE 1004E', 'SAE 1004E');
//        $oCorrida02->addItemSelect('SAE 1004X', 'SAE 1004X');
//        $oCorrida02->addItemSelect('SAE P919', 'SAE P919');
//        $oCorrida02->addItemSelect('SAE 1006', 'SAE 1006');
//        $oCorrida02->addItemSelect('SAE 1008', 'SAE 1008');
//        $oCorrida02->addItemSelect('SAE 1010', 'SAE 1010');
//        $oCorrida02->addItemSelect('SAE 1010X', 'SAE 1010X');
//        $oCorrida02->addItemSelect('SAE 1012', 'SAE 1012');
//        $oCorrida02->addItemSelect('SAE 1015', 'SAE 1015');
//        $oCorrida02->addItemSelect('1015E/1015X', '1015E/1015X');
//        $oCorrida02->addItemSelect('SAE 1015L', 'SAE 1015L');
//        $oCorrida02->addItemSelect('SAE 1018', 'SAE 1018');
//        $oCorrida02->addItemSelect('SAE 1018X', 'SAE 1018X');
//        $oCorrida02->addItemSelect('SAE 1020', 'SAE 1020');
//        $oCorrida02->addItemSelect('SAE PZ32 1035', 'SAE PZ32 1035');
//        $oCorrida02->addItemSelect('SAE 1038', 'SAE 1038');
//        $oCorrida02->addItemSelect('1038D210', '1038D210');
//        $oCorrida02->addItemSelect('SAE 10B21', 'SAE 10B21');
//        $oCorrida02->addItemSelect('SAE 10B22', 'SAE 10B22');
//        $oCorrida02->addItemSelect('SAE PL22', 'SAE PL22');
//        $oCorrida02->addItemSelect('SAE 10B30', 'SAE 10B30');
//        $oCorrida02->addItemSelect('PL30', 'PL30');
//        $oCorrida02->addItemSelect('SAE 1045', 'SAE 1045');
//        $oCorrida02->addItemSelect('PL45', 'PL45');
//        $oCorrida02->addItemSelect('SAE 1045MOD', 'SAE 1045MOD');
//        $oCorrida02->addItemSelect('SAE 4140', 'SAE 4140');
//        $oCorrida02->addItemSelect('SAE PL41', 'SAE PL41');

        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId() . ',' . $oAnexo4->getId());

        // $oFieldAnexo->addCampos(array($oAnexo1, $oAnexo2));

        $oOp->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadosOp","' . $oCodProd->getId() . ',' .
                $oProdDes->getId() . '");');

        $oCodmat->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadoscodmat","' . $oProdDes2->getId() . '");');

        $oTabProbl->addCampos(array($oCodProbl, $oCodProblDes, $oCodCorrida, $oCorrida), $oDescRnc, $oSituaca, array($oCodSetorDetectou, $oDescSetorDetectou, $oTurno01, $oCodFuncDetectou, $oNomeFuncDetectou), array($oCnpjFornecedor, $oNomeFornecedor));
        /* $oTabMatP->addCampos(array($oCodmat, $oProdDes2), array($oCodCorrida, $oCorrida, $oBotConf), $oCampoCorrida); */
        $oTabcausa->addCampos(array($oUsercausa, $oPessoacausa, $oBotConf), $oCampoCoaboradores, array($oCodSetorCausou, $oDescSetorCausou, $oCodRespCausa, $oNomePessoaRespCausa, $oTurno02), $oDescCausa);
        $oTabdesc->addCampos($oDecisao, $oDecisaornc);
        $oTabAnexo->addCampos(array($oAnexo1, $oAnexo2));
        $oTab->addItems($oTabProbl, $oTabcausa, $oTabdesc, $oTabAnexo);

        $this->addCampos(array($oNr, $oFilcgc, $oUsunome, $oDatabert, $oHoraIni), array($oTipoRnc, $oOp, $oCodProd, $oProdDes, $oLote, $oQtLote, $oQtLoteRnc), $oLn, $oTab);
    }

    public function relQualRNC() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório Geral de Não Conformidade');
        $oField1 = new FieldSet('Relatório Geral');
        $this->setBTela(true);

        //campo código do produto
        $oCodProd = new Campo('Codigo', 'codprod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodProd->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodProd->setITamanho(Campo::TAMANHO_PEQUENO);

        //campo descrição do produto adicionando o campo de busca
        $oProdDes = new Campo('Produto', 'descprod', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oProdDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdDes->setSIdPk($oCodProd->getId());
        $oProdDes->setClasseBusca('Produto');
        $oProdDes->addCampoBusca('procod', '', '');
        $oProdDes->addCampoBusca('prodes', '', '');
        $oProdDes->setSIdTela($this->getTela()->getid());

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodProd->setClasseBusca('Produto');
        $oCodProd->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodProd->addCampoBusca('prodes', $oProdDes->getId(), $this->getTela()->getId());

        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $oCodTip = new Campo('Tipo', 'tipornc', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCodTip->addItemSelect('Todos', 'Todos');
        $oCodTip->addItemSelect('Processo', 'Processo');
        $oCodTip->addItemSelect('Fornecedor', 'Fornecedor');
        $oCodTip->addItemSelect('Interno', 'Interno');
        $oCodTip->addItemSelect('Externo', 'Externo');

        $oSit = new Campo('Situação das RNCs', 'sitmp', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSit->addItemSelect('Todos', 'Todos');
        $oSit->addItemSelect('Aguardando', 'Aguardando');
        $oSit->addItemSelect('Finalizada', 'Finalizada');

        $oTipo = new Campo('Tipo Fixador', 'tipfix', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipo->addItemSelect('Todos', 'Todos');
        $oTipo->addItemSelect('Porca', 'Porca');
        $oTipo->addItemSelect('Parafuso', 'Parafuso');
        $oTipo->addItemSelect('FioMaq', 'Fio Máquina');

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oField = new FieldSet('Relatório Causadores da RNC');
        $oField->setOculto(true);

        $oUsercausa = new Campo('...', 'numcad', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUsercausa->setApenasTela(true);
        $oUsercausa->setBOculto(true);

        $oPessoacausa = new Campo('Quem causou', 'nomfun', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoacausa->setSIdPk($oUsercausa->getId());
        $oPessoacausa->setClasseBusca('MET_RH_Colaboradores');
        $oPessoacausa->addCampoBusca('numcad', '', '');
        $oPessoacausa->addCampoBusca('nomfun', '', '');
        $oPessoacausa->setSIdTela($this->getTela()->getid());
        $oPessoacausa->setApenasTela(true);
        $oPessoacausa->addValidacao(true, string, '', 10, 200);

        $oUsercausa->setClasseBusca('MET_RH_Colaboradores');
        $oUsercausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oUsercausa->addCampoBusca('nomfun', $oPessoacausa->getId(), $this->getTela()->getId());

        $oCodSetorCausou = new Campo('Cód.Setor', 'cod_set02', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oDescSetorCausou = new Campo('Setor Causou ', 'descset02', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetorCausou->setSIdPk($oCodSetorCausou->getId());
        $oDescSetorCausou->setClasseBusca('Setor');
        $oDescSetorCausou->addCampoBusca('codsetor', '', '');
        $oDescSetorCausou->addCampoBusca('descsetor', '', '');
        $oDescSetorCausou->setSIdTela($this->getTela()->getid());

        $oCodSetorCausou->setClasseBusca('Setor');
        $oCodSetorCausou->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetorCausou->addCampoBusca('descsetor', $oDescSetorCausou->getId(), $this->getTela()->getId());


        $oCodProbl = new campo('Cód.Problema', 'codprobl', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodProblDes = new campo('Desc. Problema', 'MET_QUAL_Prob_Rnc.descprobl', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);

        $oCodProblDes->setSIdPk($oCodProbl->getId());
        $oCodProblDes->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProblDes->addCampoBusca('codprobl', '', '');
        $oCodProblDes->addCampoBusca('descprobl', '', '');
        $oCodProblDes->setSIdTela($this->getTela()->getid());

        $oCodProbl->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProbl->setSCampoRetorno('codprobl', $this->getTela()->getId());
        $oCodProbl->addCampoBusca('descprobl', $oCodProblDes->getId(), $this->getTela()->getId());

        $oFilcgc = new Campo('Cód. Empresa', 'Pessoa.empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        //$oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBFocus(true);

        $oFilDes = new campo('Empresa', 'Pessoa.empdes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('Pessoa');
        $oFilDes->addCampoBusca('empcod', '', '');
        $oFilDes->addCampoBusca('empdes', '', '');
        $oFilDes->setSIdTela($this->getTela()->getid());
        //$oFilDes->setSValor('METALBO INDUSTRIA DE FIXADORES          ');

        $oFilcgc->setClasseBusca('Pessoa');
        $oFilcgc->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('empdes', $oFilDes->getId(), $this->getTela()->getId());

        // $sCheck = new campo('Aplicar', 'func', Campo::TIPO_CHECK, 3, 3, 12, 12);

        $sSelectRelatorio = new Campo('Tipo de Relatório', 'tiprel', Campo::CAMPO_SELECTSIMPLE, 6, 8, 12, 12);
        $sSelectRelatorio->addItemSelect('1', 'COMPLETO');
        $sSelectRelatorio->addItemSelect('2', 'QUANTIDADES CONFORME SITUAÇÃO, TIPO DE FIXADOR E ORIGEM DAS RNCs');
        $sSelectRelatorio->addItemSelect('3', 'PESO NÃO CONFORME DE ACORDO COM A DECISÃO');
        $sSelectRelatorio->addItemSelect('4', 'PESO NÃO CONFORME DE ACORDO COM A DECISÃO POR SETOR');
        $sSelectRelatorio->addItemSelect('5', 'PESO DE PEÇAS NÃO CONFORMES NO PROCESSO E LOTE DEVOLVIDO');
        $sSelectRelatorio->addItemSelect('6', 'PESO DE ACORDO COM PROBLEMA');
        $sSelectRelatorio->addItemSelect('7', 'PESO DE ACORDO COM PROBLEMA POR SETOR');
        $sSelectRelatorio->addItemSelect('8', 'PESO DE ACORDO COM PROBLEMA POR FORNECEDOR');
        $sSelectRelatorio->setSValor(1);

        $oField1->addCampos($oLinha1, array($oCodProd, $oProdDes), $oLinha1, array($oCodTip, $oTipo, $oSit));
        $oField->addCampos(array($oFilcgc, $oFilDes, $oCodSetorCausou, $oDescSetorCausou), $oLinha1, array($oCodProbl, $oCodProblDes, $oUsercausa, $oPessoacausa));

        $this->addCampos($oField1, $oLinha1, $oField, $oLinha1, array($oDatainicial, $oDatafinal, $sSelectRelatorio));
    }

}
