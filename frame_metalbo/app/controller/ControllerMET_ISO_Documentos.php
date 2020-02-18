<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_ISO_Documentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ISO_Documentos');
        $this->setControllerDetalhe('MET_ISO_DocRevisao');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function afterDelete() {
        parent::afterDelete();

        $this->Persistencia->deletaDocumento($this->Model->getFilcgc(), $this->Model->getNr());
        $aRetorno[0] = true;

        return $aRetorno;
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        return $aRetorno;
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $aDados = $_REQUEST['parametros'];
        $aDados = explode(',', $aDados['parametros[']);

        $oResult = $this->Persistencia->getDados($aDados[0]);

        $this->View->setAParametrosExtras($oResult);
    }

    public function toggle($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[1] != null || $aDados[1] != "") {
            echo '$("#' . $aDados[0] . '-campo").toggle("show");';
            echo '$("#' . $aDados[0] . '").val("");';
        } else {
            echo '$("#' . $aDados[0] . '-campo").toggle("show");';
        }
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $total_dig = $this->Model->getDig_direcao_quant() + $this->Model->getDig_gestao_qualidade_quant() + $this->Model->getDig_Vendas_quant() + $this->Model->getDig_projetos_quant() + $this->Model->getDig_plan_Producao_quant() + $this->Model->getDig_compras_quant() + $this->Model->getDig_almoxarifado_quant() + $this->Model->getDig_rh_quant() + $this->Model->getDig_ti_quant() + $this->Model->getDig_expedicao_quant() + $this->Model->getDig_embalagem_quant() + $this->Model->getDig_seguranca_quant() + $this->Model->getDig_garantia_qualidade_quant() + $this->Model->getDig_pcp_quant() + $this->Model->getDig_fosfatizacao_quant() + $this->Model->getDig_trefilacao_quant() + $this->Model->getDig_conf_frio_PO_quant() + $this->Model->getDig_conf_Frio_PA_quant() + $this->Model->getDig_machos_quant() + $this->Model->getDig_conf_Quente_quant() + $this->Model->getDig_forno_Rev_Cont_quant() + $this->Model->getDig_galvanizacao_quant() + $this->Model->getDig_lab_Galvanizacao_quant() + $this->Model->getDig_usinagem_quant() + $this->Model->getDig_expedicao_Expo_quant() + $this->Model->getDig_ferramentaria_quant() + $this->Model->getDig_manutencao_quant() + $this->Model->getDig_nylon_quant() + $this->Model->getDig_ete_quant() + $this->Model->getDig_steeltrater_quant() + $this->Model->getDig_salt_spray_quant() + $this->Model->getDig_jl_galvano_quant() + $this->Model->getDig_prada_galvano_quant();

        $this->Model->setTotal_Dig($total_dig);




        $total_fis = $this->Model->getFis_direcao_quant() + $this->Model->getFis_gestao_qualidade_quant() + $this->Model->getFis_Vendas_quant() + $this->Model->getFis_projetos_quant() + $this->Model->getFis_plan_Producao_quant() + $this->Model->getFis_compras_quant() + $this->Model->getFis_almoxarifado_quant() + $this->Model->getFis_rh_quant() + $this->Model->getFis_ti_quant() + $this->Model->getFis_expedicao_quant() + $this->Model->getFis_embalagem_quant() + $this->Model->getFis_seguranca_quant() + $this->Model->getFis_garantia_qualidade_quant() + $this->Model->getFis_pcp_quant() + $this->Model->getFis_fosfatizacao_quant() + $this->Model->getFis_trefilacao_quant() + $this->Model->getFis_conf_frio_PO_quant() + $this->Model->getFis_conf_Frio_PA_quant() + $this->Model->getFis_machos_quant() + $this->Model->getFis_conf_Quente_quant() + $this->Model->getFis_forno_Rev_Cont_quant() + $this->Model->getFis_galvanizacao_quant() + $this->Model->getFis_lab_Galvanizacao_quant() + $this->Model->getFis_usinagem_quant() + $this->Model->getFis_expedicao_Expo_quant() + $this->Model->getFis_ferramentaria_quant() + $this->Model->getFis_manutencao_quant() + $this->Model->getFis_nylon_quant() + $this->Model->getFis_ete_quant() + $this->Model->getFis_steeltrater_quant() + $this->Model->getFis_salt_spray_quant() + $this->Model->getFis_jl_galvano_quant() + $this->Model->getFis_prada_galvano_quant();

        $this->Model->setTotal_Fis($total_fis);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $total_dig = $this->Model->getDig_direcao_quant() + $this->Model->getDig_gestao_qualidade_quant() + $this->Model->getDig_Vendas_quant() + $this->Model->getDig_projetos_quant() + $this->Model->getDig_plan_Producao_quant() + $this->Model->getDig_compras_quant() + $this->Model->getDig_almoxarifado_quant() + $this->Model->getDig_rh_quant() + $this->Model->getDig_ti_quant() + $this->Model->getDig_expedicao_quant() + $this->Model->getDig_embalagem_quant() + $this->Model->getDig_seguranca_quant() + $this->Model->getDig_garantia_qualidade_quant() + $this->Model->getDig_pcp_quant() + $this->Model->getDig_fosfatizacao_quant() + $this->Model->getDig_trefilacao_quant() + $this->Model->getDig_conf_frio_PO_quant() + $this->Model->getDig_conf_Frio_PA_quant() + $this->Model->getDig_machos_quant() + $this->Model->getDig_conf_Quente_quant() + $this->Model->getDig_forno_Rev_Cont_quant() + $this->Model->getDig_galvanizacao_quant() + $this->Model->getDig_lab_Galvanizacao_quant() + $this->Model->getDig_usinagem_quant() + $this->Model->getDig_expedicao_Expo_quant() + $this->Model->getDig_ferramentaria_quant() + $this->Model->getDig_manutencao_quant() + $this->Model->getDig_nylon_quant() + $this->Model->getDig_ete_quant() + $this->Model->getDig_steeltrater_quant() + $this->Model->getDig_salt_spray_quant() + $this->Model->getDig_jl_galvano_quant() + $this->Model->getDig_prada_galvano_quant();

        $this->Model->setTotal_Dig($total_dig);


        $total_fis = $this->Model->getFis_direcao_quant() + $this->Model->getFis_gestao_qualidade_quant() + $this->Model->getFis_Vendas_quant() + $this->Model->getFis_projetos_quant() + $this->Model->getFis_plan_Producao_quant() + $this->Model->getFis_compras_quant() + $this->Model->getFis_almoxarifado_quant() + $this->Model->getFis_rh_quant() + $this->Model->getFis_ti_quant() + $this->Model->getFis_expedicao_quant() + $this->Model->getFis_embalagem_quant() + $this->Model->getFis_seguranca_quant() + $this->Model->getFis_garantia_qualidade_quant() + $this->Model->getFis_pcp_quant() + $this->Model->getFis_fosfatizacao_quant() + $this->Model->getFis_trefilacao_quant() + $this->Model->getFis_conf_frio_PO_quant() + $this->Model->getFis_conf_Frio_PA_quant() + $this->Model->getFis_machos_quant() + $this->Model->getFis_conf_Quente_quant() + $this->Model->getFis_forno_Rev_Cont_quant() + $this->Model->getFis_galvanizacao_quant() + $this->Model->getFis_lab_Galvanizacao_quant() + $this->Model->getFis_usinagem_quant() + $this->Model->getFis_expedicao_Expo_quant() + $this->Model->getFis_ferramentaria_quant() + $this->Model->getFis_manutencao_quant() + $this->Model->getFis_nylon_quant() + $this->Model->getFis_ete_quant() + $this->Model->getFis_steeltrater_quant() + $this->Model->getFis_salt_spray_quant() + $this->Model->getFis_jl_galvano_quant() + $this->Model->getFis_prada_galvano_quant();

        $this->Model->setTotal_Fis($total_fis);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
