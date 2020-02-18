<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PORT_Pessoas extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Aponta movimentação de pessoas!');
        $oBotaoModal->addAcao('MET_PORT_Pessoas', 'criaTelaModalApontamento', 'criaModalApontamento');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);

        $oCracha = new CampoConsulta('Crachá', 'cracha', CampoConsulta::TIPO_TEXTO);

        $oTipoPessoa = new CampoConsulta('Tipo', 'tipopessoa', CampoConsulta::TIPO_TEXTO);

        $oPessoa = new CampoConsulta('Pessoa', 'pessoa', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Chegada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataChegou = new CampoConsulta('Dt. Chegada', 'datachegou', CampoConsulta::TIPO_DATA);

        $oHoraChegou = new CampoConsulta('Hr. Chegada', 'horachegou', CampoConsulta::TIPO_TIME);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'dataentrou', CampoConsulta::TIPO_DATA);

        $oHoraEntra = new CampoConsulta('Hr. Entrada', 'horaentrou', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaiu', CampoConsulta::TIPO_DATA);

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaiu', CampoConsulta::TIPO_TIME);


        ///////////////////////////////////Filtros///////////////////////////////
        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilNR = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilColaborador = new Filtro($oPessoa, Filtro::CAMPO_TEXTO, 5, 5, 12, 12);

        $oFilMotivo = new Filtro($oMotivo, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilMotivo->addItemSelect('Todos', 'Todos');
        $oFilMotivo->addItemSelect('1', 'Coleta');
        $oFilMotivo->addItemSelect('2', 'Entrega Mat.P.');
        $oFilMotivo->addItemSelect('3', 'Outras Coletas');
        $oFilMotivo->addItemSelect('4', 'Outras Entregas');
        $oFilMotivo->addItemSelect('5', 'Atraso');
        $oFilMotivo->addItemSelect('6', 'Serviços');
        $oFilMotivo->addItemSelect('7', 'Visita');
        $oFilMotivo->addItemSelect('8', 'Outro');
        $oFilMotivo->setSLabel('Motivo');


        $this->addFiltro($oFilNR, $oFilCracha, $oFilColaborador, $oFilMotivo);
        $this->addCampos($oBotaoModal, $oMotivo, $oNr, $oCracha, $oSituaca, $oTipoPessoa, $oPessoa, $oDataChegou, $oHoraChegou, $oDataEntra, $oHoraEntra, $oDataSaida, $oHoraSaida);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBGravaHistorico(true);

        $sAcao = $this->getSRotina();

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSituaca->setSValor('Chegada');
        $oSituaca->setBCampoBloqueado(true);
        $oSituaca->setBOculto(true);

        $oUsuCod = new Campo('', 'usucod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCod->setSValor($_SESSION['codUser']);
        $oUsuCod->setBCampoBloqueado(true);
        $oUsuCod->setBOculto(true);

        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuNome->setSValor($_SESSION['nome']);
        $oUsuNome->setBCampoBloqueado(true);

        $oDataCad = new Campo('Data', 'datachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));
        $oDataCad->setBCampoBloqueado(true);

        $oHoraEntra = new Campo('Hora', 'horachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraEntra->setSValor(date('H:i:s'));
        $oHoraEntra->setBTime(true);
        $oHoraEntra->setBCampoBloqueado(true);

        $oTipoPessoa = new Campo('Tipo de pessoa', 'tipopessoa', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoPessoa->addItemSelect('Selecionar', 'Selecionar');
        $oTipoPessoa->addItemSelect('C', 'Colaborador');
        $oTipoPessoa->addItemSelect('T', 'Terceiros');

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('Selecionar', 'Selecionar');
        $oMotivo->addItemSelect('1', 'Coleta');
        $oMotivo->addItemSelect('2', 'Entrega Mat.P.');
        $oMotivo->addItemSelect('3', 'Outras Coletas');
        $oMotivo->addItemSelect('4', 'Outras Entregas');
        $oMotivo->addItemSelect('5', 'Atraso');
        $oMotivo->addItemSelect('6', 'Serviços');
        $oMotivo->addItemSelect('7', 'Visita');
        $oMotivo->addItemSelect('8', 'Outro');
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar vazio!');

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor1 = new Campo('Preencher caso motivo seja Atraso', 'divisor1', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oRespCracha = new Campo('Crachá Resp.', 'respcracha', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRespCracha->setSCorFundo(Campo::FUNDO_AMARELO);

        $oRespNome = new campo('Resp. Nome', 'respnome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespNome->setSCorFundo(Campo::FUNDO_AMARELO);
        $oRespNome->setSIdPk($oRespCracha->getId());
        $oRespNome->setClasseBusca('MET_CAD_Users');
        $oRespNome->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oRespNome->addCampoBusca('cracha', '', '');
        $oRespNome->addCampoBusca('nome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());

        $oRespCracha->setClasseBusca('MET_CAD_Users');
        $oRespCracha->setSCampoRetorno('cracha', $this->getTela()->getId());
        $oRespCracha->addCampoBusca('nome', $oRespNome->getId(), $this->getTela()->getId());

        $oDivisor2 = new Campo('Dados da pessoa', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oCracha = new campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCracha->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3', '5');
        $oCracha->setClasseBusca('MET_CAD_Users');
        $oCracha->setSCampoRetorno('cracha', $this->getTela()->getId());
        $oCracha->setSCorFundo(Campo::FUNDO_AMARELO);
        if ($sAcao == 'acaoIncluir') {

            $oCracha->setBFocus(true);
        }
        
        
        $oPessoa = new Campo('Pessoa', 'pessoa', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPessoa->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '50');
        $oPessoa->setSCorFundo(Campo::FUNDO_AMARELO);

        $oSetor = new campo('Cód. setor', 'codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetor->setBCampoBloqueado(true);

        $oSetorDes = new Campo('Setor', 'descsetor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oSetorDes->setBCampoBloqueado(true);


        $oFone = new Campo('Contato *Nr c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFone->setBFone(true);

        $oTipo = new Campo('', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('P');
        $oTipo->setBOculto(true);


        $oCnpj = new Campo('...', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmpresa = new Campo('Empresa', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Pessoas","buscaCracha","' . $oPessoa->getId() . ',' . $oSetor->getId() . ',' . $oSetorDes->getId() . ',' . $oCnpj->getId() . ',' . $oEmpresa->getId() . ',' . $sAcao . '");';

        if ($sAcao != 'acaoVisualiza') {
            $oCracha->addEvento(Campo::EVENTO_SAIR, $sCallBack);
        }
        if ($sAcao == 'acaoAlterar') {

            $oHistorico = new Campo('O que foi alterado?', 'historico', Campo::TIPO_HISTORICO);
            $oHistorico->addValidacao(false, Validacao::TIPO_STRING, '', '20', '300');
            $oHistorico->setSCorFundo(Campo::FUNDO_AMARELO);
            $oHistorico->setILinhasTextArea(4);
            $oHistorico->setApenasTela(true);

            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oTipoPessoa, $oMotivo), $oDescMotivo, $oDivisor1, array($oRespCracha, $oRespNome), $oDivisor2, array($oCracha, $oPessoa, $oFone), array($oSetor, $oSetorDes), array($oCnpj, $oEmpresa), $oHistorico, array($oTipo, $oUsuCod, $oSituaca));
        } else {
            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oTipoPessoa, $oMotivo), $oDescMotivo, $oDivisor1, array($oRespCracha, $oRespNome), $oDivisor2, array($oCracha, $oPessoa, $oFone), array($oSetor, $oSetorDes), array($oCnpj, $oEmpresa), array($oTipo, $oUsuCod, $oSituaca));
        }
    }

    public function criaModalApontaEntrada() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oEmpresa = new Campo('Empresa', 'empdes', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oEmpresa->setSValor($oDados->getEmpdes());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCracha->setSValor($oDados->getCracha());
        $oCracha->setBCampoBloqueado(true);
        $oCracha->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDivisor1 = new Campo('Dados da Entrada', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataSaida = new Campo('Data da entrada', 'dataentrou', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setBCampoBloqueado(true);
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora entrada', 'horaentrou', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setBCampoBloqueado(true);
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEntrada","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function criaModalApontaSaida() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oEmpresa = new Campo('Empresa', 'empdes', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oEmpresa->setSValor($oDados->getEmpdes());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCracha->setSValor($oDados->getCracha());
        $oCracha->setBCampoBloqueado(true);
        $oCracha->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDivisor1 = new Campo('Dados da saída', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataSaida = new Campo('Data saída', 'datasaiu', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setBCampoBloqueado(true);
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora saída', 'horasaiu', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setBCampoBloqueado(true);
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaSaida","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

}
