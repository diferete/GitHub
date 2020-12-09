<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_HorasParadas extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oForno = new CampoConsulta('Forno', 'fornocod');

        $oSeq = new CampoConsulta('seq', 'seq');

        $oFornoDes = new CampoConsulta('fornodes', 'fornodes');

        $oUsuNome = new CampoConsulta('usunome', 'usunome');

        $oMotivo = new CampoConsulta('motivo', 'motivo');

        $oDataIni = new CampoConsulta('dataini', 'dataini', CampoConsulta::TIPO_DATA);

        $oHoraIni = new CampoConsulta('horaini', 'horaini', CampoConsulta::TIPO_TIME);

        $oDataFim = new CampoConsulta('datafim', 'datafim', CampoConsulta::TIPO_DATA);

        $oHoraFim = new CampoConsulta('horafim', 'horafim', CampoConsulta::TIPO_TIME);

        $oTempoParada = new CampoConsulta('Tempo de parada', 'tempoparada');

        $this->addCampos($oForno, $oSeq, $oFornoDes, $oMotivo, $oUsuNome, $oDataIni, $oHoraIni, $oDataFim, $oHoraFim, $oTempoParada);
    }

    function criaGridDetalhe($sAcaoRotina) {
        parent::criaGridDetalhe($sIdAba);

        $this->getOGridDetalhe()->setIAltura(200);

        $oForno = new CampoConsulta('Forno', 'fornocod');

        $oSeq = new CampoConsulta('seq', 'seq');

        $oFornoDes = new CampoConsulta('fornodes', 'fornodes');

        $oUsuNome = new CampoConsulta('usunome', 'usunome');

        $oMotivo = new CampoConsulta('motivo', 'motivo');

        $oDataIni = new CampoConsulta('dataini', 'dataini', CampoConsulta::TIPO_DATA);

        $oHoraIni = new CampoConsulta('horaini', 'horaini', CampoConsulta::TIPO_TIME);

        $oDataFim = new CampoConsulta('datafim', 'datafim', CampoConsulta::TIPO_DATA);

        $oHoraFim = new CampoConsulta('horafim', 'horafim', CampoConsulta::TIPO_TIME);

        $oTempoParada = new CampoConsulta('Tempo de parada', 'tempoparada');

        $this->addCamposDetalhe($oForno, $oSeq, $oFornoDes, $oMotivo, $oUsuNome, $oDataIni, $oHoraIni, $oDataFim, $oHoraFim, $oTempoParada);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();
        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

        $this->criaGridDetalhe($sAcaoRotina);
        $aParam = $this->getAParametrosExtras();

        $oForno = new Campo('Código', 'fornocod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oForno->setSValor($aParam[0]);

        $oFornoDes = new Campo('Descrição', 'fornodes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFornoDes->setSValor($aParam[1]);

        $oSeq = new Campo('NR', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oUsuNome = new Campo('Nome', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuNome->setSValor($_SESSION['nome']);
        $oUsuNome->setBCampoBloqueado(true);

        $oDivisor = new Campo('Início da parada', 'inicio', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oDataIni = new Campo('Data', 'dataini', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oHoraIni = new Campo('Hora', 'horaini', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraIni->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oHoraIni->setBTime(true);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraIni->setSValor(date('H:i'));

        $oDivisor1 = new Campo('Retorno da parada', 'retorno', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataFim = new Campo('Data', 'datafim', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oHoraFim = new Campo('Hora', 'horafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHoraFim->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oHoraFim->setBTime(true);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraFim->setSValor(date('H:i'));

        $oMotivo = new Campo('Motivo', 'motivo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotivo->addItemSelect('Teste', 'Teste');

        $oBtnConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sGrid = $this->getOGridDetalhe()->getSId();

        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . '","' . $oForno->getSValor() . ',' . $oSeq->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBtnConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos(array($oForno, $oFornoDes, $oUsuNome, $oSeq), array($oDataIni, $oHoraIni), $oMotivo);
        } else {
            $this->addCampos(array($oForno, $oFornoDes, $oUsuNome, $oSeq), $oDivisor, array($oDataIni, $oHoraIni), $oDivisor1, array($oDataFim, $oHoraFim), $oMotivo, $oBtnConf);
        }
        $this->addCamposFiltroIni($oForno);
    }

}
