<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_RegistroTreinamento extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oData = new CampoConsulta('Data', 'data_treinamento', CampoConsulta::TIPO_DATA);
        $oTitTreinamento = new CampoConsulta('Treinamento', 'titulo_treinamento');

        $oAnexo = new CampoConsulta('Anexo', 'anexo_treinamento', CampoConsulta::TIPO_DOWNLOAD);
        $oAnexo->setSDiretorioManual('RTs');


        $oObs = new Campo('Observações', '', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setILinhasTextArea(6);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setApenasTela(true);
        $oObs->setBCampoBloqueado(true);

        $this->addCamposGridDetalhe($oObs);
        $this->getOGridDetalhe()->setIAltura(300);

        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA, 1, 1, 12, 12, false);

        $oFilSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->getOGridDetalhe()->setSEventoClick('var chave=""; $("#' . $this->getOGridDetalhe()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'var idCampos ="' . $oObs->getId() . '";'
                . 'requestAjax("","MET_ISO_RegistroTreinamento","carregaObs","' . $this->getOGridDetalhe()->getSId() . '"+","+chave+","+idCampos+"");');

        $this->addCamposDetalhe($oNr, $oFilcgc, $oSeq, $oData, $oTitTreinamento, $oAnexo);
        $this->addFiltrosDetalhe($oFilData, $oFilSeq);
        $this->getOGridDetalhe()->setBFiltroDetalhe(true);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr', 'nr');
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oData = new CampoConsulta('Data', 'data_treinamento', CampoConsulta::TIPO_DATA);
        $oTitTreinamento = new CampoConsulta('Treinamento', 'titulo_treinamento');
        $oAnexo = new CampoConsulta('Anexo', 'anexo_treinamento', CampoConsulta::TIPO_DOWNLOAD);
        $oAnexo->setSDiretorioManual('RTs');

        $this->addCampos($oNr, $oFilcgc, $oSeq, $oData, $oTitTreinamento, $oAnexo);
    }

    public function criaTela() {
        parent::criaTela();

        $aParam = $this->getAParametrosExtras();
        $this->criaGridDetalhe();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aParam[1]);
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new Campo('Emp.', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($aParam[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oUsuario = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuario->setSValor($_SESSION['nome']);
        $oUsuario->setBCampoBloqueado(true);

        $oColaborador = new Campo('Colaborador', 'colaborador', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oColaborador->setApenasTela(true);
        $oColaborador->setSValor();
        $oColaborador->setSCorFundo(Campo::FUNDO_AMARELO);
        $oColaborador->setSValor($aParam[2]);
        $oColaborador->setBCampoBloqueado(true);

        $oData = new Campo('Data', 'data_treinamento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        //date_default_timezone_set('America/Sao_Paulo');
        $oData->setSValor(date('d-m-Y'));
        $oData->setBOculto(true);

        $oCodTitulo = new Campo('...', 'cod_treinamento', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodTitulo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodTitulo->setBOculto(true);

        $oTitulo = new Campo('Treinamento', 'titulo_treinamento', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTitulo->setSIdPk($oCodTitulo->getId());
        $oTitulo->setClasseBusca('MET_ISO_Documentos');
        $oTitulo->addCampoBusca('nr', '', '');
        $oTitulo->addCampoBusca('documento', '', '');
        $oTitulo->setSIdTela($this->getTela()->getid());
        $oTitulo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodTitulo->setClasseBusca('MET_ISO_Documentos');
        $oCodTitulo->setSCampoRetorno('nr', $this->getTela()->getId());
        $oCodTitulo->addCampoBusca('documento', $oTitulo->getId(), $this->getTela()->getId());

        $oRevisao = new Campo('Revisao', 'revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRevisao->setBCampoBloqueado(true);

        $oObs = new Campo('Observação', 'observacao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setILinhasTextArea(3);

        $oAnexo = new Campo('Documento', 'anexo_treinamento', Campo::TIPO_UPLOAD, 3, 3, 12, 12);
        $oAnexo->setSDiretorio('RTs');
        $oAnexo->setBNomeArquivo(true);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);

        $sGrid = $this->getOGridDetalhe()->getSId();
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oObs->getId() . ',' . $oAnexo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $oTitulo->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_RegistroTreinamento","buscaDadosDocumento","' . $oCodTitulo->getId() . ',' . $oTitulo->getId() . ',' . $oRevisao->getId() . '");');

        $this->addCampos(array($oNr, $oFilcgc, $oSeq, $oUsuario, $oData, $oColaborador), array($oCodTitulo, $oTitulo, $oRevisao, $oAnexo), $oObs, $oBotConf);
        $this->addCamposFiltroIni($oNr, $oFilcgc);
    }

}
