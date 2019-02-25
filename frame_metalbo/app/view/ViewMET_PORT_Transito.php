<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PORT_Transito extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);
        $this->getTela()->setBGridResponsivo(false);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Aponta movimentações do veículo!');
        $oBotaoModal->addAcao('MET_PORT_Transito', 'criaTelaModalApontamentoTransito', 'criaModalApontamentoTransito');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr');

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaiu', CampoConsulta::TIPO_TIME);

        $oPlaca = new CampoConsulta('Placa', 'placa', CampoConsulta::TIPO_TEXTO);

        $oEmpresa = new CampoConsulta('Empresa', 'empdes', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);
        $oMotivo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Coleta');
        $oMotivo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ent.Mat.Prima');
        $oMotivo->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Out.Coletas');
        $oMotivo->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Out.Entregas');
        $oMotivo->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Serviços');
        $oMotivo->addComparacao('6', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Visita');
        $oMotivo->addComparacao('7', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Outro');

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Chegada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataChegou = new CampoConsulta('Dt. Chegada', 'datachegou', CampoConsulta::TIPO_DATA);

        $oHoraChegou = new CampoConsulta('Hr. Chegada', 'horachegou', CampoConsulta::TIPO_TIME);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'dataentrou', CampoConsulta::TIPO_DATA);

        $oHoraEntrou = new CampoConsulta('Hr. Entrada', 'horaentrou', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaiu', CampoConsulta::TIPO_DATA);

        ///////////////////////////////////Filtros///////////////////////////////
        $oFilPlaca = new Filtro($oPlaca, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $oFilNR = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilEmpresa = new Filtro($oEmpresa, Filtro::CAMPO_TEXTO, 5, 5, 12, 12);

        $oFilMotivo = new Filtro($oMotivo, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilMotivo->addItemSelect('Todos', 'Todos');
        $oFilMotivo->addItemSelect('1', 'Coleta');
        $oFilMotivo->addItemSelect('2', 'Entrega Mat.P.');
        $oFilMotivo->addItemSelect('3', 'Outras Coletas');
        $oFilMotivo->addItemSelect('4', 'Outras Entregas');
        $oFilMotivo->addItemSelect('5', 'Serviços');
        $oFilMotivo->addItemSelect('6', 'Visita');
        $oFilMotivo->addItemSelect('7', 'Outro');
        $oFilMotivo->setSLabel('Motivo');

        $oFilSituaca = new Filtro($oSituaca, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oFilSituaca->addItemSelect('Todos', 'Todos');
        $oFilSituaca->addItemSelect('Chegada', 'Chegada');
        $oFilSituaca->addItemSelect('Entrada', 'Entrada');
        $oFilSituaca->addItemSelect('Saída', 'Saída');
        $oFilSituaca->setSLabel('Situação');

        $this->addFiltro($oFilNR, $oFilPlaca, $oFilEmpresa, $oFilMotivo,$oFilSituaca);
        $this->addCampos($oBotaoModal, $oNr, $oEmpresa, $oPlaca, $oSituaca, $oMotivo, $oDataChegou, $oHoraChegou, $oDataEntra, $oHoraEntrou, $oDataSaida, $oHoraSaida);
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

        $oDataCad = new Campo('Data', 'datachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));
        $oDataCad->setBCampoBloqueado(true);

        $oHoraChegou = new Campo('Hora', 'horachegou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraChegou->setSValor(date('H:i:s'));
        $oHoraChegou->setBCampoBloqueado(true);
        $oHoraChegou->setBTime(true);


        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('Selecionar', 'Selecionar');
        $oMotivo->addItemSelect('1', 'Coleta');
        $oMotivo->addItemSelect('2', 'Entrega Mat.P.');
        $oMotivo->addItemSelect('3', 'Outras Coletas');
        $oMotivo->addItemSelect('4', 'Outras Entregas');
        $oMotivo->addItemSelect('5', 'Serviços');
        $oMotivo->addItemSelect('6', 'Visita');
        $oMotivo->addItemSelect('7', 'Outro');
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar vazio!');

        $oDivisor1 = new Campo('Preencher se for diferente de Coleta/Entrega', 'divisor2', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor2 = new Campo('Dados do veículo', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '1', '7');
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);
        if ($sAcao == 'acaoIncluir') {
            $oPlaca->setBFocus(true);
        }


        $oPlacaCarr1 = new Campo('Placa Carr. 1', 'placacarr1', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr1->setSCorFundo(Campo::FUNDO_AMARELO);

        $oPlacaCarr2 = new Campo('Placa Carr. 2', 'placacarr2', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr2->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCpf = new campo('CPF', 'cpf', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCpf->setITamanho(Campo::TAMANHO_PEQUENO);

        $oMotorista = new Campo('Pessoa', 'motorista', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oMotorista->setSIdPk($oCpf->getId());
        $oMotorista->setClasseBusca('MET_CAD_Cpf');
        $oMotorista->addCampoBusca('cpf', '', '');
        $oMotorista->addCampoBusca('nome', '', '');
        $oMotorista->setSIdTela($this->getTela()->getid());

        $oCpf->setClasseBusca('MET_CAD_Cpf');
        $oCpf->setSCampoRetorno('cpf', $this->getTela()->getId());
        $oCpf->addCampoBusca('nome', $oMotorista->getId(), $this->getTela()->getId());

        $oFone = new Campo('Contato *número c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCnpj = new Campo('CNPJ', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->addValidacao(false, Validacao::TIPO_STRING, '', '12');

        $oEmpresa = new Campo('Emp/Trans', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        $oTipo = new Campo('', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('T');
        $oTipo->setBOculto(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Transito","buscaPlaca","' . $oPlaca->getId() . ',' . $oCnpj->getId() . ',' . $oEmpresa->getId() . '");';
        $sCallBackCPF = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Transito","buscaCpf","' . $oFone->getId() . ',' . $sAcao . '");';

        if ($sAcao != 'acaoVisualiza') {
            $oPlaca->addEvento(Campo::EVENTO_SAIR, $sCallBack);
            $oCpf->addEvento(Campo::EVENTO_SAIR, $sCallBackCPF);
        }

        $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraChegou), $oDivisor2, array($oPlaca, $oPlacaCarr1, $oPlacaCarr2), array($oCpf, $oMotorista, $oFone), array($oCnpj, $oEmpresa), array($oMotivo), $oDivisor1, $oDescMotivo, array($oTipo, $oUsuCod, $oSituaca));
    }

    public function criaModalApontaEntradaTransito() {
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

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSValor($oDados->getPlaca());
        $oPlaca->setBCampoBloqueado(true);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

        $oPlacaCarr1 = new Campo('Placa Carr. 1', 'placacarr1', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr1->setSValor($oDados->getPlacacarr1());
        $oPlacaCarr1->setBCampoBloqueado(true);
        $oPlacaCarr1->setSCorFundo(Campo::FUNDO_MONEY);

        $oPlacaCarr2 = new Campo('Placa Carr. 2', 'placacarr2', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr2->setSValor($oDados->getPlacacarr2());
        $oPlacaCarr2->setBCampoBloqueado(true);
        $oPlacaCarr2->setSCorFundo(Campo::FUNDO_MONEY);

        $oDivisor1 = new Campo('Dados da Entrada', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataEntrada = new Campo('Data da entrada', 'dataentrou', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEntrada->setSValor(date('d/m/Y'));
        $oDataEntrada->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraEntrada = new Campo('Hora entrada', 'horaentrou', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraEntrada->setSValor(date('H:i:s'));
        $oHoraEntrada->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEntradaTransito","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor(Util::limpaString($oDados->getDescmotivo()));
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oEmpresa), array($oMotivo, $oPlaca, $oPlacaCarr1, $oPlacaCarr2), $oDescMotivo, $oDivisor1, array($oDataEntrada, $oHoraEntrada, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function criaModalApontaSaidaTransito() {
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

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSValor($oDados->getPlaca());
        $oPlaca->setBCampoBloqueado(true);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

        $oPlacaCarr1 = new Campo('Placa Carr. 1', 'placacarr1', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr1->setSValor($oDados->getPlacacarr1());
        $oPlacaCarr1->setBCampoBloqueado(true);
        $oPlacaCarr1->setSCorFundo(Campo::FUNDO_MONEY);

        $oPlacaCarr2 = new Campo('Placa Carr. 2', 'placacarr2', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlacaCarr2->setSValor($oDados->getPlacacarr2());
        $oPlacaCarr2->setBCampoBloqueado(true);
        $oPlacaCarr2->setSCorFundo(Campo::FUNDO_MONEY);

        $oDivisor1 = new Campo('Dados da saída', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataSaida = new Campo('Data saída', 'datasaiu', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora saída', 'horasaiu', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaSaidaTransito","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescMotivo->setSValor($oDados->getDescmotivo());
        $oDescMotivo->setBCampoBloqueado(true);
        $oDescMotivo->setILinhasTextArea(4);

        $this->addCampos(array($oNr, $oEmpresa), array($oMotivo, $oPlaca, $oPlacaCarr1, $oPlacaCarr2), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function relTransito() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Transito');
        $this->setBTela(true);

        $oUserRel = new Campo('', 'userRel', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUserRel->setSValor($_SESSION['nome']);

        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataFin->setSValor(Util::getDataAtual());
        $oDataFin->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('', '');
        $oMotivo->addItemSelect('1', 'Coleta');
        $oMotivo->addItemSelect('2', 'Entrega Mat.P.');
        $oMotivo->addItemSelect('3', 'Outras Coletas');
        $oMotivo->addItemSelect('4', 'Outras Entregas');
        $oMotivo->addItemSelect('5', 'Serviços');
        $oMotivo->addItemSelect('6', 'Visita');
        $oMotivo->addItemSelect('7', 'Outro');

        $this->addCampos(array($oDataIni, $oDataFin), $oMotivo);
    }

}
