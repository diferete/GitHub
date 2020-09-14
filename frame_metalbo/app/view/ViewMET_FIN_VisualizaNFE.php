<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_FIN_VisualizaNFE extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);
        $this->setUsaFiltro(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBMostraFiltro(true);

        $oBotaoEmitXml = new CampoConsulta('', 'emiteXml', CampoConsulta::TIPO_ACAO, CampoConsulta::ICONE_ENVIAR);
        $oBotaoEmitXml->setSTitleAcao('Emite XML!');
        $oBotaoEmitXml->addAcao('MET_FIN_VisualizaNFE', 'enviaXML', '', '');
        $oBotaoEmitXml->setBHideTelaAcao(true);
        $oBotaoEmitXml->setILargura(30);

        $oFilcgc = new CampoConsulta('Emp.', 'nfsfilcgc');
        $oFilcgc->setBColOculta(true);
        $oNf = new CampoConsulta('Nr. NF', 'nfsnfnro');
        $oNf->setSOperacao('personalizado');
        $oNfSerie = new CampoConsulta('Série', 'nfsnfser');
        $oCliNome = new CampoConsulta('Cliente', 'nfsclinome');
        $oNfDtEmiss = new CampoConsulta('Data Emiss.', 'nfsdtemiss', CampoConsulta::TIPO_DATA);

        $oSitNf = new CampoConsulta('Situação SEFAZ', 'nfsnfesit');
        $oSitNf->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Autorizada');
        $oSitNf->addComparacao('Z', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_LINHA, true, 'Enviando SEFAZ');
        $oSitNf->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'Cancelada');
        $oSitNf->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_LINHA, true, 'Enviada');
        $oSitNf->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Em processo');
        $oSitNf->setBComparacaoColuna(true);


        $oNfEnvEmail = new CampoConsulta('Email XML', 'nfsemailen');
        $oNfEnvEmail->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, true, 'Xml Enviado');
        $oNfEnvEmail->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Não Enviado');

        $oFilEMP = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilEMP->setSLabel('');
        $oFilEMP->addItemSelect('', 'Empresas');
        $oFilEMP->addItemSelect('75483040000211', 'FILIAL');
        $oFilEMP->addItemSelect('75483040000130', 'REX');

        $oFilNF = new Filtro($oNf, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);

        $oFilEnvEmail = new Filtro($oNfEnvEmail, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilEnvEmail->addItemSelect('', 'Todos');
        $oFilEnvEmail->addItemSelect('S', 'Xml Enviado');
        $oFilEnvEmail->setSLabel('');

        $oFilCliNome = new Filtro($oCliNome, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $oFilData = new Filtro($oNfDtEmiss, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);
        $oFilData->addFiltroValor(date('d/m/Y'));
        $oFilData->addFiltroValor(date('d/m/Y'));

        $oDrop1 = new Dropdown('Visualizar Danfe', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Visualizar', $this->getController(), 'acaoMostraRelConsulta', '', false, 'DanfeVisualiza', false, '', false, '', false, false);

        if ($_SESSION['codsetor'] == 2) {
            $oDrop2 = new Dropdown('Enviar XMLs manual', Dropdown::TIPO_AVISO, Dropdown::ICON_EMAIL);
            $oDrop2->addItemDropdown($this->addIcone(Base::ICON_ARROW_UP) . 'Enviar', $this->getController(), 'enviaXmlsManual', '', false, '', false, '', false, '', false, true);
            $this->addDropdown($oDrop1, $oDrop2);
        } else {
            $this->addDropdown($oDrop1);
        }
        $this->addFiltro($oFilEMP, $oFilNF, $oFilEnvEmail, $oFilCliNome, $oFilData);
        $this->addCampos($oBotaoEmitXml, $oNf, $oNfSerie, $oCliNome, $oNfDtEmiss, $oSitNf, $oNfEnvEmail, $oFilcgc);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
