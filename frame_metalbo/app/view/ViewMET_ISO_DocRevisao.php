<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_DocRevisao extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oSeq = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $oUsuario = new CampoConsulta('Usuário', 'usuario', CampoConsulta::TIPO_TEXTO);
        $oDoc = new CampoConsulta('Documento', 'arquivo', CampoConsulta::TIPO_DOWNLOAD);
        $oDoc->setSDiretorioManual('Revisao de documentos');
        $oRev = new CampoConsulta('Revisão', 'revisao', CampoConsulta::TIPO_TEXTO);
        $oDataRev = new CampoConsulta('Data da Revisão', 'data_revisao', CampoConsulta::TIPO_DATA);
        $oDescFunc = new CampoConsulta('Documento', 'descricao', CampoConsulta::TIPO_TEXTO);

        $oObs = new Campo('Observação de alterações', '', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setILinhasTextArea(6);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setApenasTela(true);
        $oObs->setBCampoBloqueado(true);

        $this->addCamposGridDetalhe($oObs);

        $this->getOGridDetalhe()->setSEventoClick('var chave=""; $("#' . $this->getOGridDetalhe()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'var idCampos ="' . $oObs->getId() . '";'
                . 'requestAjax("","MET_ISO_DocRevisao","carregaObs","' . $this->getOGridDetalhe()->getSId() . '"+","+chave+","+idCampos+"");');

        $this->addCamposDetalhe($oNr, $oFilcgc, $oSeq, $oUsuario, $oRev, $oDataRev, $oDescFunc, $oDoc);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oSeq = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $oUsuario = new CampoConsulta('Usuário', 'usuario', CampoConsulta::TIPO_TEXTO);
        $oDoc = new CampoConsulta('Documento', 'arquivo', CampoConsulta::TIPO_DOWNLOAD);
        $oDoc->setSDiretorioManual('Revisao de documentos');
        $oRev = new CampoConsulta('Revisão', 'revisao', CampoConsulta::TIPO_TEXTO);
        $oDataRev = new CampoConsulta('Data da Revisão', 'data_revisao', CampoConsulta::TIPO_DATA);
        $oDescFunc = new CampoConsulta('Documento', 'descricao', CampoConsulta::TIPO_TEXTO);

        $this->addCampos($oNr, $oFilcgc, $oSeq, $oUsuario, $oRev, $oDataRev, $oDescFunc, $oDoc);
    }

    public function criaTela() {
        parent::criaTela();


        $aParam = $this->getAParametrosExtras();
        $this->criaGridDetalhe();

        $oFilcgc = new Campo('Emp', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($aParam[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aParam[1]);
        $oNr->setBCampoBloqueado(true);

        $oUsuario = new Campo('User', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuario->setSValor($_SESSION['nome']);
        $oUsuario->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oDescricao = new Campo('Documento', 'descricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oDescricao->setSValor($aParam[2]);
        $oDescricao->setSCorFundo(Campo::FUNDO_AMARELO);

        $oRevisao = new Campo('Revisao', 'revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRevisao->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 1);

        $oDataRevisao = new Campo('data', 'data_revisao', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oDataRevisao->setSValor(date('d/m/Y'));

        $oObs = new Campo('Obs.', 'observacao', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setILinhasTextArea(3);

        $oArquivo = new Campo('Anexo', 'arquivo', Campo::TIPO_UPLOAD, 3, 3, 12, 12);
        $oArquivo->setSDiretorio('Revisao de documentos');
        $oArquivo->setBNomeArquivo(true);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);

        $sGrid = $this->getOGridDetalhe()->getSId();
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oObs->getId() . ',' . $oArquivo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oNr, $oFilcgc, $oUsuario, $oSeq, $oDataRevisao), array($oDescricao), $oArquivo, $oRevisao, $oObs, $oBotConf);
        $this->addCamposFiltroIni($oNr, $oFilcgc);
    }

}
