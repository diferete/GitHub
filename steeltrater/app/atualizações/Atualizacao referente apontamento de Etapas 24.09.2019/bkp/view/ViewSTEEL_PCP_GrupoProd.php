<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_GrupoProd extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oPRO_GrupoCodigo = new CampoConsulta('Código', 'PRO_GrupoCodigo');
        $oPRO_GrupoDescricao = new CampoConsulta('Desc.', 'PRO_GrupoDescricao');
        $oPRO_GrupoTipo = new CampoConsulta('Tipo', 'PRO_GrupoTipo');
        $oPRO_GrupoTipoControle = new CampoConsulta('Tipo Controle', 'PRO_GrupoTipoControle');
        $oPRO_GrupoTipoDespesa = new CampoConsulta('Tipo Despesa', 'PRO_GrupoTipoDespesa');
        $oPRO_GrupoTipoReceita = new CampoConsulta('Tipo Receita', 'PRO_GrupoTipoReceita');
        $oGRS_GrupoPH = new CampoConsulta('PH', 'GRS_GrupoPH');
        $oPRO_GrupoComprador = new CampoConsulta('Comprador', 'PRO_GrupoComprador');
        $oPRO_GrupoControleLote = new CampoConsulta('Lote', 'PRO_GrupoControleLote');
        $oPRO_GrupoMovEstoque = new CampoConsulta('Mov. Estoque', 'PRO_GrupoMovEstoque');
        $oPRO_GrupoTipoCusto = new CampoConsulta('Tipo Custo', 'PRO_GrupoTipoCusto');

        $this->setUsaAcaoExcluir(false);

        $this->addCampos($oPRO_GrupoCodigo, $oPRO_GrupoDescricao, $oPRO_GrupoTipo, $oPRO_GrupoTipoControle, $oPRO_GrupoTipoDespesa, $oPRO_GrupoTipoDespesa, $oPRO_GrupoTipoReceita, $oGRS_GrupoPH, $oPRO_GrupoComprador, $oPRO_GrupoControleLote, $oPRO_GrupoMovEstoque, $oPRO_GrupoTipoCusto);
    }

    public function criaTela() {
        parent::criaTela();

        $oPRO_GrupoCodigo = new Campo('Código', 'PRO_GrupoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPRO_GrupoCodigo->setbCampoBloqueado(true);

        $oPRO_GrupoDescricao = new Campo('Desc.', 'PRO_GrupoDescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oPRO_GrupoTipo = new Campo('Tipo', 'PRO_GrupoTipo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPRO_GrupoTipo->addItemSelect('00', 'Mercadoria para Revenda');
        $oPRO_GrupoTipo->addItemSelect('01', 'Matéria Prima');
        $oPRO_GrupoTipo->addItemSelect('02', 'Embalagem');
        $oPRO_GrupoTipo->addItemSelect('03', 'Produto em Processo');
        $oPRO_GrupoTipo->addItemSelect('04', 'Produto Acabado');
        $oPRO_GrupoTipo->addItemSelect('05', 'Subproduto');
        $oPRO_GrupoTipo->addItemSelect('06', 'Produto Intermediário');
        $oPRO_GrupoTipo->addItemSelect('07', 'Material de Uso e Consumo');
        $oPRO_GrupoTipo->addItemSelect('08', 'Ativo Imobilizado');
        $oPRO_GrupoTipo->addItemSelect('09', 'Serviços');
        $oPRO_GrupoTipo->addItemSelect('10', 'Outros Insumos');
        $oPRO_GrupoTipo->addItemSelect('99', 'Outras');

        
        $oPRO_GrupoTipoDespesa = new Campo('Cód.Tipo Despesa', 'PRO_GrupoTipoDespesa', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_GrupoDescTipoDespesa = new Campo('Desc.Tipo Despesa', 'PRO_GrupoTipoDespesa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_GrupoDescTipoDespesa->setSIdPk($oPRO_GrupoTipoDespesa->getId());
        $oPRO_GrupoDescTipoDespesa->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_GrupoDescTipoDespesa->addCampoBusca('tds_codigo', '', '');
        $oPRO_GrupoDescTipoDespesa->addCampoBusca('tds_descricao', '', '');
        $oPRO_GrupoDescTipoDespesa->setSIdTela($this->getTela()->getid());
        $oPRO_GrupoDescTipoDespesa->setApenasTela(true);

        $oPRO_GrupoTipoDespesa->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_GrupoTipoDespesa->setSCampoRetorno('tds_codigo', $this->getTela()->getId());
        $oPRO_GrupoTipoDespesa->addCampoBusca('tds_descricao', $oPRO_GrupoDescTipoDespesa->getId(), $this->getTela()->getId());
        
        
        $oPRO_GrupoTipoReceita = new Campo('Cód.Tipo Receita', 'PRO_GrupoTipoReceita', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_GrupoDescTipoReceita = new Campo('Desc.Tipo Receita', 'PRO_GrupoTipoReceita', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_GrupoDescTipoReceita->setSIdPk($oPRO_GrupoTipoReceita->getId());
        $oPRO_GrupoDescTipoReceita->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_GrupoDescTipoReceita->addCampoBusca('tds_codigo', '', '');
        $oPRO_GrupoDescTipoReceita->addCampoBusca('tds_descricao', '', '');
        $oPRO_GrupoDescTipoReceita->setSIdTela($this->getTela()->getid());
        $oPRO_GrupoDescTipoReceita->setApenasTela(true);

        $oPRO_GrupoTipoReceita->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_GrupoTipoReceita->setSCampoRetorno('tds_codigo', $this->getTela()->getId());
        $oPRO_GrupoTipoReceita->addCampoBusca('tds_descricao', $oPRO_GrupoDescTipoReceita->getId(), $this->getTela()->getId());


        $this->addCampos($oPRO_GrupoCodigo, array($oPRO_GrupoDescricao, $oPRO_GrupoTipo), array($oPRO_GrupoTipoDespesa, $oPRO_GrupoDescTipoDespesa), array($oPRO_GrupoTipoReceita, $oPRO_GrupoDescTipoReceita));
    }

}
