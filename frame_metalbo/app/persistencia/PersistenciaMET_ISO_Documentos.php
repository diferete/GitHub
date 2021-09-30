<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_Documentos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_Documentos');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('documento', 'documento');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('total_Dig', 'total_Dig');
        $this->adicionaRelacionamento('total_Fis', 'total_Fis');
        $this->adicionaRelacionamento('revisao', 'revisao');
        $this->adicionaRelacionamento('data_revisao', 'data_revisao');


        $this->adicionaRelacionamento('dig_direcao', 'dig_direcao');
        $this->adicionaRelacionamento('dig_direcao_quant', 'dig_direcao_quant');
        $this->adicionaRelacionamento('dig_gestao_qualidade', 'dig_gestao_qualidade');
        $this->adicionaRelacionamento('dig_gestao_qualidade_quant', 'dig_gestao_qualidade_quant');
        $this->adicionaRelacionamento('dig_vendas', 'dig_vendas');
        $this->adicionaRelacionamento('dig_vendas_quant', 'dig_vendas_quant');
        $this->adicionaRelacionamento('dig_projetos', 'dig_projetos');
        $this->adicionaRelacionamento('dig_projetos_quant', 'dig_projetos_quant');
        $this->adicionaRelacionamento('dig_plan_producao', 'dig_plan_producao');
        $this->adicionaRelacionamento('dig_plan_producao_quant', 'dig_plan_producao_quant');
        $this->adicionaRelacionamento('dig_compras', 'dig_compras');
        $this->adicionaRelacionamento('dig_compras_quant', 'dig_compras_quant');
        $this->adicionaRelacionamento('dig_almoxarifado', 'dig_almoxarifado');
        $this->adicionaRelacionamento('dig_almoxarifado_quant', 'dig_almoxarifado_quant');
        $this->adicionaRelacionamento('dig_rh', 'dig_rh');
        $this->adicionaRelacionamento('dig_rh_quant', 'dig_rh_quant');
        $this->adicionaRelacionamento('dig_ti', 'dig_ti');
        $this->adicionaRelacionamento('dig_ti_quant', 'dig_ti_quant');
        $this->adicionaRelacionamento('dig_expedicao', 'dig_expedicao');
        $this->adicionaRelacionamento('dig_expedicao_quant', 'dig_expedicao_quant');
        $this->adicionaRelacionamento('dig_embalagem', 'dig_embalagem');
        $this->adicionaRelacionamento('dig_embalagem_quant', 'dig_embalagem_quant');
        $this->adicionaRelacionamento('dig_seguranca', 'dig_seguranca');
        $this->adicionaRelacionamento('dig_seguranca_quant', 'dig_seguranca_quant');
        $this->adicionaRelacionamento('dig_garantia_qualidade', 'dig_garantia_qualidade');
        $this->adicionaRelacionamento('dig_garantia_qualidade_quant', 'dig_garantia_qualidade_quant');
        $this->adicionaRelacionamento('dig_pcp', 'dig_pcp');
        $this->adicionaRelacionamento('dig_pcp_quant', 'dig_pcp_quant');
        $this->adicionaRelacionamento('dig_fosfatizacao', 'dig_fosfatizacao');
        $this->adicionaRelacionamento('dig_fosfatizacao_quant', 'dig_fosfatizacao_quant');
        $this->adicionaRelacionamento('dig_trefilacao', 'dig_trefilacao');
        $this->adicionaRelacionamento('dig_trefilacao_quant', 'dig_trefilacao_quant');
        $this->adicionaRelacionamento('dig_conf_frio_PO', 'dig_conf_frio_PO');
        $this->adicionaRelacionamento('dig_conf_frio_PO_quant', 'dig_conf_frio_PO_quant');
        $this->adicionaRelacionamento('dig_conf_frio_PA', 'dig_conf_frio_PA');
        $this->adicionaRelacionamento('dig_conf_frio_PA_quant', 'dig_conf_frio_PA_quant');
        $this->adicionaRelacionamento('dig_machos', 'dig_machos');
        $this->adicionaRelacionamento('dig_machos_quant', 'dig_machos_quant');
        $this->adicionaRelacionamento('dig_conf_quente', 'dig_conf_quente');
        $this->adicionaRelacionamento('dig_conf_quente_quant', 'dig_conf_quente_quant');
        $this->adicionaRelacionamento('dig_forno_rev_cont', 'dig_forno_rev_cont');
        $this->adicionaRelacionamento('dig_forno_rev_cont_quant', 'dig_forno_rev_cont_quant');
        $this->adicionaRelacionamento('dig_galvanizacao', 'dig_galvanizacao');
        $this->adicionaRelacionamento('dig_galvanizacao_quant', 'dig_galvanizacao_quant');
        $this->adicionaRelacionamento('dig_lab_galvanizacao', 'dig_lab_galvanizacao');
        $this->adicionaRelacionamento('dig_lab_galvanizacao_quant', 'dig_lab_galvanizacao_quant');
        $this->adicionaRelacionamento('dig_usinagem', 'dig_usinagem');
        $this->adicionaRelacionamento('dig_usinagem_quant', 'dig_usinagem_quant');
        $this->adicionaRelacionamento('dig_expedicao_expo', 'dig_expedicao_expo');
        $this->adicionaRelacionamento('dig_expedicao_expo_quant', 'dig_expedicao_expo_quant');
        $this->adicionaRelacionamento('dig_ferramentaria', 'dig_ferramentaria');
        $this->adicionaRelacionamento('dig_ferramentaria_quant', 'dig_ferramentaria_quant');
        $this->adicionaRelacionamento('dig_manutencao', 'dig_manutencao');
        $this->adicionaRelacionamento('dig_manutencao_quant', 'dig_manutencao_quant');
        $this->adicionaRelacionamento('dig_nylon', 'dig_nylon');
        $this->adicionaRelacionamento('dig_nylon_quant', 'dig_nylon_quant');
        $this->adicionaRelacionamento('dig_ete', 'dig_ete');
        $this->adicionaRelacionamento('dig_ete_quant', 'dig_ete_quant');
        $this->adicionaRelacionamento('dig_steeltrater', 'dig_steeltrater');
        $this->adicionaRelacionamento('dig_steeltrater_quant', 'dig_steeltrater_quant');
        $this->adicionaRelacionamento('dig_salt_spray', 'dig_salt_spray');
        $this->adicionaRelacionamento('dig_salt_spray_quant', 'dig_salt_spray_quant');
        $this->adicionaRelacionamento('dig_jl_galvano', 'dig_jl_galvano');
        $this->adicionaRelacionamento('dig_jl_galvano_quant', 'dig_jl_galvano_quant');
        $this->adicionaRelacionamento('dig_prada_galvano', 'dig_prada_galvano');
        $this->adicionaRelacionamento('dig_prada_galvano_quant', 'dig_prada_galvano_quant');


        $this->adicionaRelacionamento('fis_direcao', 'fis_direcao');
        $this->adicionaRelacionamento('fis_direcao_quant', 'fis_direcao_quant');
        $this->adicionaRelacionamento('fis_gestao_qualidade', 'fis_gestao_qualidade');
        $this->adicionaRelacionamento('fis_gestao_qualidade_quant', 'fis_gestao_qualidade_quant');
        $this->adicionaRelacionamento('fis_vendas', 'fis_vendas');
        $this->adicionaRelacionamento('fis_vendas_quant', 'fis_vendas_quant');
        $this->adicionaRelacionamento('fis_projetos', 'fis_projetos');
        $this->adicionaRelacionamento('fis_projetos_quant', 'fis_projetos_quant');
        $this->adicionaRelacionamento('fis_plan_producao', 'fis_plan_producao');
        $this->adicionaRelacionamento('fis_plan_producao_quant', 'fis_plan_producao_quant');
        $this->adicionaRelacionamento('fis_compras', 'fis_compras');
        $this->adicionaRelacionamento('fis_compras_quant', 'fis_compras_quant');
        $this->adicionaRelacionamento('fis_almoxarifado', 'fis_almoxarifado');
        $this->adicionaRelacionamento('fis_almoxarifado_quant', 'fis_almoxarifado_quant');
        $this->adicionaRelacionamento('fis_rh', 'fis_rh');
        $this->adicionaRelacionamento('fis_rh_quant', 'fis_rh_quant');
        $this->adicionaRelacionamento('fis_ti', 'fis_ti');
        $this->adicionaRelacionamento('fis_ti_quant', 'fis_ti_quant');
        $this->adicionaRelacionamento('fis_expedicao', 'fis_expedicao');
        $this->adicionaRelacionamento('fis_expedicao_quant', 'fis_expedicao_quant');
        $this->adicionaRelacionamento('fis_embalagem', 'fis_embalagem');
        $this->adicionaRelacionamento('fis_embalagem_quant', 'fis_embalagem_quant');
        $this->adicionaRelacionamento('fis_seguranca', 'fis_seguranca');
        $this->adicionaRelacionamento('fis_seguranca_quant', 'fis_seguranca_quant');
        $this->adicionaRelacionamento('fis_garantia_qualidade', 'fis_garantia_qualidade');
        $this->adicionaRelacionamento('fis_garantia_qualidade_quant', 'fis_garantia_qualidade_quant');
        $this->adicionaRelacionamento('fis_pcp', 'fis_pcp');
        $this->adicionaRelacionamento('fis_pcp_quant', 'fis_pcp_quant');
        $this->adicionaRelacionamento('fis_fosfatizacao', 'fis_fosfatizacao');
        $this->adicionaRelacionamento('fis_fosfatizacao_quant', 'fis_fosfatizacao_quant');
        $this->adicionaRelacionamento('fis_trefilacao', 'fis_trefilacao');
        $this->adicionaRelacionamento('fis_trefilacao_quant', 'fis_trefilacao_quant');
        $this->adicionaRelacionamento('fis_conf_frio_PO', 'fis_conf_frio_PO');
        $this->adicionaRelacionamento('fis_conf_frio_PO_quant', 'fis_conf_frio_PO_quant');
        $this->adicionaRelacionamento('fis_conf_frio_PA', 'fis_conf_frio_PA');
        $this->adicionaRelacionamento('fis_conf_frio_PA_quant', 'fis_conf_frio_PA_quant');
        $this->adicionaRelacionamento('fis_machos', 'fis_machos');
        $this->adicionaRelacionamento('fis_machos_quant', 'fis_machos_quant');
        $this->adicionaRelacionamento('fis_conf_quente', 'fis_conf_quente');
        $this->adicionaRelacionamento('fis_conf_quente_quant', 'fis_conf_quente_quant');
        $this->adicionaRelacionamento('fis_forno_rev_cont', 'fis_forno_rev_cont');
        $this->adicionaRelacionamento('fis_forno_rev_cont_quant', 'fis_forno_rev_cont_quant');
        $this->adicionaRelacionamento('fis_galvanizacao', 'fis_galvanizacao');
        $this->adicionaRelacionamento('fis_galvanizacao_quant', 'fis_galvanizacao_quant');
        $this->adicionaRelacionamento('fis_lab_galvanizacao', 'fis_lab_galvanizacao');
        $this->adicionaRelacionamento('fis_lab_galvanizacao_quant', 'fis_lab_galvanizacao_quant');
        $this->adicionaRelacionamento('fis_usinagem', 'fis_usinagem');
        $this->adicionaRelacionamento('fis_usinagem_quant', 'fis_usinagem_quant');
        $this->adicionaRelacionamento('fis_expedicao_expo', 'fis_expedicao_expo');
        $this->adicionaRelacionamento('fis_expedicao_expo_quant', 'fis_expedicao_expo_quant');
        $this->adicionaRelacionamento('fis_ferramentaria', 'fis_ferramentaria');
        $this->adicionaRelacionamento('fis_ferramentaria_quant', 'fis_ferramentaria_quant');
        $this->adicionaRelacionamento('fis_manutencao', 'fis_manutencao');
        $this->adicionaRelacionamento('fis_manutencao_quant', 'fis_manutencao_quant');
        $this->adicionaRelacionamento('fis_nylon', 'fis_nylon');
        $this->adicionaRelacionamento('fis_nylon_quant', 'fis_nylon_quant');
        $this->adicionaRelacionamento('fis_ete', 'fis_ete');
        $this->adicionaRelacionamento('fis_ete_quant', 'fis_ete_quant');
        $this->adicionaRelacionamento('fis_steeltrater', 'fis_steeltrater');
        $this->adicionaRelacionamento('fis_steeltrater_quant', 'fis_steeltrater_quant');
        $this->adicionaRelacionamento('fis_salt_spray', 'fis_salt_spray');
        $this->adicionaRelacionamento('fis_salt_spray_quant', 'fis_salt_spray_quant');
        $this->adicionaRelacionamento('fis_jl_galvano', 'fis_jl_galvano');
        $this->adicionaRelacionamento('fis_jl_galvano_quant', 'fis_jl_galvano_quant');
        $this->adicionaRelacionamento('fis_prada_galvano', 'fis_prada_galvano');
        $this->adicionaRelacionamento('fis_prada_galvano_quant', 'fis_prada_galvano_quant');
    }

    public function getDados($sDados) {
        $sChave = htmlspecialchars_decode($sDados);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sSql = 'select * from MET_ISO_Documentos where nr = ' . $aCamposChave['nr'] . ' and filcgc = ' . $aCamposChave['filcgc'];
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    public function deletaDocumento($sFilcgc, $sNr, $sSeq) {
        //deletar planos existentes
        $sDelete = "delete from MET_ISO_DocRevisao where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "'";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

}
