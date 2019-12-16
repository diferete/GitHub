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

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNome = new CampoConsulta('Usuário', 'lidercausa');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oFilcgc = new CampoConsulta('Empresa Padrão', 'filcgc');
        $oCodProbl = new CampoConsulta('Cod Problema', 'codprobl');
        $otipornc = new CampoConsulta('Tipo', 'tipornc');
        $oEmpDes = new CampoConsulta('Empresa', 'Pessoa.empdes');
        $oCodProd = new CampoConsulta('Cód.Prod.', 'codprod');
        $oDescprod = new CampoConsulta('Descrição', 'descprod');


        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        //$oSit->setBComparacaoColuna(true);

        $oDrop1 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar RNC', 'MET_QUAL_Rnc', 'acaoMostraRelEspecifico', 'TODOS', false, 'documentoRNC', false, '', false, '', true);

        $oDrop2 = new Dropdown('Ações', Dropdown::TIPO_SUCESSO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Finalizar', 'MET_QUAL_Rnc', 'acaoFinalizaRnc', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Cancelar', 'MET_QUAL_Rnc', 'acaoCancelaRnc', '', false, '');
        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO);
        $oFilCnpj = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO);
        $oFiltroDescP = new Filtro($oDescprod, Filtro::CAMPO_TEXTO);
        $oFilCodProd = new Filtro($oCodProd, Filtro::CAMPO_TEXTO);


        $this->addFiltro($oFiltroNr, $oFilCnpj, $oFilCodProd, $oFiltroDescP);
        $this->addDropdown($oDrop1, $oDrop2);
        $this->addCampos($oNr, $oFilcgc, $oEmpDes, $oNome, $otipornc, $oSit, $oDatabert, $oCodProbl, $oCodProd, $oDescprod);
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

        $ocodsetor = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $ocodsetor->setApenasTela(true);
        $ocodsetor->setBOculto(true);

        $odescset01 = new Campo('Setor Detectou ', 'descset01', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $odescset01->setSIdPk($ocodsetor->getId());
        $odescset01->setClasseBusca('Setor');
        $odescset01->addCampoBusca('codsetor', '', '');
        $odescset01->addCampoBusca('descsetor', '', '');
        $odescset01->setSIdTela($this->getTela()->getid());
        $ocodsetor->setClasseBusca('Setor');
        $ocodsetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $ocodsetor->addCampoBusca('descsetor', $odescset01->getId(), $this->getTela()->getId());
        //busca por funcionario 

        $oCodUsuario = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodUsuario->setApenasTela(true);
        $oCodUsuario->setBOculto(true);

        $oPessoa = new Campo('Usuário que Detectou ', 'lidercausa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12); //lidecausa
        $oPessoa->setSIdPk($oCodUsuario->getId());
        $oPessoa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoa->addCampoBusca('numcad', '', '');
        $oPessoa->addCampoBusca('nomfun', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oCodUsuario->setClasseBusca('MET_CAD_Funcionarios');
        $oCodUsuario->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCodUsuario->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());
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

        $ohoraini = new Campo('Hora', 'horaini', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ohoraini->setSValor(date('H:i:s'));
        $ohoraini->setBCampoBloqueado(true);

        $oDivisor3 = new Campo(' Dados do Problema', 'dadorec', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);
        //*codprod
        /* $oCodProd = new Campo('Cód.Prod.', 'codprod', Campo::TIPO_TEXTO, 1, 1, 12, 12);

          $oProdDes = new campo('Desc.Prod', 'descprod', Campo::TIPO_TEXTO, 3, 3, 12, 12); */

        //campo código do produto
        $oCodProd = new Campo('Codigo', 'codprod', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodProd->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodProd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodProd->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '4');


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


        $oCodmat = new Campo('Cód.Mat.Prima', 'codmat', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oProdDes2 = new campo('Desc.Mat.Prima', 'prodes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oProdDes2->setApenasTela(true);

        $oCodProbl = new campo('Cód.Problema', 'codprobl', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 1, 1);
        $oCodProbl->setSValor('1');
        $oCodProblDes = new campo('Desc. Problema', 'MET_QUAL_Prob_Rnc.descprobl', Campo::TIPO_BUSCADOBANCO, 4, 4, 4, 4);

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

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $olote = new Campo('Lote', 'lote', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oqtlote = new Campo('Qt.Lote', 'qtlote', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oqtloternc = new Campo('Qt.Defeito', 'qtloternc', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oLn = new Campo('', 'linha1', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLn->setApenasTela(true);

        $oturno01 = new Campo('Turno', 'turno01', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oturno01->addItemSelect('Geral', 'Geral');
        $oturno01->addItemSelect('1.ºTurno', '1.ºTurno');
        $oturno01->addItemSelect('2.ºTurno', '2.ºTurno');

        $otipornc = new Campo('Tipo Rnc', 'tipornc', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $otipornc->addItemSelect('Processo', 'Processo');
        $otipornc->addItemSelect('Fornecedor', 'Fornecedor');

        //fornecedor2
        $oCnpj2 = new Campo('CNPJ', 'CNPJ', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCnpj2->setApenasTela(true);
        $oCnpj2->setBOculto(true);

        $oEmpresa = new Campo('Fornecedor', 'fornec', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oEmpresa->setSIdPk($oCnpj2->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');

        $oCnpj2->setClasseBusca('Pessoa');
        $oCnpj2->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj2->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());
        //
        $odescrnc = new Campo('Descrição da não conformidade', 'descrnc', Campo::TIPO_TEXTAREA, 7, 7, 12, 12);
        $odescrnc->setILinhasTextArea(3);

        $oDivisor2 = new Campo('Dados quem detectou ', 'dadorec1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oDivisor1 = new Campo('Origem da não Conformidade', 'dadorec2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $oUsercausa = new Campo('...', 'numcad', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUsercausa->setApenasTela(true);
        $oUsercausa->setBOculto(true);

        $oPessoacausa = new Campo('Quem causou', 'nomfun', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoacausa->setSIdPk($oUsercausa->getId());
        $oPessoacausa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoacausa->addCampoBusca('numcad', '', '');
        $oPessoacausa->addCampoBusca('nomfun', '', '');
        $oPessoacausa->setSIdTela($this->getTela()->getid());
        $oPessoacausa->setApenasTela(true);

        $oUsercausa->setClasseBusca('MET_CAD_Funcionarios');
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

        $ocodsetor2 = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $ocodsetor2->setApenasTela(true);
        $ocodsetor2->setBOculto(true);

        $odescset02 = new Campo('Setor Causou ', 'descset02', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $odescset02->setSIdPk($ocodsetor->getId());
        $odescset02->setClasseBusca('Setor');
        $odescset02->addCampoBusca('codsetor', '', '');
        $odescset02->addCampoBusca('descsetor', '', '');
        $odescset02->setSIdTela($this->getTela()->getid());
        $ocodsetor2->setClasseBusca('Setor');
        $ocodsetor2->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $ocodsetor2->addCampoBusca('descsetor', $odescset01->getId(), $this->getTela()->getId());

        $oturno02 = new Campo('Turno', 'turno02', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oturno02->addItemSelect('Geral', 'Geral');
        $oturno02->addItemSelect('1.ºTurno', '1.ºTurno');
        $oturno02->addItemSelect('2.ºTurno', '2.ºTurno');
        $oturno02->addItemSelect('1º e 2º-Turno', '1º e 2º-Turno');
        $oturno02->addItemSelect('1ºTurno e Geral ', '1ºTurno e Geral');
        $oturno02->addItemSelect('2ºTurno e Geral', '2ºTurno e Geral');

        $oRespcausa = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oRespcausa->setApenasTela(true);
        $oRespcausa->setBOculto(true);

        $oPessoaresp = new Campo('Responsável pelo Setor', 'respcausa', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12); //respcausa
        $oPessoaresp->setSIdPk($oCodUsuario->getId());
        $oPessoaresp->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoaresp->addCampoBusca('numcad', '', '');
        $oPessoaresp->addCampoBusca('nomfun', '', '');
        $oPessoaresp->setSIdTela($this->getTela()->getid());

        $oRespcausa->setClasseBusca('MET_CAD_Funcionarios');
        $oRespcausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oRespcausa->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());

        $oDivisor4 = new Campo('Causa da não Conformidade', 'dadorec3', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor4->setApenasTela(true);
        //causa rnc
        $ocausarnc = new Campo('Causa', 'causarnc', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $ocausarnc->addItemSelect('Produto Final', 'Produto Final');
        $ocausarnc->addItemSelect('Sistema', 'Sistema');
        $ocausarnc->addItemSelect('Material Errado', 'Material Errado');

        $odesccausa = new Campo('Descrição da Causa', 'desccausa', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $odesccausa->setILinhasTextArea(3);
        //decisao da correção    
        $oDivisor5 = new Campo('Decisão de Correção', 'dadorec10', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor5->setApenasTela(true);

        $oDecisao = new Campo('Decisão', 'decisaornc', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oDecisao->addItemSelect('Reclassificar', 'Reclassificar');
        $oDecisao->addItemSelect('Devolver ao Fonercedor', 'Devolver ao Fonercedor');
        $oDecisao->addItemSelect('Sucatear', 'Sucatear');
        $oDecisao->addItemSelect('Retrabalhar e Reinspecionar', 'Retrabalhar e Reinspecionar');
        $oDecisao->addItemSelect('Aprovar com Desvio', 'Aprovar com Desvio');
        $oDecisaornc = new Campo('Decisão Obs', 'descdescirnc', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDecisaornc->setILinhasTextArea(3);

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo4 = new Campo('Anexo4', 'anexo4', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        //seta ids uploads para enviar no request para limpar


        $oCorrida02 = new Campo('Corrida / Material', 'corrida', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCorrida02->addItemSelect('AÇO SAE 1004', 'AÇO SAE 1004');
        $oCorrida02->addItemSelect('AÇO SAE 1006', 'AÇO SAE 1006');
        $oCorrida02->addItemSelect('AÇO SAE PA03', 'AÇO SAE PA03');
        $oCorrida02->addItemSelect('AÇO SAE 10B22/PL22', 'AÇO SAE 10B22/PL22');
        $oCorrida02->addItemSelect('AÇO SAE 10B30/PL30', 'AÇO SAE 10B30/PL30	');
        $oCorrida02->addItemSelect('AÇO SAE 10B21', 'AÇO SAE 10B21');
        $oCorrida02->addItemSelect('AÇO SAE 1018', 'AÇO SAE 1018');
        $oCorrida02->addItemSelect('AÇO SAE PL41', 'AÇO SAE PL41');
        $oCorrida02->addItemSelect('AÇO SAE PL45', 'AÇO SAE PL45');
        $oCorrida02->addItemSelect('AÇO SAE 5135', 'AÇO SAE 5135');
        $oCorrida02->addItemSelect('AÇO SAE 1045', 'AÇO SAE 1045');
        $oCorrida02->addItemSelect('AÇO SAE 4140', 'AÇO SAE 4140');
        $oCorrida02->addItemSelect('VF 800', '  VF 800');
        $oCorrida02->addItemSelect('M2', 'M2');
        $oCorrida02->addItemSelect('H13', 'H13');
        $oCorrida02->addItemSelect('AÇO SAE 1015', '  AÇO SAE 1015');
        $oCorrida02->addItemSelect('AÇO SAE 1018', 'AÇO SAE 1018');


        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId() . ',' . $oAnexo4->getId());

        // $oFieldAnexo->addCampos(array($oAnexo1, $oAnexo2));

        $oOp->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadosOp","' . $oCodProd->getId() . ',' .
                $oProdDes->getId() . '");');

        $oCodmat->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadoscodmat","' . $oProdDes2->getId() . '");');

        $oTabProbl->addCampos(array($oCodProbl, $oCodProblDes, $oCorrida02), $odescrnc, $oSituaca, array($ocodsetor, $odescset01, $oturno01, $oCodUsuario, $oPessoa), array($oCnpj2, $oEmpresa));
        /* $oTabMatP->addCampos(array($oCodmat, $oProdDes2), array($oCodCorrida, $oCorrida, $oBotConf), $oCampoCorrida); */
        $oTabcausa->addCampos(array($oUsercausa, $oPessoacausa, $oBotConf), $oCampoCoaboradores, array($odescset02, $oPessoaresp, $oturno02, $ocodsetor2), $odesccausa);
        $oTabdesc->addCampos($oDecisao, $oDecisaornc);
        $oTabAnexo->addCampos(array($oAnexo1, $oAnexo2));
        $oTab->addItems($oTabProbl, $oTabcausa, $oTabdesc, $oTabAnexo);

        $this->addCampos(array($oNr, $oFilcgc, $oUsunome, $oDatabert, $ohoraini), array($otipornc, $oOp, $oCodProd, $oProdDes, $olote, $oqtlote, $oqtloternc), $oLn, $oTab);
    }

}
