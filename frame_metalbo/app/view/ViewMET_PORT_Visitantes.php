<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PORT_Visitantes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oExcluir = new Dropdown('Excluir', Dropdown::TIPO_AVISO, Dropdown::ICON_PADRAO);
        $oExcluir->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Excluir Registro', 'MET_PORT_Visitantes', 'excluirRegistro', '', false, '', false, '', false, '');


        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Aponta movimentação de Terceiros!');
        $oBotaoModal->addAcao('MET_PORT_Visitantes', 'criaTelaModalApontamentoVisitante', 'criaModalApontamentoVisitante');
        $this->addModais($oBotaoModal);


        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);

        $oCpf = new CampoConsulta('CPF Somente Nr.', 'cpf', CampoConsulta::TIPO_TEXTO);

        $oPessoa = new CampoConsulta('Pessoa', 'pessoa', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);
        $oMotivo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Serviços');
        $oMotivo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Visita');
        $oMotivo->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Outro');
        $oMotivo->setBComparacaoColuna(true);

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Chegada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataChegou = new CampoConsulta('Dt. Chegada', 'datachegou', CampoConsulta::TIPO_DATA);

        $oHoraChegou = new CampoConsulta('Hr. Chegada', 'horachegou', CampoConsulta::TIPO_EDIT);
        $oHoraChegou->addAcao('MET_PORT_Visitantes', 'gravaHora');
        $oHoraChegou->setBTime(true);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'dataentrou', CampoConsulta::TIPO_DATA);

        $oHoraEntra = new CampoConsulta('Hr. Entrada', 'horaentrou', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaiu', CampoConsulta::TIPO_DATA);

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaiu', CampoConsulta::TIPO_TIME);


        ///////////////////////////////////Filtros///////////////////////////////
        $oFilCracha = new Filtro($oCpf, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilNR = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilColaborador = new Filtro($oPessoa, Filtro::CAMPO_TEXTO, 5, 5, 12, 12);

        $oFilMotivo = new Filtro($oMotivo, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilMotivo->addItemSelect('Todos', 'Todos');
        $oFilMotivo->addItemSelect('1', 'Serviços');
        $oFilMotivo->addItemSelect('2', 'Visita');
        $oFilMotivo->addItemSelect('3', 'Outro');
        $oFilMotivo->setSLabel('Motivo');

        $this->addDropdown($oExcluir);
        $this->addFiltro($oFilNR, $oFilCracha, $oFilColaborador, $oFilMotivo);
        $this->addCampos($oBotaoModal, $oNr, $oSituaca, $oPessoa, $oCpf, $oMotivo, $oDataChegou, $oHoraChegou, $oDataEntra, $oHoraEntra, $oDataSaida, $oHoraSaida);
    }

    public function criaTela() {
        parent::criaTela();

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

        $oDataCad = new Campo('Data', 'datachegou', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));

        $oHoraEntra = new Campo('Hora', 'horachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraEntra->setSValor(date('H:i:s'));
        $oHoraEntra->setBTime(true);
        $oHoraEntra->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oMotivo->addItemSelect('Selecionar', 'Selecionar');
        $oMotivo->addItemSelect('2', 'Visita - 6000');
        $oMotivo->addItemSelect('1', 'Serviços - 7000');
        $oMotivo->addItemSelect('3', 'Outro');
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar vazio!');

        $oSetor = new campo('Cód.', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oSetorDes = new Campo('Setor a ser visitado', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSetorDes->setSIdPk($oSetor->getId());
        $oSetorDes->setClasseBusca('Setor');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());

        $oSetor->setClasseBusca('Setor');
        $oSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor1 = new Campo('Dados da pessoa', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oCpf = new campo('CPF', 'cpf', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCpf->setITamanho(Campo::TAMANHO_PEQUENO);

        $oPessoa = new Campo('Pessoa', 'pessoa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoa->setSIdPk($oCpf->getId());
        $oPessoa->setClasseBusca('MET_CAD_Cpf');
        $oPessoa->addCampoBusca('cpf', '', '');
        $oPessoa->addCampoBusca('nome', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oCpf->setClasseBusca('MET_CAD_Cpf');
        $oCpf->setSCampoRetorno('cpf', $this->getTela()->getId());
        $oCpf->addCampoBusca('nome', $oPessoa->getId(), $this->getTela()->getId());

        $oFone = new Campo('Contato *Nr c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oTipo = new Campo('', 'tipopessoa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('V');
        $oTipo->setBOculto(true);

        $oDivisor2 = new Campo('Dados do veículo', 'divisor2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);


        $oPlaca = new campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_SELECT, 1, 1, 12, 12);
        ///////////////////VISITANTES//////////////////////////
        $oCracha->addItemSelect('0', 'Outros');
        $oCracha->addItemSelect('6000', '6000');
        $oCracha->addItemSelect('6001', '6001');
        $oCracha->addItemSelect('6002', '6002');
        $oCracha->addItemSelect('6003', '6003');
        $oCracha->addItemSelect('6004', '6004');
        $oCracha->addItemSelect('6005', '6005');
        $oCracha->addItemSelect('6006', '6006');
        $oCracha->addItemSelect('6007', '6007');
        $oCracha->addItemSelect('6008', '6008');
        $oCracha->addItemSelect('6009', '6009');
        $oCracha->addItemSelect('6010', '6010');
        $oCracha->addItemSelect('6011', '6011');
        $oCracha->addItemSelect('6012', '6012');
        $oCracha->addItemSelect('6013', '6013');
        $oCracha->addItemSelect('6014', '6014');
        $oCracha->addItemSelect('6015', '6015');
        $oCracha->addItemSelect('6016', '6016');
        $oCracha->addItemSelect('6017', '6017');
        $oCracha->addItemSelect('6018', '6018');
        $oCracha->addItemSelect('6019', '6019');
        $oCracha->addItemSelect('6020', '6020');
        //////////////////SERVIÇOS////////////////////////////
        $oCracha->addItemSelect('7000', '7000');
        $oCracha->addItemSelect('7001', '7001');
        $oCracha->addItemSelect('7002', '7002');
        $oCracha->addItemSelect('7003', '7003');
        $oCracha->addItemSelect('7004', '7004');
        $oCracha->addItemSelect('7005', '7005');
        $oCracha->addItemSelect('7006', '7006');
        $oCracha->addItemSelect('7007', '7007');
        $oCracha->addItemSelect('7008', '7008');
        $oCracha->addItemSelect('7009', '7009');
        $oCracha->addItemSelect('7010', '7010');
        $oCracha->addItemSelect('7011', '7011');
        $oCracha->addItemSelect('7012', '7012');
        $oCracha->addItemSelect('7013', '7013');
        $oCracha->addItemSelect('7014', '7014');
        $oCracha->addItemSelect('7015', '7015');
        $oCracha->addItemSelect('7016', '7016');
        $oCracha->addItemSelect('7017', '7017');
        $oCracha->addItemSelect('7018', '7018');
        $oCracha->addItemSelect('7019', '7019');
        $oCracha->addItemSelect('7020', '7020');

        $oEmpresa = new Campo('Empresa', 'empdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $sCallBackCPF = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Visitantes","buscaCpf","' . $oEmpresa->getId() . ',' . $oFone->getId() . ',' . $sAcao . '");';
        if ($sAcao != 'acaoVisualiza') {
            $oEmpresa->addEvento(Campo::EVENTO_FOCUS, $sCallBackCPF);
        }


        $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oMotivo, $oCracha), array($oSetor, $oSetorDes), $oDescMotivo, $oDivisor1, array($oCpf, $oPessoa, $oEmpresa, $oFone), $oDivisor2, array($oPlaca), array($oTipo, $oUsuCod, $oSituaca));
    }

    public function criaModalApontaEntradaVisitante() {
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

        $oCracha = new Campo('CPF', 'cpf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCracha->setSValor($oDados->getCpf());
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
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEntradaVisitante","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function criaModalApontaSaidaVisitante() {
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
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaSaidaVisitante","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oCracha, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function relVisitantes() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Terceiros');
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
        $oMotivo->addItemSelect('2', 'Visita - 6000');
        $oMotivo->addItemSelect('1', 'Serviços - 7000');
        $oMotivo->addItemSelect('3', 'Outro');

        $oCpf = new campo('CPF', 'cpf', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCpf->setITamanho(Campo::TAMANHO_PEQUENO);

        $oPessoa = new Campo('Pessoa', 'pessoa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoa->setSIdPk($oCpf->getId());
        $oPessoa->setClasseBusca('MET_CAD_Cpf');
        $oPessoa->addCampoBusca('cpf', '', '');
        $oPessoa->addCampoBusca('nome', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oCpf->setClasseBusca('MET_CAD_Cpf');
        $oCpf->setSCampoRetorno('cpf', $this->getTela()->getId());
        $oCpf->addCampoBusca('nome', $oPessoa->getId(), $this->getTela()->getId());

        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao->addItemSelect('', 'Todas');
        $oSituacao->addItemSelect('Chegada', 'Chegada');
        $oSituacao->addItemSelect('Entrada', 'Entrada');
        $oSituacao->addItemSelect('Saída', 'Saída');

        $oL = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $this->addCampos(array($oMotivo, $oDataIni, $oDataFin), $oL, array($oCpf, $oPessoa), $oL, $oSituacao);
    }

}
