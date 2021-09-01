<?php

/*
 * Implementa a classe view MET_CAD_MaquinasImagens
 * @author Cleverton Hoffmann
 * @since 03/08/2021
 */

class ViewMET_CAD_MaquinasImagens extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setIAltura(300);
        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);

        $ofil_des = new CampoConsulta('Empresa', 'DELX_FIL_Empresa.fil_fantasia', CampoConsulta::TIPO_TEXTO);
        $ofil_des->setILargura(60);
        $ocodMaq = new CampoConsulta('Código', 'MET_CAD_Maquinas.codigoMaq', CampoConsulta::TIPO_TEXTO);
        $ocodMaq->setILargura(15);
        $oseq = new CampoConsulta('Imagem', 'seq', CampoConsulta::TIPO_TEXTO);
        $oseq->setILargura(15);
        $oobs = new CampoConsulta('Observação', 'obs', CampoConsulta::TIPO_TEXTO);
        $oobs->setILargura(30);
        $olink = new CampoConsulta('Anexo', 'endimagem', CampoConsulta::TIPO_DOWNLOAD);
        $olink->setILargura(30);
        $odata = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $odata->setILargura(30);
        $odesUser = new CampoConsulta('Usuário', 'MET_TEC_USUARIO.usunome', CampoConsulta::TIPO_TEXTO);
        $odesUser->setILargura(30);

        $oFilseq = new Filtro($oseq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addFiltro($oFilseq);

        $this->addCampos($oseq, $ofil_des, $ocodMaq, $oobs, $odata, $odesUser, $olink);
    }

    public function criaTela() {
        parent::criaTela();
      
        $this->setBOcultaFechar(true);
        $this->setBOcultaBotTela(true);
        $oDados = $this->getAParametrosExtras()[0];
        $oInc = $this->getAParametrosExtras()[1];

        $ofil_codigo = new campo('Código Empresa', 'fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        if (method_exists($oDados, 'getFil_codigo')) {
            $ofil_codigo->setSValor($oDados->getFil_codigo());
            $ofil_codigo->setBCampoBloqueado(true);
        }

        $ofil_Des = new Campo('Descrição', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $ofil_Des->setSIdPk($ofil_codigo->getId());
        $ofil_Des->setClasseBusca('DELX_FIL_empresa');
        $ofil_Des->addCampoBusca('fil_codigo', '', '');
        $ofil_Des->addCampoBusca('fil_fantasia', '', '');
        $ofil_Des->setSIdTela($this->getTela()->getid());
        $ofil_Des->addValidacao(false, Validacao::TIPO_STRING);
        if (method_exists($oDados, 'getDELX_FIL_Empresa')) {
            $ofil_Des->setSValor($oDados->getDELX_FIL_Empresa()->getFil_fantasia());
            $ofil_Des->setBCampoBloqueado(true);
        }

        $ofil_codigo->setClasseBusca('DELX_FIL_empresa');
        $ofil_codigo->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $ofil_codigo->addCampoBusca('fil_fantasia', $ofil_Des->getId(), $this->getTela()->getId());

        $ocod = new campo('Código Máquina', 'cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ocod->addValidacao(false, Validacao::TIPO_INTEIRO);
        if (method_exists($oDados, 'getCodigoMaq')) {
            $ocod->setSValor($oDados->getCodigoMaq());
            $ocod->setBCampoBloqueado(true);
        }

        $ocod_Des = new Campo('Descrição', 'MET_CAD_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $ocod_Des->setSIdPk($ocod->getId());
        $ocod_Des->setClasseBusca('MET_CAD_Maquinas');
        $ocod_Des->addCampoBusca('codigoMaq', '', '');
        $ocod_Des->addCampoBusca('maquina', '', '');
        $ocod_Des->setSIdTela($this->getTela()->getid());
        $ocod_Des->addValidacao(false, Validacao::TIPO_STRING);
        if (method_exists($oDados, 'getMaquina')) {
            $ocod_Des->setSValor($oDados->getMaquina());
            $ocod_Des->setBCampoBloqueado(true);
        }

        $ocod->setClasseBusca('MET_CAD_Maquinas');
        $ocod->setSCampoRetorno('codigoMaq', $this->getTela()->getId());
        $ocod->addCampoBusca('maquina', $ocod_Des->getId(), $this->getTela()->getId());

        $oseq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        if (is_numeric($oInc)) {
            $oInc++;
            $oseq->setSValor($oInc);
        }
        $oseq->setBCampoBloqueado(true);

        $oobs = new Campo('Descrição', 'obs', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oobs->addValidacao(false, Validacao::TIPO_STRING);
        $oimagem = new Campo('Anexo', 'endimagem', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        //$oimagem->addValidacao(false, Validacao::TIPO_STRING);
                
        $odata = new Campo('Data', 'data', Campo::TIPO_DATA, 2, 2, 12, 12);
        $odata->setSValor(date('d/m/Y', strtotime("now")));
        $odata->setBCampoBloqueado(true);

        $ousuariocad = new campo('Usuário', 'coduser', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $ousuariocad->setSValor($_SESSION['codUser']);
        $ousuariocad->setBCampoBloqueado(true);

        $ousuariocaddes = new Campo('Descrição', 'MET_TEC_USUARIO.usunome', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $ousuariocaddes->setSIdPk($ousuariocad->getId());
        $ousuariocaddes->setClasseBusca('MET_TEC_USUARIO');
        $ousuariocaddes->addCampoBusca('usucodigo', '', '');
        $ousuariocaddes->addCampoBusca('usunome', '', '');
        $ousuariocaddes->setSIdTela($this->getTela()->getid());
        $ousuariocaddes->setSValor($_SESSION['nome']);
        $ousuariocaddes->addValidacao(false, Validacao::TIPO_STRING);
        $ousuariocaddes->setBCampoBloqueado(true);

        $ousuariocad->setClasseBusca('MET_TEC_USUARIO');
        $ousuariocad->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $ousuariocad->addCampoBusca('usunome', $ousuariocaddes->getId(), $this->getTela()->getId());

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        /**
         * Monta a parte do grid de consulta de imagens -------------------------------------------------------------------
         */
        $oGridImagMaq = new campo('Imagens máquina', 'gridImagMaq', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridImagMaq->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
        $oGridImagMaq->setApenasTela(true);

        $ofil_des2 = new CampoConsulta('Empresa', 'DELX_FIL_Empresa.fil_fantasia', CampoConsulta::TIPO_TEXTO);
        $ofil_des2->setILargura(60);
        $ocodMaq2 = new CampoConsulta('Código', 'MET_CAD_Maquinas.codigoMaq', CampoConsulta::TIPO_TEXTO);
        $ocodMaq2->setILargura(15);
        $odesUser2 = new CampoConsulta('Usuário', 'MET_TEC_USUARIO.usunome', CampoConsulta::TIPO_TEXTO);
        $odesUser2->setILargura(30);
        $oseq2 = new CampoConsulta('Imagem', 'seq', CampoConsulta::TIPO_TEXTO);
        $oseq2->setILargura(15);
        $oobs2 = new CampoConsulta('Observação', 'obs', CampoConsulta::TIPO_TEXTO);
        $oobs2->setILargura(30);
        $olink2 = new CampoConsulta('Anexo', 'endimagem', CampoConsulta::TIPO_DOWNLOAD);
        $olink2->setILargura(30);
        $odata2 = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $odata2->setILargura(30);
        $oGridImagMaq->addCampos($oseq2, $ofil_des2, $ocodMaq2, $oobs2, $odata2, $odesUser2, $olink2);

        $oGridImagMaq->setSController('MET_CAD_MaquinasImagens');
        if (method_exists($oDados, 'getFil_codigo')) {
            $oGridImagMaq->addParam('fil_codigo', $oDados->getFil_codigo());
        }
        if (method_exists($oDados, 'getCodigoMaq')) {
            $oGridImagMaq->addParam('cod', $oDados->getCodigoMaq());
        }

        $oGridImagMaq->getOGrid()->setIAltura(300);
        $oGridImagMaq->getOGrid()->setBGridResponsivo(true);

        $oBotInser = new Campo('INSERIR', 'test', Campo::TIPO_BOTAOSMALL, 1, 1, 2, 2);
        $oBotInser->setApenasTela(true);
        $oBotInser->setIMarginTop(6);
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_CAD_MaquinasImagens","acaoInserirImagem","' . $this->getTela()->getId() . '-form,' .
                $oseq->getId() . ',' . $oGridImagMaq->getId() . ',' . $ofil_codigo->getId() . ',' . $ocod->getId() . '","' . $ofil_codigo->getSValor() . ',' . $ocod->getSValor() . ',' . $oseq->getSValor() . '");';

        $oBotInser->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotInser->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $oBotAlter = new Campo('ALTERAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 2, 2);
        $oBotAlter->setIMarginTop(6);
        $sAcao2 = ('var chave=""; $("#' . $oGridImagMaq->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'if(chave!==""){requestAjax("' . $this->getTela()->getId() . '-form","MET_CAD_MaquinasImagens","sendDadosCamposImagem","' . $oGridImagMaq->getId() . '"+","+chave+","+"' . $oseq->getId() . '"+",'
                . '"+"' . $ofil_codigo->getId() . '"+","+"' . $ofil_Des->getId() . '"+","+"' . $ousuariocad->getId() . '"+","+"' . $ousuariocaddes->getId() . '"+","+"' . $odata->getId() . '"+","+"' . $ocod->getId() . '"+","+"' 
                . $ocod_Des->getId() . '"+","+"' . $oobs->getId() . '"+","+"' . $oimagem->getId() . '");} ');
        $oBotAlter->addAcaoBotao($sAcao2);
        
        //----------------------------------------------------------------------------------------------------------------

        $this->addCampos(array($oseq, $ofil_codigo, $ofil_Des, $ousuariocad, $ousuariocaddes, $odata), $oLinha1, array($ocod, $ocod_Des), $oLinha1, $oobs, $oLinha1, array($oimagem), array($oBotInser, $oBotAlter), $oLinha1, $oGridImagMaq);

    }

}
