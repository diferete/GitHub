<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Updates extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oSeq = new CampoConsulta('Seq', 'seq');

        $oSeqUpdates = new CampoConsulta('Seq.Upd.', 'sequpdates');

        $oQuemVe = new CampoConsulta('Quem vê?', 'descsetor');

        $oUpdates = new CampoConsulta('Updates', 'updates');

        $oAnexo = new CampoConsulta('Anexo', 'anexo', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCampos($oSeq, $oSeqUpdates, $oQuemVe, $oUpdates, $oAnexo);
    }

    function criaGridDetalhe($sIdAba) {
        parent::criaGridDetalhe($sIdAba);

        $this->getOGridDetalhe()->setIAltura(200);

        $oSeq = new CampoConsulta('Seq', 'seq');

        $oSeqUpdates = new CampoConsulta('Seq.Upd.', 'sequpdates');

        $oQuemVe = new CampoConsulta('Quem vê?', 'descsetor');

        $oUpdates = new CampoConsulta('Updates', 'updates');

        $oAnexo = new CampoConsulta('Anexo', 'anexo', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCamposDetalhe($oSeq, $oSeqUpdates, $oQuemVe, $oUpdates, $oAnexo);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();
        $this->criaGridDetalhe($sIdAba);

        $aDados = $this->getAParametrosExtras();

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setSValor($aDados[0]);
        $oSeq->setBCampoBloqueado(true);

        $oSeqUpdates = new Campo('Seq updates', 'sequpdates', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqUpdates->setBCampoBloqueado(true);

        $oVersao = new Campo('Versao', 'versao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVersao->setBCampoBloqueado(true);
        $oVersao->setSValor($aDados[1]);

        $oUpdates = new Campo('Update', 'updates', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);

        $oCodSetor = new Campo('Cód.Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodSetor->setSIdHideEtapa($this->getSIdHideEtapa());

        $oDescSetor = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetor->setSIdPk($oCodSetor->getId());
        $oDescSetor->setClasseBusca('MET_CAD_Setores');
        $oDescSetor->addCampoBusca('codsetor', '', '');
        $oDescSetor->addCampoBusca('descsetor', '', '');
        $oDescSetor->setSIdTela($this->getTela()->getid());
        $oDescSetor->setBCampoBloqueado(true);

        $oCodSetor->setClasseBusca('MET_CAD_Setores');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('descsetor', $oDescSetor->getId(), $this->getTela()->getId());

        $oTodosSetores = new Campo('Todos os setores', 'todos', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oAnexo = new Campo('Anexo', 'anexo', Campo::TIPO_UPLOAD, 3, 3, 12, 12);

        $oBtnConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sGrid = $this->getOGridDetalhe()->getSId();

        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeqUpdates->getId() . ',' . $sGrid . '","' . $oSeq->getSValor() . ',' . $oSeqUpdates->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBtnConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oSeq, $oSeqUpdates, $oVersao), array($oCodSetor, $oDescSetor, $oTodosSetores), $oUpdates, $oAnexo, $oBtnConf);

        $this->addCamposFiltroIni($oSeq);
    }

}
