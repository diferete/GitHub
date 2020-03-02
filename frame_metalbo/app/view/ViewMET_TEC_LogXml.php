<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_LogXml extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoExcluir(false);

        $oFilcgc = new CampoConsulta('Emp.', 'filcgc');
        $oNf = new CampoConsulta('NF', 'nf');
        $oDataLog = new CampoConsulta('Data Log', 'datalog', CampoConsulta::TIPO_DATA);
        $oHoraLog = new CampoConsulta('Hora Log', 'horalog', CampoConsulta::TIPO_TIME);
        $oTipoLog = new CampoConsulta('TIPO', 'tipolog');

        $oLogXml = new Campo('Log XML', 'logxml', Campo::TIPO_TEXTAREA, 6);
        $oLogXml->setILinhasTextArea(6);
        $oLogXml->setSCorFundo(Campo::FUNDO_AMARELO);
        $oLogXml->setBCampoBloqueado(true);

        $this->addCamposGrid($oLogXml);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_TEC_LogXml","carregaLogXml","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oLogXml->getId() . '");');


        $this->addCampos($oFilcgc, $oNf, $oTipoLog, $oDataLog, $oHoraLog);
    }

}
