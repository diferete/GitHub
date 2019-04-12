<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_SubGrupoProd extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oPRO_GrupoCodigo = new CampoConsulta('Grupo Cód.', 'PRO_GrupoCodigo');
        $oPRO_SubGrupoCodigo = new CampoConsulta('Subgrupo Cód', 'PRO_SubGrupoCodigo');
        $oPRO_SubGrupoDescricao = new CampoConsulta('Subgrupo Desc.', 'PRO_SubGrupoDescricao');
        $oPRO_SubGrupoTipoControle = new CampoConsulta('SubGrupo Tipo Controle', 'PRO_SubGrupoTipoControle');
        $oPRO_SubGrupoTipoDespesa = new CampoConsulta('Subgrupo Tipo Despesa', 'PRO_SubGrupoTipoDespesa');
        $oPRO_SubGrupoTipoReceita = new CampoConsulta('Subgrupo Tipo Receita', 'PRO_SubGrupoTipoReceita');
        $oPRO_SubGrupoFatCorSeq = new CampoConsulta('Subgrupo Fat.Cor.Seq.', 'PRO_SubGrupoFatCorSeq');
        $oGRS_GrupoSubGrupoPH = new CampoConsulta('Subgrupo PH', 'GRS_GrupoSubGrupoPH');
        $oPRO_SubGrupoCCT = new CampoConsulta('Subgrupo CCT', 'PRO_SubGrupoCCT');
        $oPRO_GrupoSubGrupoComprador = new CampoConsulta('Sub. Grupo Comprador', 'PRO_GrupoSubGrupoComprador');
        $oPRO_GrupoSubGrupoControleLote = new CampoConsulta('Subgrupo Controle Lote', 'PRO_GrupoSubGrupoControleLote');
        $oPRO_GrupoSubGrupoMovEstoque = new CampoConsulta('Subgrupo Mov. Estoque', 'PRO_GrupoSubGrupoMovEstoque');
        $oPRO_GrupoSubGrupoTipoCusto = new CampoConsulta('Subgrupo Tipo Custo', 'PRO_GrupoSubGrupoTipoCusto');

        $this->addCampos($oPRO_GrupoCodigo, $oPRO_SubGrupoCodigo, $oPRO_SubGrupoDescricao, $oPRO_SubGrupoTipoControle, $oPRO_SubGrupoTipoDespesa, $oPRO_SubGrupoTipoReceita, $oPRO_SubGrupoFatCorSeq, $oGRS_GrupoSubGrupoPH, $oPRO_SubGrupoCCT, $oPRO_GrupoSubGrupoComprador, $oPRO_GrupoSubGrupoControleLote, $oPRO_GrupoSubGrupoMovEstoque, $oPRO_GrupoSubGrupoTipoCusto);
    }

    public function criaTela() {
        parent::criaTela();

        $oPRO_GrupoCodigo = new Campo('Grupo Cód.', 'PRO_GrupoCodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_GrupoCodigoDescricao = new Campo('Desc.Tipo Despesa', 'PRO_DescGrupoCodigo', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_GrupoCodigoDescricao->setSIdPk($oPRO_GrupoCodigo->getId());
        $oPRO_GrupoCodigoDescricao->setClasseBusca('STEEL_PCP_GrupoProd');
        $oPRO_GrupoCodigoDescricao->addCampoBusca('PRO_GrupoCodigo', '', '');
        $oPRO_GrupoCodigoDescricao->addCampoBusca('PRO_GrupoDescricao', '', '');
        $oPRO_GrupoCodigoDescricao->setSIdTela($this->getTela()->getid());
        $oPRO_GrupoCodigoDescricao->setApenasTela(true);

        $oPRO_GrupoCodigo->setClasseBusca('STEEL_PCP_GrupoProd');
        $oPRO_GrupoCodigo->setSCampoRetorno('PRO_GrupoCodigo', $this->getTela()->getId());
        $oPRO_GrupoCodigo->addCampoBusca('PRO_GrupoDescricao', $oPRO_GrupoCodigoDescricao->getId(), $this->getTela()->getId());

        $oPRO_SubGrupoCodigo = new Campo('Subgrupo Cód', 'PRO_SubGrupoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oPRO_SubGrupoDescricao = new Campo('Subgrupo Desc.', 'PRO_SubGrupoDescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oDivisor0 = new Campo('Tipo', 'tipo', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor0->setApenasTela(true);

        $oPRO_GrupoTipoDespesa = new Campo('Subgrupo Tipo Desp.', 'PRO_SubGrupoTipoDespesa', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

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


        $oPRO_GrupoTipoReceita = new Campo('Subgrupo Tipo Recei.', 'PRO_SubGrupoTipoReceita', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

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

        $this->addCampos(array($oPRO_GrupoCodigo, $oPRO_GrupoCodigoDescricao), array($oPRO_SubGrupoCodigo, $oPRO_SubGrupoDescricao), $oDivisor0, array($oPRO_GrupoTipoDespesa, $oPRO_GrupoDescTipoDespesa), array($oPRO_GrupoTipoReceita, $oPRO_GrupoDescTipoReceita));
    }

}
