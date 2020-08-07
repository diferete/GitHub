<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_SubFamProd extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oPRO_GrupoCodigo = new CampoConsulta('Grupo Cód', 'PRO_GrupoCodigo');
        $oPRO_SubGrupoCodigo = new CampoConsulta('Subgrupo Cód', 'PRO_SubGrupoCodigo');
        $oPRO_FamiliaCodigo = new CampoConsulta('Fam. Cód', 'PRO_FamiliaCodigo');
        $oPRO_SubFamiliaCodigo = new CampoConsulta('Cód', 'PRO_SubFamiliaCodigo');
        $oPRO_SubFamiliaDescricao = new CampoConsulta('Desc.', 'PRO_SubFamiliaDescricao');
        $oPRO_SubFamiliaProDescricao = new CampoConsulta('Desc. Padrão', 'PRO_SubFamiliaProDescricao');
        $oPRO_SubFamiliaProDescTec = new CampoConsulta('Desc. Técnica', 'PRO_SubFamiliaProDescTec');
        $oPRO_SubFamiliaProFormataDesc = new CampoConsulta('Formata Desc.', 'PRO_SubFamiliaProFormataDesc');
        $oPRO_SubFamiliaTipoControle = new CampoConsulta('Tipo Controle', 'PRO_SubFamiliaTipoControle');
        $oPRO_SubFamiliaTipoDespesa = new CampoConsulta('Tipo Despesa', 'PRO_SubFamiliaTipoDespesa');
        $oPRO_SubFamiliaTipoReceita = new CampoConsulta('Tipo Receita', 'PRO_SubFamiliaTipoReceita');
        $oPRO_SubFamiliaProdutoBase = new CampoConsulta('Produto Base', 'PRO_SubFamiliaProdutoBase');
        $oPRO_SubFamiliaSequencialProdut = new CampoConsulta('Seq. Auto.', 'PRO_SubFamiliaSequencialProdut');
        $oPRO_SubFamiliaComprador = new CampoConsulta('Comprador', 'PRO_SubFamiliaComprador');
        $oPRO_SubFamiliaControleLote = new CampoConsulta('Controle Lote', 'PRO_SubFamiliaControleLote');
        $oPRO_SubFamiliaMovEstoque = new CampoConsulta('Mov. Estoque', 'PRO_SubFamiliaMovEstoque');
        $oPRO_SubFamiliaTipoCusto = new CampoConsulta('Tipo Custo', 'PRO_SubFamiliaTipoCusto');

        $this->addCampos($oPRO_GrupoCodigo, $oPRO_SubGrupoCodigo, $oPRO_FamiliaCodigo, $oPRO_SubFamiliaCodigo, $oPRO_SubFamiliaDescricao, $oPRO_SubFamiliaProDescricao, $oPRO_SubFamiliaProDescTec, $oPRO_SubFamiliaProFormataDesc, $oPRO_SubFamiliaTipoControle, $oPRO_SubFamiliaTipoDespesa, $oPRO_SubFamiliaTipoReceita, $oPRO_SubFamiliaProdutoBase, $oPRO_SubFamiliaSequencialProdut, $oPRO_SubFamiliaComprador, $oPRO_SubFamiliaControleLote, $oPRO_SubFamiliaMovEstoque, $oPRO_SubFamiliaTipoCusto);
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

        $oPRO_SubGrupoCodigo = new Campo('Subgrupo Cód.', 'PRO_SubGrupoCodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_SubGrupoDescricao = new Campo('Subgrupo Desc.', 'PRO_SubGrupoDescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_SubGrupoDescricao->setSIdPk($oPRO_SubGrupoCodigo->getId());
        $oPRO_SubGrupoDescricao->setClasseBusca('STEEL_PCP_SubGrupoProd');
        $oPRO_SubGrupoDescricao->addCampoBusca('PRO_SubGrupoCodigo', '', '');
        $oPRO_SubGrupoDescricao->addCampoBusca('PRO_SubGrupoDescricao', '', '');
        $oPRO_SubGrupoDescricao->setSIdTela($this->getTela()->getid());
        $oPRO_SubGrupoDescricao->setApenasTela(true);

        $oPRO_SubGrupoCodigo->setClasseBusca('STEEL_PCP_SubGrupoProd');
        $oPRO_SubGrupoCodigo->setSCampoRetorno('PRO_SubGrupoCodigo', $this->getTela()->getId());
        $oPRO_SubGrupoCodigo->addCampoBusca('PRO_SubGrupoDescricao', $oPRO_SubGrupoDescricao->getId(), $this->getTela()->getId());


        $oPRO_FamiliaCodigo = new Campo('Fam. Cód.', 'PRO_FamiliaCodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_FamiliaDescricao = new Campo('Fam. Descrição', 'PRO_FamiliaDescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_FamiliaDescricao->setSIdPk($oPRO_FamiliaCodigo->getId());
        $oPRO_FamiliaDescricao->setClasseBusca('STEEL_PCP_FamProd');
        $oPRO_FamiliaDescricao->addCampoBusca('PRO_FamiliaCodigo', '', '');
        $oPRO_FamiliaDescricao->addCampoBusca('PRO_FamiliaDescricao', '', '');
        $oPRO_FamiliaDescricao->setSIdTela($this->getTela()->getid());
        $oPRO_FamiliaDescricao->setApenasTela(true);

        $oPRO_FamiliaCodigo->setClasseBusca('STEEL_PCP_FamProd');
        $oPRO_FamiliaCodigo->setSCampoRetorno('PRO_FamiliaCodigo', $this->getTela()->getId());
        $oPRO_FamiliaCodigo->addCampoBusca('PRO_FamiliaDescricao', $oPRO_FamiliaDescricao->getId(), $this->getTela()->getId());

        $oPRO_SubFamiliaCodigo = new Campo('Sub.Fam.Cód.', 'PRO_SubFamiliaCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPRO_SubFamiliaDescricao = new Campo('Descrição da Subfamília.', 'PRO_SubFamiliaDescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oPRO_SubFamiliaProDescricao = new Campo('Descrição Padrão', 'PRO_SubFamiliaProDescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPRO_SubFamiliaProDescTec = new Campo('Descrição Técnica Padrão', 'PRO_SubFamiliaProDescTec', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oPRO_SubFamiliaProDescTec->setILinhasTextArea(3);

        $oPRO_SubFamiliaProFormataDesc = new Campo('Formatar a descrição do Produto', 'PRO_SubFamiliaProFormataDesc', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPRO_SubFamiliaProFormataDesc->addItemSelect('', 'N/A');
        $oPRO_SubFamiliaProFormataDesc->addItemSelect('S', 'Sim');
        $oPRO_SubFamiliaProFormataDesc->addItemSelect('N', 'Não');

        $oDivisor0 = new Campo('Tipo', 'tipo', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor0->setApenasTela(true);


        $oPRO_FamTipoDespesa = new Campo('Fam. Tipo Desp.', 'PRO_SubFamiliaTipoDespesa', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_FamDescTipoDespesa = new Campo('Desc.Tipo Despesa', 'PRO_SubFamiliaTipoDespesa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_FamDescTipoDespesa->setSIdPk($oPRO_FamTipoDespesa->getId());
        $oPRO_FamDescTipoDespesa->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_FamDescTipoDespesa->addCampoBusca('tds_codigo', '', '');
        $oPRO_FamDescTipoDespesa->addCampoBusca('tds_descricao', '', '');
        $oPRO_FamDescTipoDespesa->setSIdTela($this->getTela()->getid());
        $oPRO_FamDescTipoDespesa->setApenasTela(true);

        $oPRO_FamTipoDespesa->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_FamTipoDespesa->setSCampoRetorno('tds_codigo', $this->getTela()->getId());
        $oPRO_FamTipoDespesa->addCampoBusca('tds_descricao', $oPRO_FamDescTipoDespesa->getId(), $this->getTela()->getId());


        $oPRO_FamTipoReceita = new Campo('Fam Tipo Recei.', 'PRO_SubFamiliaTipoReceita', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oPRO_FamDescTipoReceita = new Campo('Desc.Tipo Receita', 'PRO_SubFamiliaTipoReceita', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPRO_FamDescTipoReceita->setSIdPk($oPRO_FamTipoReceita->getId());
        $oPRO_FamDescTipoReceita->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_FamDescTipoReceita->addCampoBusca('tds_codigo', '', '');
        $oPRO_FamDescTipoReceita->addCampoBusca('tds_descricao', '', '');
        $oPRO_FamDescTipoReceita->setSIdTela($this->getTela()->getid());
        $oPRO_FamDescTipoReceita->setApenasTela(true);

        $oPRO_FamTipoReceita->setClasseBusca('DELX_TDS_TipoDespesa');
        $oPRO_FamTipoReceita->setSCampoRetorno('tds_codigo', $this->getTela()->getId());
        $oPRO_FamTipoReceita->addCampoBusca('tds_descricao', $oPRO_FamDescTipoReceita->getId(), $this->getTela()->getId());

        $oPRO_SubFamiliaProdutoBase = new Campo('Produto Base', 'PRO_SubFamiliaProdutoBase', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oPRO_SubFamiliaProdutoBase->setClasseBusca('DELX_PRO_ProdutoFilial');
        $oPRO_SubFamiliaProdutoBase->setSCampoRetorno('pro_codigo', $this->getTela()->getId());

        $oPRO_SubFamiliaSequencialProdut = new Campo('Seq. Geração de Prod. Auto.', 'PRO_SubFamiliaSequencialProdut', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oDivisor1 = new Campo('Parâmetros de Cadastro', 'divisor2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oPRO_FamiliaTipoControle = new Campo('Tipo de controle de estoque', 'PRO_SubFamiliaTipoControle', Campo::TIPO_SELECT,1, 1, 12, 12);
        $oPRO_FamiliaTipoControle->addItemSelect('N', 'Nenhum');
        $oPRO_FamiliaTipoControle->addItemSelect('E', 'Estoque Total');
        $oPRO_FamiliaTipoControle->addItemSelect('F', 'Estoque Físico');
        $oPRO_FamiliaTipoControle->addItemSelect('D', 'Débito Direto');
        $oPRO_FamiliaTipoControle->addItemSelect('C', 'Consignado');

        $oPRO_FamiliaTipoCusto = new Campo('Tipo de custo', 'PRO_SubFamiliaTipoCusto', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPRO_FamiliaTipoCusto->addItemSelect('M', 'Custo Médio');
        $oPRO_FamiliaTipoCusto->addItemSelect('F', 'Custo Padrão');
        $oPRO_FamiliaTipoCusto->addItemSelect('P', 'PEPS');
        $oPRO_FamiliaTipoCusto->addItemSelect('U', 'UEPS');
        $oPRO_FamiliaTipoCusto->addItemSelect('O', 'Custo Online');

        $oPRO_FamiliaMovEstoque = new Campo('Movimenta estoque?', 'PRO_SubFamiliaMovEstoque', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPRO_FamiliaMovEstoque->addItemSelect('', 'N/A');
        $oPRO_FamiliaMovEstoque->addItemSelect('S', 'Sim');
        $oPRO_FamiliaMovEstoque->addItemSelect('N', 'Não');

        $oPRO_FamiliaControleLote = new Campo('Controlado por Lote?', 'PRO_SubFamiliaControleLote', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPRO_FamiliaControleLote->addItemSelect('', 'N/A');
        $oPRO_FamiliaControleLote->addItemSelect('S', 'Sim');
        $oPRO_FamiliaControleLote->addItemSelect('N', 'Não');


        $this->addCampos(
                array($oPRO_GrupoCodigo, $oPRO_GrupoCodigoDescricao), array($oPRO_SubGrupoCodigo, $oPRO_SubGrupoDescricao),
                array($oPRO_FamiliaCodigo, $oPRO_FamiliaDescricao), array($oPRO_SubFamiliaCodigo, $oPRO_SubFamiliaDescricao),$oPRO_SubFamiliaProDescTec, $oDivisor0,
                array($oPRO_FamTipoDespesa, $oPRO_FamDescTipoDespesa), array($oPRO_FamTipoReceita, $oPRO_FamDescTipoReceita),
                array($oPRO_SubFamiliaProdutoBase,$oPRO_SubFamiliaSequencialProdut), $oDivisor1, 
                array($oPRO_FamiliaTipoControle, $oPRO_FamiliaTipoCusto, $oPRO_FamiliaMovEstoque, $oPRO_FamiliaControleLote));
    }

}
