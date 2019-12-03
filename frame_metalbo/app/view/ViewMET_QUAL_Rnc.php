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

        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        //$oSit->setBComparacaoColuna(true);

        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'RNC', 'MET_QUAL_Rnc', 'acaoMostraRelEspecifico', 'TODOS', false, 'documentoRNC', false, '', false, '', true);

        $oDrop2 = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Cancelar', 'MET_QUAL_Rnc', 'acaoCancelaRnc', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_COPIAR) . 'Finalizar', 'MET_QUAL_Rnc', 'acaoFinalizaRnc', '', false, '');
        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO);
        $oFilCnpj = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO);
        
        
        $this->addFiltro($oFiltroNr,$oFilCnpj );
        $this->addDropdown($oDrop1, $oDrop2);
        $this->addCampos($oNr, $oFilcgc,  $oEmpDes,$oNome, $otipornc, $oSit, $oDatabert, $oCodProbl);
    
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




        $oFieldAnexo = new FieldSet('Anexos das Rncs ');
        $oFieldAnexo->setOculto(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, true);
        $oNr->setBCampoBloqueado(true);
        //*busca por setor
        $oUsunome = new campo('Usuário', 'lidercausa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
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

        $oPessoa = new Campo('Usuário que Detectou ', 'userini', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
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
        $oCodProd = new Campo('Cód.Prod.', 'codprod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProdDes = new campo('Desc.Prod', 'prodes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oProdDes->setApenasTela(true);
        /*  $oProdDes->setSIdPk($oCodProd->getId());
          $oProdDes->setClasseBusca('Produto');
          $oProdDes->addCampoBusca('procod', '', '');
          $oProdDes->addCampoBusca('prodes', '', '');
          $oProdDes->setSIdTela($this->getTela()->getid());
          $oProdDes->setApenasTela(true);
          $oCodProd->setClasseBusca('Produto');
          $oCodProd->setSCampoRetorno('procod', $this->getTela()->getId());
          $oCodProd->addCampoBusca('prodes', $oProdDes->getId(), $this->getTela()->getId()); */
        //cod materia prima
        $oCodmat = new Campo('Cód.Mat.Prima', 'codmat', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProdDes2 = new campo('Desc.Mat.Prima', 'prodes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oProdDes2->setApenasTela(true);
        /* $oProdDes2->setSIdPk($oCodmat->getId());
          $oProdDes2->setClasseBusca('Produto');
          $oProdDes2->addCampoBusca('procod', '', '');
          $oProdDes2->addCampoBusca('prodes', '', '');
          $oProdDes2->setSIdTela($this->getTela()->getid());
          $oProdDes2->setApenasTela(true);
          $oCodmat->setClasseBusca('Produto');
          $oCodmat->setSCampoRetorno('procod', $this->getTela()->getId());
          $oCodmat->addCampoBusca('prodes', $oProdDes2->getId(), $this->getTela()->getId()); */
        /* ----------------------exemplo chamar código codproble--------------------------- */
        $oCodProbl = new campo('Cód.Problema', 'codprobl', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 1, 1);
        $oCodProbl->setSValor('1');
        $oCodProblDes = new campo('Desc. Problema', 'MET_QUAL_Prob_Rnc.descprobl', Campo::TIPO_BUSCADOBANCO, 4, 4, 4, 4);

        $oCodProblDes->setSIdPk($oCodProbl->getId());
        $oCodProblDes->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProblDes->setSValor('MATERIAL ERRADO');
        $oCodProblDes->addCampoBusca('codprobl', '', '');
        $oCodProblDes->addCampoBusca('descprobl', '', '');
        $oCodProblDes->setSIdTela($this->getTela()->getid());

        $oCodProbl->setClasseBusca('MET_QUAL_Prob_Rnc');
        $oCodProbl->setSCampoRetorno('codprobl', $this->getTela()->getId());
        $oCodProbl->addCampoBusca('descprobl', $oCodProblDes->getId(), $this->getTela()->getId());

        /* ----------------------fim exemplo------------------------------------ */
        $oCodCorrida = new Campo('...', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodCorrida->setApenasTela(true);
        $oCodCorrida->setBOculto(true);
        $oCorrida = new Campo('Corrida', 'corridas', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oCorrida->setSIdPk($oCodCorrida->getId());
        $oCorrida->setClasseBusca('MET_QUAL_MovOi');
        $oCorrida->addCampoBusca('nroi', '', '');
        $oCorrida->addCampoBusca('corrida', '', '');
        $oCorrida->setSIdTela($this->getTela()->getid());
        $oCorrida->setApenasTela(true);
        $oCodCorrida->setClasseBusca('MET_QUAL_MovOi');
        $oCodCorrida->setSCampoRetorno('nroi', $this->getTela()->getId());
        $oCodCorrida->addCampoBusca('corrida', $oCorrida->getId(), $this->getTela()->getId());
        $oCampoCorrida = new Campo('Corridas', 'corrida', Campo::TIPO_TAGS, 4, 4, 12, 12);
        $oBotConf = new Campo('Adicionar', 'botao', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $sAcao = 'addCorrida($("#' . $oCorrida->getId() . '").val(),'
                . '"' . $oCorrida->getId() . '",'
                . '"' . $oCampoCorrida->getId() . '",'
                . '"' . $this->getController() . '")';
        $oBotConf->getOBotao()->addAcao($sAcao);
        $oBotConf->setApenasTela(true);




        $oSituaca = new Campo('', 'sit', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setSValor('Aguardando');
        $oSituaca->setBOculto(true);
        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $olote = new Campo('Lote', 'lote', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oqtlote = new Campo('Qt.Lote', 'qtlote', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oqtloternc = new Campo('Qt.Defeito', 'qtloternc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $oLn = new Campo('', 'linha1', Campo::TIPO_LINHABRANCO,12,12,12,12);
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
        $odescrnc = new Campo('Descrição da não conformidade', 'descrnc', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $odescrnc->setILinhasTextArea(3);
        $oDivisor2 = new Campo('Dados quem detectou ', 'dadorec1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);
        $oDivisor1 = new Campo('Origem da não Conformidade', 'dadorec2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);
        //busca por funcionario/setor que cometeu erro
        $oUsercausa = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUsercausa->setApenasTela(true);
        $oUsercausa->setBOculto(true);
        $oPessoacausa = new Campo('Usuário que causou', 'usercausa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoacausa->setSIdPk($oCodUsuario->getId());
        $oPessoacausa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoacausa->addCampoBusca('numcad', '', '');
        $oPessoacausa->addCampoBusca('nomfun', '', '');
        $oPessoacausa->setSIdTela($this->getTela()->getid());
        $oUsercausa->setClasseBusca('MET_CAD_Funcionarios');
        $oUsercausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oUsercausa->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());
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
        $oRespcausa = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oRespcausa->setApenasTela(true);
        $oRespcausa->setBOculto(true);
        $oPessoaresp = new Campo('Responsável pelo Setor', 'respcausa', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
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
        $oDecisaornc = new Campo('Decisão Obs', 'descdescirnc', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDecisaornc->setILinhasTextArea(3);
        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo4 = new Campo('Anexo4', 'anexo4', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        //seta ids uploads para enviar no request para limpar

        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId() . ',' . $oAnexo4->getId());

        // $oFieldAnexo->addCampos(array($oAnexo1, $oAnexo2));

        $oOp->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadosOp","' . $oCodProd->getId() . ',' .
                $oProdDes->getId() . '");');

        $oCodmat->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() .
                '-form","MET_QUAL_Rnc","buscaDadoscodmat","' . $oProdDes2->getId() . '");');

        $oTabProbl->addCampos(array($oCodProbl, $oCodProblDes), $odescrnc, $oSituaca, array($ocodsetor, $odescset01, $oturno01, $oCodUsuario, $oPessoa), array($oCnpj2, $oEmpresa));
        $oTabMatP->addCampos(array($oCodmat, $oProdDes2), array($oCodCorrida, $oCorrida, $oBotConf), $oCampoCorrida);
        $oTabcausa->addCampos(array($oUsercausa, $oPessoacausa, $oturno02, $ocodsetor2), array($odescset02, $oRespcausa, $oPessoaresp), array($ocausarnc), $odesccausa);
        $oTabdesc->addCampos($oDecisao, $oDecisaornc);
        $oTabAnexo->addCampos(array($oAnexo1, $oAnexo2));
        $oTab->addItems($oTabProbl, $oTabMatP, $oTabcausa, $oTabdesc, $oTabAnexo);
        $this->addCampos(array($oNr, $oFilcgc, $oUsunome, $oDatabert, $ohoraini), array($otipornc, $oOp, $oCodProd, $oProdDes,$olote, $oqtlote, $oqtloternc),$oLn, $oTab);
    }

}
