<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Chamados extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);
        $this->setAcaoFecharTela(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setILarguraGrid(2200);
        $this->getTela()->setBGridResponsivo(false);

        $this->setUsaFiltro(true);
        $sFiltroSetor = $_SESSION['codsetor'];



        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Gerencia Chamados');
        $oBotaoModal->addAcao('MET_TEC_Chamados', 'criaTelaModalApontaChamado', 'criaModalApontaChamado', '');
        $this->addModais($oBotaoModal);

        $oAnexoFim = new CampoConsulta('AnexoFim', 'anexofim', CampoConsulta::TIPO_DOWNLOAD);


        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);
        $oNr->setILargura(5);
        if ($sFiltroSetor == 2) {
            $oNr->setSOperacao('personalizado');
        }

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oFilcgc->addComparacao('75483040000211', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_DKGRAY, CampoConsulta::MODO_LINHA, false, null);
        $oFilcgc->setBComparacaoColuna(true);

        $oSit = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSit->addComparacao('AGUARDANDO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_LINHA, false, null);
        $oSit->addComparacao('INICIADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_LINHA, false, null);
        $oSit->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oSit->addComparacao('CANCELADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_LINHA, false, null);
        $oSit->setBComparacaoColuna(true);

        $oTipo = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_TEXTO);
        $oTipo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_LINHA, true, 'HARDWARE');
        $oTipo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_LINHA, true, 'SOFTWARE');
        $oTipo->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_LINHA, true, 'SERVIÇOS');

        $oSubTipo = new CampoConsulta('SubTipo', 'subtipo_nome', CampoConsulta::TIPO_TEXTO);

        $oUsuSol = new CampoConsulta('User', 'usunome', CampoConsulta::TIPO_TEXTO);

        $oSetor = new CampoConsulta('Setor', 'descsetor', CampoConsulta::TIPO_TEXTO);

        $oRep = new CampoConsulta('Rep.', 'repoffice', CampoConsulta::TIPO_TEXTO);

        $oDataCad = new CampoConsulta('Dt.Cad.', 'datacad', CampoConsulta::TIPO_DATA);
        $oHoraCad = new CampoConsulta('H.Cad.', 'horacad', CampoConsulta::TIPO_TIME);

        $oDataInicio = new CampoConsulta('Dt.Ini.', 'datainicio', CampoConsulta::TIPO_DATA);
        $oHoraInicio = new CampoConsulta('H.Ini.', 'horainicio', CampoConsulta::TIPO_TIME);

        $oUsuInicio = new CampoConsulta('Usu.Ini.', 'usunomeinicio', CampoConsulta::TIPO_TEXTO);

        $oDataFim = new CampoConsulta('Dt.Fim', 'datafim', CampoConsulta::TIPO_DATA);
        $oHoraFim = new CampoConsulta('H.Fim.', 'horafim', CampoConsulta::TIPO_TIME);

        $oUsuFim = new CampoConsulta('Usu.Fim', 'usunomefim', CampoConsulta::TIPO_TEXTO);

        $oProblema = new Campo('Problema apresentando', 'problema', Campo::TIPO_TEXTAREA, 6);
        $oProblema->setILinhasTextArea(6);
        $oProblema->setSCorFundo(Campo::FUNDO_AMARELO);
        $oProblema->setBCampoBloqueado(true);

        $oObsFim = new Campo('Obs. Final', 'obsfim', Campo::TIPO_TEXTAREA, 6);
        $oObsFim->setILinhasTextArea(6);
        $oObsFim->setSCorFundo(Campo::FUNDO_VERDE);
        $oObsFim->setBCampoBloqueado(true);

        $this->addCamposGrid($oProblema, $oObsFim);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_TEC_Chamados","carregaProb","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oProblema->getId() . '"+",' . $oObsFim->getId() . ',"+"");');

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);



        $oFilSetor = new Filtro($oSetor, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFilUsoSol = new Filtro($oUsuSol, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oFilUsoSol->setSLabel('Usuário solicitante');

        $oFilUsuIni = new Filtro($oUsuInicio, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oFilUsuIni->setSLabel('Responsável que iniciou');

        $oFilData = new Filtro($oDataCad, Filtro::CAMPO_DATA_ENTRE, 1, 1, 12, 12, true);

        $oFilEmp = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilEmp->addItemSelect('75483040000211', 'Metalbo');
        $oFilEmp->addItemSelect('83781641000158', 'Poliamidos');
        $oFilEmp->setSLabel('Empresas');

        $oFilSit = new Filtro($oSit, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilSit->addItemSelect('Todos', 'Todos');
        $oFilSit->addItemSelect('AGUARDANDO', 'AGUARDANDO');
        $oFilSit->addItemSelect('INICIADO', 'INICIADO');
        $oFilSit->addItemSelect('FINALIZADO', 'FINALIZADO');
        $oFilSit->addItemSelect('CANCELADO', 'CANCELADO');
        $oFilSit->setSLabel('Situação');

        $oFilTipo = new Filtro($oTipo, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilTipo->addItemSelect('Todos', 'Todos');
        $oFilTipo->addItemSelect('1', 'HARDWARE');
        $oFilTipo->addItemSelect('2', 'SOFTWARE');
        $oFilTipo->addItemSelect('3', 'SERVIÇOS');

        $this->addFiltro($oFilNr, $oFilSetor, $oFilUsoSol, $oFilUsuIni, $oFilData, $oFilEmp, $oFilTipo, $oFilSit);

        $oDrop = new Dropdown('Cancelar', Dropdown::TIPO_ERRO, Dropdown::ICON_ERRO);
        $oDrop->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Cancelar chamado', $this->getController(), 'criaTelaModalCancelaChamado', '', false, '', false, 'criaTelaModalCancelaChamado', true, 'Cancelar chamado', false, false);

        $oDrop1 = new Dropdown('E-mail', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail de NOTIFICAÇÃO', $this->getController(), 'reenviaEmailTi', '', false, '', false, '', false, '', false, false);


        $oDrop2 = new Dropdown('E-mail', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail de FINALIZAÇÃO', $this->getController(), 'reenviaEmailFinaliza', '', false, '', false, '', false, '', false, false);

        if ($sFiltroSetor == 2) {
            $this->addDropdown($oDrop, $oDrop2);
            $this->addCampos($oBotaoModal, $oNr, $oFilcgc, $oSit, $oUsuSol, $oSetor, $oRep, $oTipo, $oSubTipo, $oDataCad, $oHoraCad, $oUsuInicio, $oDataInicio, $oHoraInicio, $oUsuFim, $oDataFim, $oHoraFim, $oAnexoFim);
        } else {
            $this->addDropdown($oDrop, $oDrop1);
            $this->addCampos($oNr, $oFilcgc, $oSit, $oUsuSol, $oSetor, $oRep, $oTipo, $oSubTipo, $oDataCad, $oUsuInicio, $oDataInicio, $oHoraInicio, $oUsuFim, $oDataFim, $oHoraFim);
        }
    }

    public function criaTela() {
        parent::criaTela();


        $this->getTela()->setBFecharTelaIncluir(true);

        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Dados do chamado');
        $oTabGeral->setBActive(true);
        $oTabAnexos = new AbaTabPanel('Anexos');
        $this->addLayoutPadrao('Aba');

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setSValor($_SESSION['filcgc']);

        $oUsuCod = new Campo('Cód.', 'usucod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCod->setBCampoBloqueado(true);
        $oUsuCod->setSValor($_SESSION['codUser']);

        $oUsuNome = new Campo('Nome', 'usunome', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuNome->setBCampoBloqueado(true);
        $oUsuNome->setSValor($_SESSION['nome']);

        $oRepOffice = new Campo('Rep. Escritório', 'repoffice', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRepOffice->setSValor($_SESSION['repofficedes']);
        $oRepOffice->setBCampoBloqueado(true);

        $oDataCad = new Campo('Data Cad.', 'datacad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));
        $oDataCad->setBCampoBloqueado(true);

        $oHoraCad = new Campo('Hora Cad.', 'horacad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraCad->setBCampoBloqueado(true);
        $oHoraCad->setSValor(date('H:i'));

        $oSetor = new Campo('Cód.Setor', 'setor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetor->setBCampoBloqueado(true);
        $oSetor->setSValor($_SESSION['codsetor']);

        $oDescSetor = new Campo('Desc. Setor', 'descsetor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescSetor->setBCampoBloqueado(true);
        $oDescSetor->setSValor($_SESSION['descsetor']);

        $oLinha = new Campo('Dados a inserir', 'linha1', Campo::DIVISOR_VERMELHO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oTipo = new Campo('Tipo', 'tipo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipo->addItemSelect('1', 'HARDWARE');
        $oTipo->addItemSelect('2', 'SOFTWARE');
        $oTipo->addItemSelect('3', 'SERVIÇOS');

        $oSubTipoCod = new Campo('Cód. Subtipo', 'subtipo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubTipoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório');
        $oSubTipoCod->setBFocus(true);

        $oSubTipo = new Campo('Subtipo', 'subtipo_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubTipo->setSIdPk($oSubTipoCod->getId());
        $oSubTipo->setClasseBusca('MET_TEC_ChamadoTipo');
        $oSubTipo->addCampoBusca('subtipo', '', '');
        $oSubTipo->addCampoBusca('subtipo_nome', '', '');
        $oSubTipo->setSIdTela($this->getTela()->getid());

        $oSubTipoCod->setClasseBusca('MET_TEC_ChamadoTipo');
        $oSubTipoCod->setSCampoRetorno('subtipo', $this->getTela()->getId());
        $oSubTipoCod->addCampoBusca('subtipo_nome', $oSubTipo->getId(), $this->getTela()->getId());

        $oAnexo1 = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 3, 3, 12, 12);
        $oAnexo2 = new Campo('Anexo 2', 'anexo2', Campo::TIPO_UPLOAD, 3, 3, 12, 12);
        $oAnexo3 = new Campo('Anexo 3', 'anexo3', Campo::TIPO_UPLOAD, 3, 3, 12, 12);

        $oProblema = new Campo('Problema', 'problema', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oProblema->setILinhasTextArea(3);
        $oProblema->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 10, 1000);

        $oSituaca = new Campo('', 'situaca');
        $oSituaca->setBOculto(true);
        $oSituaca->setSValor('AGUARDANDO');

        $oTabGeral->addCampos(array($oTipo, $oSubTipoCod, $oSubTipo), $oProblema, $oSituaca);
        $oTabAnexos->addCampos($oAnexo1, $oAnexo2, $oAnexo3);
        $oTab->addItems($oTabGeral, $oTabAnexos);
        $this->addCampos(array($oNr, $oFilcgc, $oUsuCod, $oUsuNome, $oSetor, $oDescSetor, $oRepOffice, $oDataCad, $oHoraCad), $oLinha, $oTab);
    }

    public function criaModalIniciaChamado() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oSolicitante = new Campo('Solicitante', 'usunome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSolicitante->setSValor($oDados->getUsunome());
        $oSolicitante->setBCampoBloqueado(true);

        $oProblema = new Campo('Problema', 'problema', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oProblema->setSValor(Util::limpaString($oDados->getProblema()));
        $oProblema->setBCampoBloqueado(true);
        $oProblema->setILinhasTextArea(5);

        $oDataInicio = new Campo('Data Início', 'datainicio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataInicio->setSValor(date('d/m/Y'));
        $oDataInicio->setBCampoBloqueado(true);

        $oHoraInicio = new Campo('Hora Início', 'horainicio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraInicio->setSValor(date('H:i'));
        $oHoraInicio->setBCampoBloqueado(true);

        $oUsunomeInicio = new Campo('', 'usunomeinicio', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunomeInicio->setBOculto(true);
        $oUsunomeInicio->setSValor($_SESSION['nome']);

        //botão inserir os dados
        $oBtnInicio = new Campo('Iniciar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoInicio = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaChamadoInicia","' . $this->getTela()->getId() . '-form","");';
        $oBtnInicio->getOBotao()->addAcao($sAcaoInicio);
        $oBtnInicio->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);



        $this->addCampos(array($oNr, $oFilcgc, $oSolicitante, $oDataInicio, $oHoraInicio), $oProblema, $oUsunomeInicio, array($oBtnInicio));
    }

    public function criaModalFinalizaChamado() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oSolicitante = new Campo('Solicitante', 'usunome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSolicitante->setSValor($oDados->getUsunome());
        $oSolicitante->setBCampoBloqueado(true);

        $oProblema = new Campo('Problema', 'problema', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oProblema->setSValor(Util::limpaString($oDados->getProblema()));
        $oProblema->setBCampoBloqueado(true);
        $oProblema->setILinhasTextArea(5);

        $oDataFim = new Campo('Data Início', 'datafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataFim->setSValor(date('d/m/Y'));
        $oDataFim->setBCampoBloqueado(true);

        $oHoraFim = new Campo('Hora Início', 'horafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraFim->setSValor(date('H:i'));
        $oHoraFim->setBCampoBloqueado(true);

        $oUsunomeFim = new Campo('', 'usunomefim', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunomeFim->setBOculto(true);
        $oUsunomeFim->setSValor($_SESSION['nome']);

        $oObsFim = new Campo('O que foi feito', 'obsfim', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsFim->setILinhasTextArea(5);
        $oObsFim->setBFocus(true);
        $oObsFim->addValidacao(false, Validacao::TIPO_STRING, '', '5');

        $oAnexoFinal = new Campo('Anexo', 'anexofim', Campo::TIPO_UPLOAD, 6, 6, 12, 12);

        //botão inserir os dados
        $oBtnFim = new Campo('Finalizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnFim->getId());
        $sAcaoFim = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaChamadoFinaliza","' . $this->getTela()->getId() . '-form","");';
        $oBtnFim->getOBotao()->addAcao($sAcaoFim);
        $oBtnFim->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $this->addCampos(array($oNr, $oFilcgc, $oSolicitante, $oDataFim, $oHoraFim), $oProblema, $oUsunomeFim, array($oObsFim, $oAnexoFinal), array($oBtnFim));
    }

    public function criaModalCancelaChamado($sDados) {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oSolicitante = new Campo('Solicitante', 'usunome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSolicitante->setSValor($oDados->getUsunome());
        $oSolicitante->setBCampoBloqueado(true);

        $oProblema = new Campo('Problema', 'problema', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oProblema->setSValor(Util::limpaString($oDados->getProblema()));
        $oProblema->setBCampoBloqueado(true);

        $oDataFim = new Campo('Data Início', 'datafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataFim->setSValor(date('d/m/Y'));
        $oDataFim->setBCampoBloqueado(true);

        $oHoraFim = new Campo('Hora Início', 'horafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraFim->setSValor(date('H:i'));
        $oHoraFim->setBCampoBloqueado(true);

        $oUsunomeFim = new Campo('', 'usunomefim', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunomeFim->setBOculto(true);
        $oUsunomeFim->setSValor($_SESSION['nome']);

        $oObsFim = new Campo('Motivo do cancelamento', 'obsfim', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsFim->setILinhasTextArea(4);
        $oObsFim->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5);

        $oAnexoFim = new Campo('Anexo', 'anexofim', Campo::TIPO_UPLOAD, 6, 6, 12, 12);

        //botão inserir os dados
        $oBtnCancela = new Campo('Cancelar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $this->getTela()->setIdBtnConfirmar($oBtnCancela->getId());
        $sAcaoCancela = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaChamadoCancela","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';
        $oBtnCancela->getOBotao()->addAcao($sAcaoCancela);
        $oBtnCancela->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);



        $this->addCampos(array($oNr, $oFilcgc, $oSolicitante, $oDataFim, $oHoraFim), $oProblema, $oUsunomeFim, array($oObsFim, $oAnexoFim), array($oBtnCancela));
    }

    public function relChamados() {
        parent::criaTelaRelatorio();

        $aDados = $this->getAParametrosExtras();
        $aDados1 = $aDados[0];
        $aDados2 = $aDados[1];
        $aDados3 = $aDados[2];
        $aDados4 = $aDados[3];
        $aDados5 = $aDados[4];

        $this->setTituloTela('Relatório de Chamados Tecnologia da Informação');
        $this->setBTela(true);

        //Empresa
        $oEmpresa = new Campo('Empresa', 'empresa', Campo::CAMPO_SELECTSIMPLE, 4, 4, 12, 12);
        $oEmpresa->addItemSelect('Todos', 'Todas as Empresas');
        foreach ($aDados3 as $key3) {
            $oEmpresa->addItemSelect($key3['filcgc'], $key3['filcgc'] . ' - ' . $key3['empdes']);
        }

        //SubTipo
        $oSubTipo = new Campo('Sub.Tipo', 'subtipo_nome', Campo::CAMPO_SELECTSIMPLE, 3, 3, 12, 12);
        $oSubTipo->addItemSelect('Todos', 'Todos SubTipos');
        foreach ($aDados2 as $key3) {
            $oSubTipo->addItemSelect($key3['subtipo_nome'], $key3['subtipo_nome']);
        }

        //Usuário
        $oUsuario = new Campo('Usuários', 'usunome', Campo::CAMPO_SELECT, 2, 2, 12, 12);
        $oUsuario->addItemSelect('Todos', 'Todos Usuários');
        foreach ($aDados4 as $key3) {
            $oUsuario->addItemSelect($key3['usunome'], $key3['usunome']);
        }

        $oTipo = new Campo('Tipo', 'tipo', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oTipo->addItemSelect('Todos', 'Todos Tipos');
        $oTipo->addItemSelect('1', 'HARDWARE');
        $oTipo->addItemSelect('2', 'SOFTWARE');
        $oTipo->addItemSelect('3', 'SERVIÇOS');

        //Representante
        $oRep = new Campo('Representantes', 'repr', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oRep->addItemSelect('Todos', 'Todos representantes');
        foreach ($aDados1 as $key3) {
            $oRep->addItemSelect($key3['repoffice'], $key3['repoffice']);
        }

        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $oSit = new Campo('Situação', 'sit', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oSit->addItemSelect('Todos', 'Todas Situações');
        $oSit->addItemSelect('AGUARDANDO', 'AGUARDANDO');
        $oSit->addItemSelect('INICIADO', 'INICIADO');
        $oSit->addItemSelect('FINALIZADO', 'FINALIZADO');
        $oSit->addItemSelect('CANCELADO', 'CANCELADO');

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oFieldRelAnt = new FieldSet('Relatório Chamados Antigos Sistema_Metalbo');

        $oRelAntigo = new Campo("Relatório Antigo", 'relant', Campo::TIPO_CHECK, 2, 2, 12, 12);

        //Usuário
        $oSetor = new Campo('Setores', 'setor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSetor->addItemSelect('Todos', 'Todos Setores');
        foreach ($aDados5 as $key4) {
            $oSetor->addItemSelect($key4['codsetor'], $key4['descsetor']);
        }

        $oTipoAnt = new Campo('Tipo', 'tipoant', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oTipoAnt->addItemSelect('Todos', 'Todos Tipos');
        $oTipoAnt->addItemSelect('HARDWARE', 'HARDWARE');
        $oTipoAnt->addItemSelect('SOFTWARE', 'SOFTWARE');
        $oTipoAnt->addItemSelect('SERVIÇOS', 'SERVIÇOS');
        $oTipoAnt->addItemSelect('RELATORIOS', 'RELATORIOS');

        $oSitAnt = new Campo('Situação', 'sitant', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oSitAnt->addItemSelect('Todos', 'Todas Situações');
        $oSitAnt->addItemSelect('AGUARDANDO', 'AGUARDANDO');
        $oSitAnt->addItemSelect('EM ANDAMENTO', 'EM ANDAMENTO');
        $oSitAnt->addItemSelect('FINALIZADO', 'FINALIZADO');
        $oSitAnt->addItemSelect('CANCELADO', 'CANCELADO');

        $oFieldRelAnt->addCampos(array($oRelAntigo, $oSetor), $oLinha1, array($oTipoAnt, $oSitAnt));
        $oFieldRelAnt->setOculto(true);

        $oFieldRelAtual = new FieldSet('Relatório Chamados Atual ');
        $oFieldRelAtual->addCampos(array($oEmpresa, $oUsuario), $oLinha1, array($oRep, $oSubTipo), $oLinha1, array($oTipo, $oSit));

        $oApenasGrafico = new Campo("Somente Gráfico", 'apgrafico', Campo::TIPO_CHECK, 2, 2, 12, 12);

        $this->addCampos($oFieldRelAtual, $oLinha1, $oFieldRelAnt, $oLinha1, array($oDatainicial, $oDatafinal), $oApenasGrafico);
    }

}
