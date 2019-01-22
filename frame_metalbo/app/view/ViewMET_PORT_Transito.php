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

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Aponta saída do veículo!');
        $oBotaoModal->addAcao('MET_PORT_Transito', 'criaTelaModalApontaSaida', 'criaModalApontaSaida');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr.', 'nr', CampoConsulta::TIPO_TEXTO);

        $oPlaca = new CampoConsulta('Placa', 'placa', CampoConsulta::TIPO_TEXTO);

        $oEmpresa = new CampoConsulta('Empresa', 'empdes', CampoConsulta::TIPO_TEXTO);

        $oMotivo = new CampoConsulta('Motivo', 'motivo', CampoConsulta::TIPO_TEXTO);

        $oSituaca = new CampoConsulta('Sit.', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSituaca->addComparacao('Entrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Saída', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituaca->setBComparacaoColuna(true);

        $oDataEntra = new CampoConsulta('Dt. Entrada', 'datacad', CampoConsulta::TIPO_DATA);

        $oHoraEntra = new CampoConsulta('Hr. Entrada', 'horaentra', CampoConsulta::TIPO_TIME);

        $oDataSaida = new CampoConsulta('Dt. Saída', 'datasaida', CampoConsulta::TIPO_DATA);

        $oHoraSaida = new CampoConsulta('Hr. Saída', 'horasaida', CampoConsulta::TIPO_TIME);


        ///////////////////////////////////Filtros///////////////////////////////
        $oFilPlaca = new Filtro($oPlaca, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $oFilNR = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 3, 3, 12, 12);

        $oFilEmpresa = new Filtro($oEmpresa, Filtro::CAMPO_TEXTO_IGUAL, 5, 5, 12, 12);

        $oFilMotivo = new Filtro($oMotivo, Filtro::CAMPO_SELECT, 3, 3, 12, 12);
        $oFilMotivo->addItemSelect('Todos', 'Todos');
        $oFilMotivo->addItemSelect('Carga', 'Carga');
        $oFilMotivo->addItemSelect('Entrega', 'Entrega');
        $oFilMotivo->addItemSelect('Serviços', 'Serviços');
        $oFilMotivo->setSLabel('Motivo');


        $this->addFiltro($oFilNR, $oFilPlaca, $oFilEmpresa, $oFilMotivo);
        $this->addCampos($oBotaoModal, $oMotivo, $oNr, $oPlaca, $oSituaca, $oEmpresa, $oDataEntra, $oHoraEntra, $oDataSaida, $oHoraSaida);
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
        $oSituaca->setSValor('Entrada');
        $oSituaca->setBCampoBloqueado(true);
        $oSituaca->setBOculto(true);

        $oUsuCod = new Campo('', 'usucod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCod->setSValor($_SESSION['codUser']);
        $oUsuCod->setBCampoBloqueado(true);
        $oUsuCod->setBOculto(true);

        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuNome->setSValor($_SESSION['nome']);
        $oUsuNome->setBCampoBloqueado(true);

        $oDataCad = new Campo('Data', 'datacad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCad->setSValor(date('d/m/Y'));
        $oDataCad->setBCampoBloqueado(true);

        $oHoraEntra = new Campo('Hora', 'horaentra', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraEntra->setSValor(date('H:i:s'));
        $oHoraEntra->setBCampoBloqueado(true);


        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('Carga', 'Carga');
        $oMotivo->addItemSelect('Entrega', 'Entrega');
        $oMotivo->addItemSelect('Serviços', 'Serviços');
        $oMotivo->addItemSelect('Visita', 'Visita');
        $oMotivo->addItemSelect('Outro', 'Outro');

        $oDivisor1 = new Campo('Preencher se for diferente de Carga/Entrega', 'divisor2', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oDescMotivo->setILinhasTextArea(4);

        $oDivisor2 = new Campo('Dados do veículo', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '1', '7');
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPlaca->setBFocus(true);

        $oMotorista = new Campo('Motorista', 'motorista', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMotorista->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '50');

        $oDocMotorista = new Campo('Doc. do motorista *RG/CPF', 'documento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDocMotorista->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '20');

        $oFone = new Campo('Contato *somente Nr c/ DDD', 'fone', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFone->addValidacao(true, Validacao::TIPO_STRING, '', '10', '11');

        $oEmpCod = new Campo('CNPJ', 'empcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpCod->setBCampoBloqueado(true);

        $oEmpDes = new Campo('Empresa', 'empdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmpDes->setBCampoBloqueado(true);

        $oModelo = new Campo('Fabricante/Modelo', 'modelo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oModelo->setBCampoBloqueado(true);

        $oCor = new Campo('Cor', 'cor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCor->setBCampoBloqueado(true);

        $oSetor = new Campo('Setor', 'setor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oSetor->setBCampoBloqueado(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_Transito","buscaPlaca","' . $oPlaca->getId() . ',' . $oEmpCod->getId() . ',' . $oEmpDes->getId() . ',' . $oSetor->getId() . ',' . $oModelo->getId() . ',' . $oCor->getId() . '");';

        if ($sAcao != 'acaoVisualiza') {
            $oPlaca->addEvento(Campo::EVENTO_SAIR, $sCallBack);
        }

        if ($sAcao == 'acaoAlterar') {

            $oHistorico = new Campo('Por que foi alterado?', 'historico', Campo::TIPO_HISTORICO);
            $oHistorico->addValidacao(false, Validacao::TIPO_STRING, '', '20', '300');
            $oHistorico->setILinhasTextArea(4);
            $oHistorico->setApenasTela(true);
            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oMotivo), $oDivisor1, $oDescMotivo, $oDivisor2, $oPlaca, array($oMotorista, $oDocMotorista, $oFone), array($oEmpCod, $oEmpDes), array($oModelo, $oCor, $oSetor, $oUsuCod, $oSituaca), $oHistorico);
        } else {
            $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDataCad, $oHoraEntra), array($oMotivo), $oDivisor1, $oDescMotivo, $oDivisor2, $oPlaca, array($oMotorista, $oDocMotorista, $oFone), array($oEmpCod, $oEmpDes), array($oModelo, $oCor, $oSetor, $oUsuCod, $oSituaca));
        }
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

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->setSValor($oDados->getPlaca());
        $oPlaca->setBCampoBloqueado(true);
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDivisor1 = new Campo('Dados da saída', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataSaida = new Campo('Data saída', 'datasaida', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataSaida->setSValor(date('d/m/Y'));
        $oDataSaida->setBCampoBloqueado(true);
        $oDataSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oHoraSaida = new Campo('Hora saída', 'horasaida', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraSaida->setSValor(date('H:i:s'));
        $oHoraSaida->setBCampoBloqueado(true);
        $oHoraSaida->setSCorFundo(Campo::FUNDO_AMARELO);

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaSaida","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);

        if ($oDados->getDescmotivo() != null || $oDados->getDescmotivo() != '') {
            $oDescMotivo = new Campo('Descrição do motivo', 'descmotivo', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
            $oDescMotivo->setSValor($oDados->getDescmotivo());
            $oDescMotivo->setBCampoBloqueado(true);
            $oDescMotivo->setILinhasTextArea(4);

            $this->addCampos(array($oNr, $oPlaca, $oEmpresa, $oMotivo), $oDescMotivo, $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
        } else {
            $this->addCampos(array($oNr, $oPlaca, $oEmpresa, $oMotivo), $oDivisor1, array($oDataSaida, $oHoraSaida, $oFilcgc), $oLinha, $oBtnInserir);
        }
    }

}
