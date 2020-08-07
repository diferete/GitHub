<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewProduto extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        // $this->setaTiluloConsulta('Consulta Produtos');
        $oProcod = new CampoConsulta('Código', 'procod', CampoConsulta::TIPO_LARGURA, 20);

        $oProdes = new CampoConsulta('Descrição', 'prodes', CampoConsulta::TIPO_LARGURA, 20);

        $oProBloq = new CampoConsulta('Bloqueado', 'probloqpro');
        $oProBloq->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, null);

        $oUn = new CampoConsulta('Unidade', 'pround', CampoConsulta::TIPO_LARGURA, 20);

        $FiltroProcod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $FiltroProdes = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oProcod, $oProdes, $oUn);
        $this->addFiltro($FiltroProcod, $FiltroProdes);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de Produtos');
        $oProcod = new Campo('Código', 'procod', Campo::TIPO_TEXTO, 2);

        $oProdes = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 6);

        $oProBloq = new Campo('Bloqueado', 'probloqpro', Campo::TIPO_SELECT, 2);
        $oProBloq->addItemSelect('S', 'Bloqueado');
        $oProBloq->addItemSelect('N', 'Ativo');

        $oGrupo = new Campo('Grupo', 'GrupoProd.grucod', Campo::TIPO_TEXTO, 1);

        $oGrupoDes = new Campo('Descrição', 'GrupoProd.grudes', Campo::TIPO_TEXTO, 3);

        $oSubCod = new Campo('SubGrupo', 'SubGrupoProd.subcod', Campo::TIPO_TEXTO, 1);

        $oSubDes = new Campo('Descrição', 'SubGrupoProd.subdes', Campo::TIPO_TEXTO, 3);

        $oFamcod = new Campo('Familia', 'FamProd.famcod', Campo::TIPO_TEXTO, 1);
        $oFamDes = new Campo('Descrição', 'FamProd.famdes');

        $oFamsub = new Campo('SubFamília', 'FamSub.famsub', Campo::TIPO_TEXTO, 1);

        $oFamsDes = new Campo('Descrição', 'FamSub.famsdes', Campo::TIPO_TEXTO, 3);

        $oUnidade = new Campo('Unidade', 'pround', Campo::TIPO_TEXTO, 1);

        $oPeso = new Campo('Peso', 'propesprat', Campo::TIPO_MONEY, 1);

        $oClassFiscal = new Campo('Classificação Fiscal', 'proclasfis', Campo::TIPO_TEXTO, 2);

        $oCest = new Campo('Código Cest', 'procest', Campo::TIPO_TEXTO, 2);


        $this->addCampos(array($oProcod, $oProdes, $oProBloq), array($oGrupo, $oGrupoDes), array($oSubCod, $oSubDes), array($oFamcod, $oFamDes), array($oFamsub, $oFamsDes), array($oUnidade, $oPeso, $oClassFiscal, $oCest));
    }

    public function TelaRelatorioProduto() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Produtos');

        $this->setBTela(true);

        $oGrupo = new Campo('Grupo 1', 'grupo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oGrupo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oGrupo1 = new Campo('Grupo 2', 'grupo1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oGrupo1->setITamanho(Campo::TAMANHO_PEQUENO);

        $oSubGrupo = new Campo('Sub Grupo Inicial', 'subgrupo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubGrupo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oSubGrupo1 = new Campo('Sub Grupo Final', 'subgrupo1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubGrupo1->setITamanho(Campo::TAMANHO_PEQUENO);

        $oFamilia = new Campo('Família Inicial', 'familia', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFamilia->setITamanho(Campo::TAMANHO_PEQUENO);

        $oFamilia1 = new Campo('Família Final', 'familia1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFamilia1->setITamanho(Campo::TAMANHO_PEQUENO);

        $oSubFam = new Campo('Sub Família Inicial', 'subfamilia', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubFam->setITamanho(Campo::TAMANHO_PEQUENO);

        $oSubFam1 = new Campo('Sub Família Final', 'subfamilia1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubFam1->setITamanho(Campo::TAMANHO_PEQUENO);

//        $oCodigo = new Campo('Código','codigo', Campo::TIPO_BUSCADOBANCOPK,2);
//        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodigo = new Campo('Código', 'codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);

        //$oBotConf = new Campo('Buscar','',  Campo::TIPO_BOTAOSMALL);
        $oFieldSetFiltros = new FieldSet('Filtros');
        $oFieldSetFiltros->addCampos(array($oGrupo, $oGrupo1, $oSubGrupo, $oSubGrupo1), array($oFamilia, $oFamilia1, $oSubFam, $oSubFam1));
        $oFieldSetFiltros->setOculto(true);

        $this->addCampos($oFieldSetFiltros, array($oCodigo));
    }

    public function ListaEmb() {
        parent::criaTela();

        $this->setTituloTela('Lista de embalagens');
        $this->setBTela(true);

        $oDowPo = new Campo('Porcas', '', Campo::TIPO_DOWN);
        $oDowPo->setListaDow('lista/ListaPorca.xlsx');

        $oDowPf = new Campo('Parafusos', '', Campo::TIPO_DOWN);
        $oDowPf->setListaDow('lista/ListaParafuso.xlsx');

        $this->addCampos($oDowPo, $oDowPf);
    }

}
