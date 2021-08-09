<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNfent extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oNfDoc = new CampoConsulta('Documento', 'nfdoc');
        $oNfDoc->setILargura(50);

        $oNfSer = new CampoConsulta('Série', 'nfserie');

        $oPesCnpj = new CampoConsulta('Código Pessoa', 'pescnpj');

        $oPesRazao = new CampoConsulta('Razão', 'pesnome_razao');
        $oPesRazao->setILargura(300);

        $oTipo = new CampoConsulta('Tipo Doc.', 'nftipo');

        $oDataEmi = new CampoConsulta('Data emissão', 'nfdataemi');
        $oDataEmi->setILargura(300);

        $oVlrTot = new CampoConsulta('Valor Total', 'nfvlrtot', CampoConsulta::TIPO_DECIMAL);
        $oVlrTot->setILargura(200);

        $oEmpresa = new CampoConsulta('Empresa', 'empcnpj');

        $oNfFinan = new CampoConsulta('Financeiro', 'nf_finan');
        $oNfFinan->addComparacao('Com Financeiro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oNfFinan->addComparacao('Com Financeiro', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oNfFinan->setILargura(200);

        $oUserCadastro = new CampoConsulta('Usuário', 'nfusuins');
        $oUserCadastro->setILargura(200);

        $oHoraData = new CampoConsulta('Data Lanç.', 'nfhorains');
        $oHoraData->setILargura(200);

        $this->setUsaDropdown(true);

        $oDrop1 = new Dropdown('Financeiro ', Dropdown::TIPO_PADRAO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG) . 'Adiciona Financeiro', 'Contpagar', 'acaoMostraTelaIncluir', '', true, '', false, '', false, '', false, false);




        $this->addCampos($oNfDoc, $oPesCnpj, $oTipo, $oPesRazao, $oVlrTot, $oNfFinan, $oHoraData);
        $this->addDropdown($oDrop1);

        $oFRazao = new Filtro($oPesRazao, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);




        $this->addFiltro($oFRazao);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Inclusão de Notas Fiscais');

        $oNfEmp = new Campo('Empresa', 'empcnpj', Campo::TIPO_TEXTO, 2);
        $oNfEmp->setSValor('21804925000165');
        $oNfEmp->setBCampoBloqueado('true');
        $oNfEmp->setITamanho(Campo::TAMANHO_PEQUENO);

        $oNfDoc = new Campo('Documento', 'nfdoc', Campo::TIPO_TEXTO, 1);

        $oNfSerie = new Campo('Série', 'nfserie', Campo::TIPO_TEXTO, 1);
        $oNfSerie->setSValor('1');

        $oNfCnpj = new Campo('Código Pessoa', 'pescnpj', Campo::TIPO_BUSCADOBANCOPK, 2);

        $oEmpresa = new Campo('Razão Social', 'pesnome_razao', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oNfCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('pescnpj', '', '');
        $oEmpresa->addCampoBusca('pesnome_razao', '', '');

        $oNfCnpj->setClasseBusca('Pessoa');
        $oNfCnpj->setSCampoRetorno('pescnpj', $this->getTela()->getId());
        $oNfCnpj->addCampoBusca('pesnome_razao', $oEmpresa->getId(), $this->getTela()->getId());

        $oNfDataEnt = new Campo('Data Emissão', 'nfdataemi', Campo::TIPO_DATA, 2); //nfdatacheg
        $oNfDataCheg = new Campo('Data Chegada', 'nfdatacheg', Campo::TIPO_DATA, 2); //nfhoracheg
        $oNfHoraCheg = new Campo('Chegada', 'nfhoracheg', Campo::TIPO_TEXTO, 1);
        $oNfHoraCheg->setBTime(true); //nftipo

        $oNfTipo = new Campo('Tipo Documento', 'nftipo', Campo::TIPO_SELECT);
        $oNfTipo->addItemSelect('nf', 'Nota Fiscal');
        $oNfTipo->addItemSelect('cupom', 'Cupom Fiscal');
        $oNfTipo->addItemSelect('recibo', 'Recibo');
        $oNfTipo->addItemSelect('boleto', 'Boleto');

        $oFieldValores = new FieldSet('Valores');

        $oNfTotProd = new Campo('Vlr Produtos', 'nftotprod', Campo::TIPO_TEXTO, 1);
        $oNfTotProd->setSValor('0');

        $oNfBaseIcms = new Campo('Base Icms', 'nfbaseicm', Campo::TIPO_TEXTO, 1);
        $oNfBaseIcms->setSValor('0');

        $oNfIcms = new Campo('Icms', 'nfvlricm', Campo::TIPO_TEXTO, 1);
        $oNfIcms->setSValor('0');

        $oNfBaseSt = new Campo('Base St', 'nfbasest', Campo::TIPO_TEXTO, 1);
        $oNfBaseSt->setSValor('0');

        $oNfVlrSt = new Campo('Vlr ST', 'nfvlrst', Campo::TIPO_TEXTO, 1);
        $oNfVlrSt->setSValor('0');

        $oNfVlrIpi = new Campo('Ipi', 'nfvlripi', Campo::TIPO_TEXTO, 1);
        $oNfVlrIpi->setSValor('0');

        $oNf_frete = new Campo('Frete', 'nf_frete', Campo::TIPO_TEXTO, 1);
        $oNf_frete->setSValor('0');

        $oNfTotal = new Campo('Valor Total', 'nfvlrtot', Campo::TIPO_TEXTO, 2);
        $oNfTotal->setSValor('0');

        $oFieldValores->addCampos(array($oNfTotProd, $oNfBaseIcms, $oNfIcms, $oNfBaseSt, $oNfVlrSt, $oNfVlrIpi, $oNf_frete, $oNfTotal));

        $oNfobs = new Campo('Observação de compra', 'nfobs', Campo::TIPO_TEXTAREA, 8);

        $oUsuIns = new Campo('Usuário Cadastro', 'nfusuins', Campo::TIPO_TEXTO, 3);
        $oUsuIns->setSValor($_SESSION['nome']);
        $oUsuIns->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUsuIns->setBCampoBloqueado(true);

        $oUsuHoraCad = new Campo('Data Hora', 'nfhorains', Campo::TIPO_TEXTO, 2);
        $oUsuHoraCad->setSValor(date('Y/m/d H:i:s'));
        $oUsuHoraCad->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUsuHoraCad->setBCampoBloqueado(true);

        //eventos dos valores dos campos
        $oNfTotProd->addEvento(Campo::EVENTO_SAIR, 'var vlrprod = $("#' . $oNfTotProd->getId() . '").val();'
                . '$("#' . $oNfTotProd->getId() . '").val(moedaParaNumero(vlrprod));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfBaseIcms->addEvento(Campo::EVENTO_SAIR, 'var vlrbase = $("#' . $oNfBaseIcms->getId() . '").val();'
                . '$("#' . $oNfBaseIcms->getId() . '").val(moedaParaNumero(vlrbase));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfIcms->addEvento(Campo::EVENTO_SAIR, 'var vlricms = $("#' . $oNfIcms->getId() . '").val();'
                . '$("#' . $oNfIcms->getId() . '").val(moedaParaNumero(vlricms));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfBaseSt->addEvento(Campo::EVENTO_SAIR, 'var vlrBaseSt = $("#' . $oNfBaseSt->getId() . '").val();'
                . '$("#' . $oNfBaseSt->getId() . '").val(moedaParaNumero(vlrBaseSt));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfVlrSt->addEvento(Campo::EVENTO_SAIR, 'var vlrst = $("#' . $oNfVlrSt->getId() . '").val();'
                . '$("#' . $oNfVlrSt->getId() . '").val(moedaParaNumero(vlrst));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfVlrIpi->addEvento(Campo::EVENTO_SAIR, 'var vlripi = $("#' . $oNfVlrIpi->getId() . '").val();'
                . '$("#' . $oNfVlrIpi->getId() . '").val(moedaParaNumero(vlripi));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNfTotal->addEvento(Campo::EVENTO_SAIR, 'var vlrtot = $("#' . $oNfTotal->getId() . '").val();'
                . '$("#' . $oNfTotal->getId() . '").val(moedaParaNumero(vlrtot));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oNf_frete->addEvento(Campo::EVENTO_SAIR, 'var vlrtot = $("#' . $oNfTotal->getId() . '").val();'
                . '$("#' . $oNfTotal->getId() . '").val(moedaParaNumero(vlrtot));calcTotNfEnt("' . $oNfTotProd->getId() . '","' . $oNfVlrIpi->getId() . '","' . $oNfVlrSt->getId() . '","' . $oNfTotal->getId() . '","' . $oNf_frete->getId() . '");');

        $oEtapas = new FormEtapa(2, 2, 2, 2);
        $oEtapas->addItemEtapas('Entrada Nota Fiscal', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens Nota Fiscal', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);


        $oSitNf = new Campo('Situação', 'nf_finan', Campo::TIPO_TEXTO, 2);
        $oSitNf->setBCampoBloqueado(true);
        $oSitNf->setSValor('Sem Financeiro');

        $this->addCampos($oNfEmp, array($oNfDoc, $oNfSerie, $oNfCnpj, $oEmpresa, $oSitNf), array($oNfDataEnt, $oNfDataCheg, $oNfHoraCheg, $oNfTipo), $oFieldValores, $oNfobs, array($oUsuIns, $oUsuHoraCad));
    }

}
