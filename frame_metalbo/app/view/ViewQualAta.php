<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAta extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilcgc = new CampoConsulta('Cnpj', 'filcgc');
        $oNr = new CampoConsulta('Nr.', 'nr');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oTitulo = new CampoConsulta('Título', 'titulo');
        $oData = new CampoConsulta('Data', 'data');
        $oHora = new CampoConsulta('Hora', 'hora');


        $this->addCampos($oFilcgc, $oNr, $oSeq, $oTitulo, $oData, $oHora);
    }

    public function criaTela() {
        parent::criaTela();

        $oGridAta = new campo('Atas', 'gridAta', Campo::TIPO_GRID, 12, 12, 12, 12, 250);

        $oNrGrid = new CampoConsulta('Nr', 'nr');
        $oNrGrid->setILargura(30);

        $oSeqGrid = new CampoConsulta('Seq.', 'seq');
        $oSeqGrid->setILargura(30);

        $oTituloGrid = new CampoConsulta('Título', 'titulo');

        $oDataHora = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oHoraGrid = new CampoConsulta('Hora', 'hora');
        $oObsGrid = new CampoConsulta('Obs', 'obs');
        $oAnexoGrid = new CampoConsulta('Ata', 'anexo', CampoConsulta::TIPO_DOWNLOAD);
        //$oAnexoGrid->setILargura(150);

        $oGridAta->addCampos($oNrGrid, $oSeqGrid, $oTituloGrid, $oDataHora, $oAnexoGrid);
        $oGridAta->setSController('QualAta');
        $oGridAta->addParam('seq', '0');
        //,$oTituloGrid,$oDataHora,$oHoraGrid,$oObsGrid

        $aDados = $this->getAParametrosExtras();
        $oFilcgc = new Campo('Cnpj', 'filcgc', Campo::TIPO_TEXTO, 2);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBCampoBloqueado(true);
        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1);
        $oSeq->setBCampoBloqueado(true);
        $oTitulo = new Campo('Título', 'titulo', Campo::TIPO_TEXTO, 4);
        $oTitulo->setBFocus(true);
        $oData = new Campo('Data', 'data', Campo::TIPO_DATA, 2);
        $oData->setSValor(date('d/m/Y'));
        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1);
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);
        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 6);
        $oAnexo = new Campo('Ata', 'anexo', Campo::TIPO_UPLOAD, 3);

        //botão inserir os dados
        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        $sGrid = $oGridAta->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontAta","' . $this->getTela()->getId() . '-form,' . $sGrid . ',' . $oSeq->getId() . ',' . $oAnexo->getId() . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","QualAta","getDadosGrid","' . $oGridAta->getId() . '","consultaAta");';
        $this->getTela()->setSAcaoShow($sAcaoBusca);

        $sAcao = 'var chave=""; $("#' . $oGridAta->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getId() . '-form","QualAta","excluirAta","' . $this->getTela()->getId() . '-form,' . $oGridAta->getId() . '"+","+chave+""); '; // excluirEf
        $oBtnDelete = new Campo('Deletar', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $oBtnDelete->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $oBtnDelete->getOBotao()->addAcao($sAcao);

        $oLinha = new Campo('', '', Campo::TIPO_LINHA);

        $this->addCampos(array($oFilcgc, $oNr, $oSeq, $oHora), $oTitulo, array($oData, $oAnexo),$oObs, array($oBtnInserir), $oLinha, $oBtnDelete, $oGridAta);
    }

    public function consultaAta() {
        $oGridAta = new Grid("");


        $oNrGrid = new CampoConsulta('Nr', 'nr');
        $oNrGrid->setILargura(30);

        $oSeqGrid = new CampoConsulta('Seq.', 'seq');
        $oSeqGrid->setILargura(30);

        $oTituloGrid = new CampoConsulta('Título', 'titulo');

        $oDataHora = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);

        $oHoraGrid = new CampoConsulta('Hora', 'hora');

        $oObsGrid = new CampoConsulta('Obs', 'obs');

        $oAnexoGrid = new CampoConsulta('Ata', 'anexo', CampoConsulta::TIPO_DOWNLOAD);
        // $oAnexoGrid->setILargura(150);
        $oGridAta->addCampos($oNrGrid, $oSeqGrid, $oTituloGrid, $oDataHora, $oAnexoGrid);

        //,$oTituloGrid,$oDataHora,$oHoraGrid,$oObsGrid


        $aCampos = $oGridAta->getArrayCampos();
        return $aCampos;
    }

}
