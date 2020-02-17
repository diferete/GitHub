<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Chamados extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(FALSE);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);

        $this->setUsaFiltro(true);
        $sFiltroSetor = $_SESSION['codsetor'];

        if ($sFiltroSetor == 2) {

            $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
            $oBotaoModal->setBHideTelaAcao(true);
            $oBotaoModal->setILargura(15);
            $oBotaoModal->setSTitleAcao('Gerencia Chamados');
            $oBotaoModal->addAcao('MET_TEC_Chamados', 'criaTelaModalApontaChamado', 'criaModalApontaChamado', '');
            $this->addModais($oBotaoModal);
        }

        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);
        $oNr->setILargura(5);
        if ($sFiltroSetor == 2) {
            $oNr->setSOperacao('personalizado');
        }

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc', CampoConsulta::TIPO_TEXTO);

        $oSit = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSit->addComparacao('AGUARDANDO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_LINHA, false, '');
        $oSit->addComparacao('INICIADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_LINHA, false, '');
        $oSit->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_LINHA, false, '');
        $oSit->addComparacao('CANCELADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_LINHA, false, '');
        $oSit->setBComparacaoColuna(true);

        $oTipo = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_TEXTO);
        $oTipo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, '', CampoConsulta::MODO_LINHA, true, 'HARDWARE');
        $oTipo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, '', CampoConsulta::MODO_LINHA, true, 'SOFTWARE');
        $oTipo->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, '', CampoConsulta::MODO_LINHA, true, 'SERVIÇOS');

        $oSubTipo = new CampoConsulta('SubTipo', 'subtipo_nome', CampoConsulta::TIPO_TEXTO);

        $oUsuSol = new CampoConsulta('User', 'usunome', CampoConsulta::TIPO_TEXTO);

        $oSetor = new CampoConsulta('Setor', 'setor', CampoConsulta::TIPO_TEXTO);

        $oRep = new CampoConsulta('Rep.', 'repoffice', CampoConsulta::TIPO_TEXTO);

        $oDataCad = new CampoConsulta('Dt.Cad.', 'datacad', CampoConsulta::TIPO_DATA);

        $oDataInicio = new CampoConsulta('Dt.Ini.', 'datainicio', CampoConsulta::TIPO_DATA);

        $oUsuInicio = new CampoConsulta('Usu.Ini.', 'usunomeinicio', CampoConsulta::TIPO_TEXTO);

        $oDataFim = new CampoConsulta('Dt.Fim', 'datafim', CampoConsulta::TIPO_DATA);

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

        $oFilEmp = new Filtro($oFilcgc, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);


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

        $this->addFiltro($oFilNr, $oFilEmp, $oFilTipo, $oFilSit);

        $oDrop = new Dropdown('Cancelar', Dropdown::TIPO_ERRO, Dropdown::ICON_ERRO);
        $oDrop->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Cancelar chamado', $this->getController(), 'criaTelaModalCancelaChamado', '', false, '', false, 'criaTelaModalCancelaChamado', true, 'Cancelar chamado', false, false);

        $this->addDropdown($oDrop);

        if ($sFiltroSetor == 2) {
            $this->addCampos($oBotaoModal, $oNr, $oFilcgc, $oSit, $oUsuSol, $oSetor, $oRep, $oTipo, $oSubTipo, $oDataCad, $oUsuInicio, $oDataInicio, $oUsuFim, $oDataFim);
        } else {
            $this->addCampos($oNr, $oFilcgc, $oSit, $oUsuSol, $oSetor, $oRep, $oTipo, $oSubTipo, $oDataCad, $oUsuInicio, $oDataInicio, $oUsuFim, $oDataFim);
        }
    }

    public function criaTela() {
        parent::criaTela();


        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Dados do chamado');
        $oTabGeral->setBActive(true);
        $oTabAnexos = new AbaTabPanel('Anexos');
        $this->addLayoutPadrao('Aba');

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

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

        $oSetor = new Campo('Setor', 'setor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetor->setBCampoBloqueado(true);
        $oSetor->setSValor($_SESSION['codsetor']);

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

        $oSituaca = new Campo('', 'situaca');
        $oSituaca->setBOculto(true);
        $oSituaca->setSValor('AGUARDANDO');

        $oTabGeral->addCampos(array($oTipo, $oSubTipoCod, $oSubTipo), $oProblema, $oSituaca);
        $oTabAnexos->addCampos($oAnexo1, $oAnexo2, $oAnexo3);
        $oTab->addItems($oTabGeral, $oTabAnexos);
        $this->addCampos(array($oNr, $oFilcgc, $oUsuCod, $oUsuNome, $oSetor, $oRepOffice, $oDataCad, $oHoraCad), $oLinha, $oTab);
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
        $oProblema->setSValor($oDados->getProblema());
        $oProblema->setBCampoBloqueado(true);

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
        $oProblema->setSValor($oDados->getProblema());
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

        $oObsFim = new Campo('O que foi feito', 'obsfim', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsFim->setILinhasTextArea(3);
        $oObsFim->setBFocus(true);
        $oObsFim->addValidacao(false, Validacao::TIPO_STRING, '', '5');

        //botão inserir os dados
        $oBtnFim = new Campo('Finalizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnFim->getId());
        $sAcaoFim = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaChamadoFinaliza","' . $this->getTela()->getId() . '-form","");';
        $oBtnFim->getOBotao()->addAcao($sAcaoFim);
        $oBtnFim->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $this->addCampos(array($oNr, $oFilcgc, $oSolicitante, $oDataFim, $oHoraFim), $oProblema, $oUsunomeFim, $oObsFim, array($oBtnFim));
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
        $oProblema->setSValor($oDados->getProblema());
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

        $oObsFim = new Campo('Motivo do cancelamento', 'obsfim', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsFim->setILinhasTextArea(3);
        $oObsFim->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5);

        //botão inserir os dados
        $oBtnCancela = new Campo('Cancelar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $this->getTela()->setIdBtnConfirmar($oBtnCancela->getId());
        $sAcaoCancela = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaChamadoCancela","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';
        $oBtnCancela->getOBotao()->addAcao($sAcaoCancela);
        $oBtnCancela->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);



        $this->addCampos(array($oNr, $oFilcgc, $oSolicitante, $oDataFim, $oHoraFim), $oProblema, $oUsunomeFim, $oObsFim, array($oBtnCancela));
    }

}
