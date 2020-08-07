<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_NfSaida extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaFiltro(true);
        $this->setUsaDropdown(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBMostraFiltro(true);

        $oBotaoEmitXml = new CampoConsulta('', 'emiteXml', CampoConsulta::TIPO_ACAO, CampoConsulta::ICONE_ENVIAR);
        $oBotaoEmitXml->setSTitleAcao('Emite XML!');
        $oBotaoEmitXml->addAcao('STEEL_PCP_NfSaida', 'enviaXML', '', '');
        $oBotaoEmitXml->setBHideTelaAcao(true);
        $oBotaoEmitXml->setILargura(30);

        $oFilial = new CampoConsulta('Teste', 'NFS_NotaFiscalFilial');
        $oFilial->setBColOculta(true);

        $oSeq = new CampoConsulta('Seq.', 'NFS_NotaFiscalSeq');
        $oSeq->setSOperacao('personalizado');

        $oNrNf = new CampoConsulta('Nr', 'NFS_NotaFiscalNumero');

        $oEmp = new CampoConsulta('Empresa', 'NFS_NotaFiscalEmpEntDescricao');

        $oDataEmissao = new CampoConsulta('Data', 'NFS_NotaFiscalDataEmissao', CampoConsulta::TIPO_DATA);

        $oSitXML = new CampoConsulta('Situação', 'NFS_NotaFiscalNfeSituacao');
        $oSitXML->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Autorizada');
        $oSitXML->addComparacao('Z', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Enviando');
        $oSitXML->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'Cancelada');
        $oSitXML->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Em processo');
        $oSitXML->setBComparacaoColuna(true);

        $oNfEnvEmail = new CampoConsulta('Email', 'nfsemailen');
        $oNfEnvEmail->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');

        $oDrop = new Dropdown('Visualizar Danfe', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Visualizar', $this->getController(), 'acaoMostraRelConsulta', '', false, 'DanfeVisualiza', false, '', false, '', false, false);

        $oFilNF = new Filtro($oNrNf, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);

        $oFilCliNome = new Filtro($oEmp, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $oFilData = new Filtro($oDataEmissao, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);
        $oFilData->addFiltroValor(date('d/m/Y'));
        $oFilData->addFiltroValor(date('d/m/Y'));

        $this->addFiltro($oFilNF, $oFilCliNome, $oFilData);

        $this->addDropdown($oDrop);
        $this->addCampos($oBotaoEmitXml, $oSeq, $oNrNf, $oEmp, $oDataEmissao, $oSitXML, $oFilial);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
