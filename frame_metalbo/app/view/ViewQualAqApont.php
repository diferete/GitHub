<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqApont extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();
        // $this->setBTela(true);
        $aDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oEmpresa->setSValor($aDados['EmpRex_filcgc']);
        $oEmpresa->setBCampoBloqueado(true);
        $oEmpresa->setBOculto(true);
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 1, 1);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);

        $oGridAq = new campo('Plano de ação', 'gridAcao', Campo::TIPO_GRID, 12, 12, 12, 12, 150);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(1);

        $oPlano = new CampoConsulta('Plano', 'plano');
        $oPlano->setILargura(400);

        $oAnexo = new CampoConsulta('Anexo', 'AnexoFim', CampoConsulta::TIPO_DOWNLOAD);

        //$oAnexo2 = new CampoConsulta('Anexo2', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $oDaPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oDataRealiz = new CampoConsulta('Data realizada', 'datafim', CampoConsulta::TIPO_DATA);

        $oSit = new CampoConsulta('Situação', 'sitfim');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oEfi = new CampoConsulta('Nr.Ef', 'nrEfi');


        $oGridAq->addCampos($oSeq, $oPlano, $oDaPrev, $oDataRealiz, $oSit, $oAnexo, $oEfi);
        $oGridAq->setSController('QualAqApont');
        $oGridAq->addParam('seq', '0');

        $oSeqEnv = new Campo('Sêquencia', 'seq', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        
        $oPlanEnv = new campo('Plano de ação', 'plano', Campo::TIPO_TEXTAREA, 10, 10, 10, 10);
        $oPlanEnv->setBCampoBloqueado(true);
        $oPlanEnv->setILinhasTextArea(4);

        $oDataFim = new Campo('Data Finalização', 'datafim', Campo::TIPO_DATA, 2, 2, 2, 2);
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oDataFim->setSCorFundo(Campo::FUNDO_AMARELO);

        $oObsFim = new Campo('Observação final', 'obsfim', Campo::TIPO_TEXTAREA, 8, 8, 8, 8);
        $oObsFim->setICaracter(1000);
        $oObsFim->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObsFim->setILinhasTextArea(3);

        $oAnexoFim = new campo('Anexo', 'anexofim', Campo::TIPO_UPLOAD, 2);
        $oAnexoFim->setIMarginTop(3);

        $oGridAq->getOGrid()->setSEventoClick('var chave=""; $("#' . $oGridAq->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","QualAqApont","sendaDadosCampos","' . $oGridAq->getId() . '"+","+chave+","+"' . $oSeqEnv->getId() . '"+","+"' . $oPlanEnv->getId() . '"+","+"' . $oDataFim->getId() . '"+","+"' . $oObsFim->getId() . '"); ');

        $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","QualAqApont","getDadosGrid","' . $oGridAq->getId() . '","criaConsutaApont"); ';

        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        $sGrid = $oGridAq->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaPlanoAcao","' . $this->getTela()->getId() . '-form,' . $sGrid . ',' . $oAnexoFim->getId() . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        $this->getTela()->setSAcaoShow($sAcaoBusca);


        $sAcaoRet = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRetAberto","' . $this->getTela()->getId() . '-form,' . $sGrid . ',' . $oAnexoFim->getId() . '","");';
        $oBtnNormal = new Campo('Ret. Aberta', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);


        $this->addCampos($oGridAq, $oPlanEnv, array($oDataFim, $oAnexoFim), array($oObsFim, $oBtnInserir, $oBtnNormal), array($oSeqEnv, $oEmpresa, $oNr));
    }

    public function criaConsutaApont() {
        $oGridAq = new Grid("");

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);
        $oPlano = new CampoConsulta('Plano', 'plano');
        $oPlano->setILargura(400);

        $oAnexo = new CampoConsulta('Anexo', 'AnexoFim', CampoConsulta::TIPO_DOWNLOAD);
        $oAnexo->setILargura(300);
        $oDaPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);
        $oDataRealiz = new CampoConsulta('Data realizada', 'datafim', CampoConsulta::TIPO_DATA);
        $oSit = new CampoConsulta('Situação', 'sitfim');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oEfi = new CampoConsulta('Nr.Ef', 'nrEfi');

        $oGridAq->addCampos($oSeq);
        $oGridAq->addCampos($oPlano);


        $oGridAq->addCampos($oDaPrev);
        $oGridAq->addCampos($oDataRealiz);
        $oGridAq->addCampos($oSit);
        $oGridAq->addCampos($oAnexo);
        $oGridAq->addCampos($oEfi);

        $aCampos = $oGridAq->getArrayCampos();
        return $aCampos;
    }

}
