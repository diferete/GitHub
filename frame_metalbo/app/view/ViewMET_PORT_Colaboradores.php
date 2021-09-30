<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PORT_Colaboradores extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);
         $this->getTela()->setBGridResponsivo(false);
        
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oExcluir = new Dropdown('Excluir', Dropdown::TIPO_AVISO, Dropdown::ICON_PADRAO);
        $oExcluir->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Excluir Registro', 'MET_PORT_Colaboradores', 'excluirRegistro', '', false, '', false, '', false, '');


        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Aponta movimentação de Colaboradores!');
        $oBotaoModal->addAcao('MET_PORT_Colaboradores', 'criaTelaModalApontamentoColaboradores', 'criaModalApontamentoColaboradores');
        $this->addModais($oBotaoModal);


        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);

        $oCracha = new CampoConsulta('Crachá', 'cracha', CampoConsulta::TIPO_TEXTO);

        $oPessoa = new CampoConsulta('Pessoa', 'pessoa', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);
        $oMotivo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Serviços');
        $oMotivo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Visita');
        $oMotivo->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Atraso');
        $oMotivo->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Saída');
        $oMotivo->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Outro');
        $oMotivo->setBComparacaoColuna(true);

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Chegada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataChegou = new CampoConsulta('Dt. Chegada', 'datachegou', CampoConsulta::TIPO_DATA);

        $oHoraChegou = new CampoConsulta('Hr. Chegada', 'horachegou', CampoConsulta::TIPO_EDIT);
        $oHoraChegou->addAcao('MET_PORT_Colaboradores', 'gravaHora');
        $oHoraChegou->setBTime(true);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'dataentrou', CampoConsulta::TIPO_DATA);

        $oHoraEntra = new CampoConsulta('Hr. Entrada', 'horaentrou', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaiu', CampoConsulta::TIPO_DATA);

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaiu', CampoConsulta::TIPO_TIME);


        ///////////////////////////////////Filtros///////////////////////////////
        $oFilData = new Filtro($oDataChegou, Filtro::CAMPO_DATA_ENTRE);

        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilNR = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilColaborador = new Filtro($oPessoa, Filtro::CAMPO_TEXTO, 5, 5, 12, 12);

        $oFilMotivo = new Filtro($oMotivo, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilMotivo->addItemSelect('Todos', 'Todos');
        $oFilMotivo->addItemSelect('1', 'Serviços');
        $oFilMotivo->addItemSelect('2', 'Visita');
        $oFilMotivo->addItemSelect('3', 'Atraso');
        $oFilMotivo->addItemSelect('4', 'Saída');
        $oFilMotivo->addItemSelect('5', 'Outro');

        $oFilMotivo->setSLabel('Motivo');

        $this->addDropdown($oExcluir);
        $this->addFiltro($oFilNR, $oFilCracha, $oFilColaborador, $oFilData, $oFilMotivo);
        $this->addCampos($oBotaoModal, $oNr, $oSituaca, $oPessoa, $oCracha, $oMotivo, $oDataChegou, $oHoraChegou, $oDataEntra, $oHoraEntra, $oDataSaida, $oHoraSaida);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcao = $this->getSRotina();

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oUsuCod = new Campo('', 'usucod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCod->setSValor($_SESSION['codUser']);
        $oUsuCod->setBCampoBloqueado(true);
        $oUsuCod->setBOculto(true);

        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuNome->setSValor($_SESSION['nome']);
        $oUsuNome->setBCampoBloqueado(true);

        $oDataCad = new Campo('Data', 'datachegou', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));

        $oHoraEntra = new Campo('Hora', 'horachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraEntra->setSValor(date('H:i:s'));
        $oHoraEntra->setBTime(true);
        $oHoraEntra->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('Selecionar', 'Selecionar');
        $oMotivo->addItemSelect('1', 'Serviços');
        $oMotivo->addItemSelect('2', 'Visita');
        $oMotivo->addItemSelect('3', 'Atraso');
        $oMotivo->addItemSelect('4', 'Saída');
        $oMotivo->addItemSelect('5', 'Outro');
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar vazio!');

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor1 = new Campo('Dados da pessoa', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCracha->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCracha->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3', '5');
        if ($sAcao == 'acaoIncluir') {
            $oCracha->setBFocus(true);
        }

        $oPessoa = new Campo('Pessoa', 'pessoa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoa->setSIdPk($oCracha->getId());
        $oPessoa->setClasseBusca('MET_RH_Colaboradores');
        $oPessoa->addCampoBusca('numcad', '', '');
        $oPessoa->addCampoBusca('nomfun', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oCracha->setClasseBusca('MET_RH_Colaboradores');
        $oCracha->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCracha->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());

        $oFone = new Campo('Contato *Nr c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oRespCracha = new Campo('Resp.Crachá', 'respcracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oRespCracha->setITamanho(Campo::TAMANHO_PEQUENO);

        $oRespNome = new Campo('Resp.Nome', 'respnome', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oRespNome->setSIdPk($oRespCracha->getId());
        $oRespNome->setClasseBusca('MET_CAD_Funcionarios');
        $oRespNome->addCampoBusca('numcad', '', '');
        $oRespNome->addCampoBusca('nomfun', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());

        $oRespCracha->setClasseBusca('MET_CAD_Funcionarios');
        $oRespCracha->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oRespCracha->addCampoBusca('nomfun', $oRespNome->getId(), $this->getTela()->getId());

        $oTipo = new Campo('', 'tipopessoa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('C');
        $oTipo->setBOculto(true);

        $oDivisor2 = new Campo('Dados do veículo', 'divisor2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);


        $oPlaca = new campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

        $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oMotivo), $oDescMotivo, $oDivisor1, array($oCracha, $oPessoa, $oFone), array($oRespCracha, $oRespNome), $oDivisor2, array($oPlaca), array($oTipo, $oUsuCod));
    }

    public function criaModalApontaEntradaColaboradores() {
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

        $oDataSaida = new Campo('Data da entrada', 'dataentrou', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora entrada', 'horaentrou', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEntradaColaboradores","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function criaModalApontaSaidaColaboradores() {
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

        $oDataSaida = new Campo('Data saída', 'datasaiu', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora saída', 'horasaiu', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaSaidaColaboradores","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function relColaboradores() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Colaboradores');
        $this->setBTela(true);

        $oUserRel = new Campo('', 'userRel', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUserRel->setSValor($_SESSION['nome']);

        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataFin->setSValor(Util::getDataAtual());
        $oDataFin->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('', 'Todos');
        $oMotivo->addItemSelect('1', 'Serviços');
        $oMotivo->addItemSelect('2', 'Visita');
        $oMotivo->addItemSelect('3', 'Atraso');
        $oMotivo->addItemSelect('4', 'Saída');
        $oMotivo->addItemSelect('5', 'Outro');

        $oCracha = new campo('Cracha', 'numcad', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCracha->setITamanho(Campo::TAMANHO_PEQUENO);

        $oPessoa = new Campo('Pessoa', 'nomfun', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoa->setSIdPk($oCracha->getId());
        $oPessoa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoa->addCampoBusca('numcad', '', '');
        $oPessoa->addCampoBusca('nomfun', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oCracha->setClasseBusca('MET_CAD_Funcionarios');
        $oCracha->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCracha->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());

        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao->addItemSelect('', 'Todas');
        $oSituacao->addItemSelect('Chegada', 'Chegada');
        $oSituacao->addItemSelect('Entrada', 'Entrada');
        $oSituacao->addItemSelect('Saída', 'Saída');

        $oL = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $this->addCampos(array($oMotivo, $oDataIni, $oDataFin), $oL, array($oCracha, $oPessoa), $oL, $oSituacao);
    }

}
