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
        $oBotaoModal->addAcao('MET_PORT_Transito', 'criaTelaModalApontamento', 'criaModalApontamento');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);

        $oPlaca = new CampoConsulta('Placa', 'placa', CampoConsulta::TIPO_TEXTO);

        $oEmpresa = new CampoConsulta('Empresa', 'emptransdes', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Chegada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataChegou = new CampoConsulta('Dt. Chegada', 'datachegou', CampoConsulta::TIPO_DATA);

        $oHoraChegou = new CampoConsulta('Hr. Chegada', 'horachegou', CampoConsulta::TIPO_TIME);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'dataentrou', CampoConsulta::TIPO_DATA);

        $oHoraEntrou = new CampoConsulta('Hr. Entrada', 'horaentrou', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaiu', CampoConsulta::TIPO_DATA);

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaiu', CampoConsulta::TIPO_TIME);


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
        $oFilMotivo->addItemSelect('5', 'Atraso');
        $oFilMotivo->addItemSelect('6', 'Serviços');
        $oFilMotivo->addItemSelect('7', 'Visita');
        $oFilMotivo->addItemSelect('8', 'Outro');
        $oFilMotivo->setSLabel('Motivo');


        $this->addFiltro($oFilNR, $oFilPlaca, $oFilEmpresa, $oFilMotivo);
        $this->addCampos($oBotaoModal, $oNr, $oPlaca, $oMotivo, $oSituaca, $oEmpresa, $oDataChegou, $oHoraChegou, $oDataEntra, $oHoraEntrou, $oDataSaida, $oHoraSaida);
    }

    public function criaTela() {
        parent::criaTela();


        $this->setBGravaHistorico(true);

        $sAcao = $this->getSRotina();

        $oFieldInf = new FieldSet('Empresa *Se for DIFERENTE da transportadora');

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
        $oMotivo->addItemSelect('5', 'Atraso');
        $oMotivo->addItemSelect('6', 'Serviços');
        $oMotivo->addItemSelect('7', 'Visita');
        $oMotivo->addItemSelect('8', 'Outro');
        $oMotivo->addValidacao(false, Validacao::TIPO_STRING,'Campo não pode estar vazio!');

        $oDivisor1 = new Campo('Preencher se for diferente de Coleta/Entrega', 'divisor2', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor2 = new Campo('Dados do veículo', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oPlaca->setClasseBusca('MET_PORT_CadVeiculos');
        $oPlaca->setSCampoRetorno('placa', $this->getTela()->getId());
        $oPlaca->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '1', '7');
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPlaca->setBFocus(true);

        $oMotorista = new Campo('Motorista', 'motorista', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMotorista->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '4', '50');
        $oMotorista->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDocMotorista = new Campo('Doc. do motorista *RG/CPF', 'documento', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oFone = new Campo('Contato *número c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFone->addValidacao(true, Validacao::TIPO_STRING, '', '10', '11');

        $oEmpCod = new Campo('CNPJ', 'emptranscod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpCod->setBCampoBloqueado(true);

        $oEmpDes = new Campo('Emp/Transp', 'emptransdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmpDes->setBCampoBloqueado(true);

        $oModelo = new Campo('Fabricante/Modelo', 'modelo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oModelo->setBCampoBloqueado(true);

        $oCor = new Campo('Cor', 'cor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCor->setBCampoBloqueado(true);

        $oSetor = new campo('Cód. setor', 'codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetor->setBCampoBloqueado(true);

        $oSetorDes = new Campo('Setor', 'descsetor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oSetorDes->setBCampoBloqueado(true);

        $oTipo = new Campo('', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('V');
        $oTipo->setBOculto(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Transito","buscaPlaca","' . $oPlaca->getId() . ',' . $oEmpCod->getId() . ',' . $oEmpDes->getId() . ',' . $oSetor->getId() . ',' . $oSetorDes->getId() . ',' . $oModelo->getId() . ',' . $oCor->getId() . '");';

        if ($sAcao != 'acaoVisualiza') {
            $oPlaca->addEvento(Campo::EVENTO_SAIR, $sCallBack);
        }

        $oCnpj = new Campo('CNPJ', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);

        $oEmpresa = new Campo('Empresa', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());


        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);
        $oLinha->setApenasTela(true);

        if ($sAcao == 'acaoAlterar') {

            $oHistorico = new Campo('O que foi alterado?', 'historico', Campo::TIPO_HISTORICO);
            $oHistorico->addValidacao(false, Validacao::TIPO_STRING, '', '20', '300');
            $oHistorico->setILinhasTextArea(4);
            $oHistorico->setApenasTela(true);

            $oFieldInf->addCampos(array($oCnpj, $oEmpresa));
            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraChegou), array($oMotivo), $oDivisor1, $oDescMotivo, $oDivisor2, array($oPlaca, $oMotorista, $oDocMotorista, $oFone), array($oEmpCod, $oEmpDes), array($oModelo, $oCor), array($oSetor, $oSetorDes), $oLinha, $oFieldInf, array($oHistorico, $oTipo, $oUsuCod, $oSituaca));
        } else {
            $oFieldInf->addCampos(array($oCnpj, $oEmpresa));
            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraChegou), array($oMotivo), $oDivisor1, $oDescMotivo, $oDivisor2, array($oPlaca, $oMotorista, $oDocMotorista, $oFone), array($oEmpCod, $oEmpDes), array($oModelo, $oCor), array($oSetor, $oSetorDes), $oLinha, $oFieldInf, array($oTipo, $oUsuCod, $oSituaca));
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

        $oEmpresa = new Campo('Empresa', 'emptransdes', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oEmpresa->setSValor($oDados->getEmptransdes());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSValor($oDados->getPlaca());
        $oPlaca->setBCampoBloqueado(true);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

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

        $this->addCampos(array($oNr, $oPlaca, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

    public function criaModalApontaSaida() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oEmpresa = new Campo('Empresa', 'emptransdes', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oEmpresa->setSValor($oDados->getEmptransdes());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMotivo->setSValor($oDados->getMotivo());
        $oMotivo->setBCampoBloqueado(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSValor($oDados->getPlaca());
        $oPlaca->setBCampoBloqueado(true);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

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

        $this->addCampos(array($oNr, $oPlaca, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
    }

}
