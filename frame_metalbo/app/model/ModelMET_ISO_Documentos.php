<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_ISO_Documentos {

    private $filcgc;
    private $nr;
    private $documento;
    private $usuario;
    private $total_Dig;
    private $total_Fis;
    private $revisao;
    private $dig_direcao;
    private $dig_direcao_quant;
    private $dig_gestao_qualidade;
    private $dig_gestao_qualidade_quant;
    private $dig_vendas;
    private $dig_vendas_quant;
    private $dig_plan_producao;
    private $dig_plan_producao_quant;
    private $dig_compras;
    private $dig_compras_quant;
    private $dig_almoxarifado;
    private $dig_almoxarifado_quant;
    private $dig_rh;
    private $dig_rh_quant;
    private $dig_ti;
    private $dig_ti_quant;
    private $dig_expedicao;
    private $dig_expedicao_quant;
    private $dig_seguranca;
    private $dig_seguranca_quant;
    private $dig_garantia_qualidade;
    private $dig_garantia_qualidade_quant;
    private $dig_pcp;
    private $dig_pcp_quant;
    private $dig_projetos;
    private $dig_projetos_quant;
    private $dig_fosfatizacao;
    private $dig_fosfatizacao_quant;
    private $dig_trefilacao;
    private $dig_trefilacao_quant;
    private $dig_conf_frio_PO;
    private $dig_conf_frio_PO_quant;
    private $dig_conf_frio_PA;
    private $dig_conf_frio_PA_quant;
    private $dig_machos;
    private $dig_machos_quant;
    private $dig_conf_quente;
    private $dig_conf_quente_quant;
    private $dig_forno_rev_cont;
    private $dig_forno_rev_cont_quant;
    private $dig_galvanizacao;
    private $dig_galvanizacao_quant;
    private $dig_lab_galvanizacao;
    private $dig_lab_galvanizacao_quant;
    private $dig_usinagem;
    private $dig_usinagem_quant;
    private $dig_expedicao_expo;
    private $dig_expedicao_expo_quant;
    private $dig_embalagem;
    private $dig_embalagem_quant;
    private $dig_ferramentaria;
    private $dig_ferramentaria_quant;
    private $dig_manutencao;
    private $dig_manutencao_quant;
    private $dig_nylon;
    private $dig_nylon_quant;
    private $dig_ete;
    private $dig_ete_quant;
    private $dig_steeltrater;
    private $dig_steeltrater_quant;
    private $dig_salt_spray;
    private $dig_salt_spray_quant;
    private $dig_jl_galvano;
    private $dig_jl_galvano_quant;
    private $dig_prada_galvano;
    private $dig_prada_galvano_quant;
    private $fis_direcao;
    private $fis_direcao_quant;
    private $fis_gestao_qualidade;
    private $fis_gestao_qualidade_quant;
    private $fis_vendas;
    private $fis_vendas_quant;
    private $fis_projetos;
    private $fis_projetos_quant;
    private $fis_plan_producao;
    private $fis_plan_producao_quant;
    private $fis_compras;
    private $fis_compras_quant;
    private $fis_almoxarifado;
    private $fis_almoxarifado_quant;
    private $fis_rh;
    private $fis_rh_quant;
    private $fis_ti;
    private $fis_ti_quant;
    private $fis_expedicao;
    private $fis_expedicao_quant;
    private $fis_seguranca;
    private $fis_seguranca_quant;
    private $fis_garantia_qualidade;
    private $fis_garantia_qualidade_quant;
    private $fis_pcp;
    private $fis_pcp_quant;
    private $fis_fosfatizacao;
    private $fis_fosfatizacao_quant;
    private $fis_trefilacao;
    private $fis_trefilacao_quant;
    private $fis_conf_frio_PO;
    private $fis_conf_frio_PO_quant;
    private $fis_conf_frio_PA;
    private $fis_conf_frio_PA_quant;
    private $fis_machos;
    private $fis_machos_quant;
    private $fis_conf_quente;
    private $fis_conf_quente_quant;
    private $fis_forno_rev_cont;
    private $fis_forno_rev_cont_quant;
    private $fis_galvanizacao;
    private $fis_galvanizacao_quant;
    private $fis_lab_galvanizacao;
    private $fis_lab_galvanizacao_quant;
    private $fis_usinagem;
    private $fis_usinagem_quant;
    private $fis_expedicao_expo;
    private $fis_expedicao_expo_quant;
    private $fis_embalagem;
    private $fis_embalagem_quant;
    private $fis_ferramentaria;
    private $fis_ferramentaria_quant;
    private $fis_manutencao;
    private $fis_manutencao_quant;
    private $fis_nylon;
    private $fis_nylon_quant;
    private $fis_ete;
    private $fis_ete_quant;
    private $fis_steeltrater;
    private $fis_steeltrater_quant;
    private $fis_salt_spray;
    private $fis_salt_spray_quant;
    private $fis_jl_galvano;
    private $fis_jl_galvano_quant;
    private $fis_prada_galvano;
    private $fis_prada_galvano_quant;
    private $data_revisao;

    function getData_revisao() {
        return $this->data_revisao;
    }

    function setData_revisao($data_revisao) {
        $this->data_revisao = $data_revisao;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getTotal_Dig() {
        return $this->total_Dig;
    }

    function getTotal_Fis() {
        return $this->total_Fis;
    }

    function getRevisao() {
        return $this->revisao;
    }

    function getDig_direcao() {
        return $this->dig_direcao;
    }

    function getDig_direcao_quant() {
        return $this->dig_direcao_quant;
    }

    function getDig_gestao_qualidade() {
        return $this->dig_gestao_qualidade;
    }

    function getDig_gestao_qualidade_quant() {
        return $this->dig_gestao_qualidade_quant;
    }

    function getDig_vendas() {
        return $this->dig_vendas;
    }

    function getDig_vendas_quant() {
        return $this->dig_vendas_quant;
    }

    function getDig_plan_producao() {
        return $this->dig_plan_producao;
    }

    function getDig_plan_producao_quant() {
        return $this->dig_plan_producao_quant;
    }

    function getDig_compras() {
        return $this->dig_compras;
    }

    function getDig_compras_quant() {
        return $this->dig_compras_quant;
    }

    function getDig_almoxarifado() {
        return $this->dig_almoxarifado;
    }

    function getDig_almoxarifado_quant() {
        return $this->dig_almoxarifado_quant;
    }

    function getDig_rh() {
        return $this->dig_rh;
    }

    function getDig_rh_quant() {
        return $this->dig_rh_quant;
    }

    function getDig_ti() {
        return $this->dig_ti;
    }

    function getDig_ti_quant() {
        return $this->dig_ti_quant;
    }

    function getDig_expedicao() {
        return $this->dig_expedicao;
    }

    function getDig_expedicao_quant() {
        return $this->dig_expedicao_quant;
    }

    function getDig_seguranca() {
        return $this->dig_seguranca;
    }

    function getDig_seguranca_quant() {
        return $this->dig_seguranca_quant;
    }

    function getDig_garantia_qualidade() {
        return $this->dig_garantia_qualidade;
    }

    function getDig_garantia_qualidade_quant() {
        return $this->dig_garantia_qualidade_quant;
    }

    function getDig_pcp() {
        return $this->dig_pcp;
    }

    function getDig_pcp_quant() {
        return $this->dig_pcp_quant;
    }

    function getDig_projetos() {
        return $this->dig_projetos;
    }

    function getDig_projetos_quant() {
        return $this->dig_projetos_quant;
    }

    function getDig_fosfatizacao() {
        return $this->dig_fosfatizacao;
    }

    function getDig_fosfatizacao_quant() {
        return $this->dig_fosfatizacao_quant;
    }

    function getDig_trefilacao() {
        return $this->dig_trefilacao;
    }

    function getDig_trefilacao_quant() {
        return $this->dig_trefilacao_quant;
    }

    function getDig_conf_frio_PO() {
        return $this->dig_conf_frio_PO;
    }

    function getDig_conf_frio_PO_quant() {
        return $this->dig_conf_frio_PO_quant;
    }

    function getDig_conf_frio_PA() {
        return $this->dig_conf_frio_PA;
    }

    function getDig_conf_frio_PA_quant() {
        return $this->dig_conf_frio_PA_quant;
    }

    function getDig_machos() {
        return $this->dig_machos;
    }

    function getDig_machos_quant() {
        return $this->dig_machos_quant;
    }

    function getDig_conf_quente() {
        return $this->dig_conf_quente;
    }

    function getDig_conf_quente_quant() {
        return $this->dig_conf_quente_quant;
    }

    function getDig_forno_rev_cont() {
        return $this->dig_forno_rev_cont;
    }

    function getDig_forno_rev_cont_quant() {
        return $this->dig_forno_rev_cont_quant;
    }

    function getDig_galvanizacao() {
        return $this->dig_galvanizacao;
    }

    function getDig_galvanizacao_quant() {
        return $this->dig_galvanizacao_quant;
    }

    function getDig_lab_galvanizacao() {
        return $this->dig_lab_galvanizacao;
    }

    function getDig_lab_galvanizacao_quant() {
        return $this->dig_lab_galvanizacao_quant;
    }

    function getDig_usinagem() {
        return $this->dig_usinagem;
    }

    function getDig_usinagem_quant() {
        return $this->dig_usinagem_quant;
    }

    function getDig_expedicao_expo() {
        return $this->dig_expedicao_expo;
    }

    function getDig_expedicao_expo_quant() {
        return $this->dig_expedicao_expo_quant;
    }

    function getDig_embalagem() {
        return $this->dig_embalagem;
    }

    function getDig_embalagem_quant() {
        return $this->dig_embalagem_quant;
    }

    function getDig_ferramentaria() {
        return $this->dig_ferramentaria;
    }

    function getDig_ferramentaria_quant() {
        return $this->dig_ferramentaria_quant;
    }

    function getDig_manutencao() {
        return $this->dig_manutencao;
    }

    function getDig_manutencao_quant() {
        return $this->dig_manutencao_quant;
    }

    function getDig_nylon() {
        return $this->dig_nylon;
    }

    function getDig_nylon_quant() {
        return $this->dig_nylon_quant;
    }

    function getDig_ete() {
        return $this->dig_ete;
    }

    function getDig_ete_quant() {
        return $this->dig_ete_quant;
    }

    function getDig_steeltrater() {
        return $this->dig_steeltrater;
    }

    function getDig_steeltrater_quant() {
        return $this->dig_steeltrater_quant;
    }

    function getDig_salt_spray() {
        return $this->dig_salt_spray;
    }

    function getDig_salt_spray_quant() {
        return $this->dig_salt_spray_quant;
    }

    function getDig_jl_galvano() {
        return $this->dig_jl_galvano;
    }

    function getDig_jl_galvano_quant() {
        return $this->dig_jl_galvano_quant;
    }

    function getDig_prada_galvano() {
        return $this->dig_prada_galvano;
    }

    function getDig_prada_galvano_quant() {
        return $this->dig_prada_galvano_quant;
    }

    function getFis_direcao() {
        return $this->fis_direcao;
    }

    function getFis_direcao_quant() {
        return $this->fis_direcao_quant;
    }

    function getFis_gestao_qualidade() {
        return $this->fis_gestao_qualidade;
    }

    function getFis_gestao_qualidade_quant() {
        return $this->fis_gestao_qualidade_quant;
    }

    function getFis_vendas() {
        return $this->fis_vendas;
    }

    function getFis_vendas_quant() {
        return $this->fis_vendas_quant;
    }

    function getFis_projetos() {
        return $this->fis_projetos;
    }

    function getFis_projetos_quant() {
        return $this->fis_projetos_quant;
    }

    function getFis_plan_producao() {
        return $this->fis_plan_producao;
    }

    function getFis_plan_producao_quant() {
        return $this->fis_plan_producao_quant;
    }

    function getFis_compras() {
        return $this->fis_compras;
    }

    function getFis_compras_quant() {
        return $this->fis_compras_quant;
    }

    function getFis_almoxarifado() {
        return $this->fis_almoxarifado;
    }

    function getFis_almoxarifado_quant() {
        return $this->fis_almoxarifado_quant;
    }

    function getFis_rh() {
        return $this->fis_rh;
    }

    function getFis_rh_quant() {
        return $this->fis_rh_quant;
    }

    function getFis_ti() {
        return $this->fis_ti;
    }

    function getFis_ti_quant() {
        return $this->fis_ti_quant;
    }

    function getFis_expedicao() {
        return $this->fis_expedicao;
    }

    function getFis_expedicao_quant() {
        return $this->fis_expedicao_quant;
    }

    function getFis_seguranca() {
        return $this->fis_seguranca;
    }

    function getFis_seguranca_quant() {
        return $this->fis_seguranca_quant;
    }

    function getFis_garantia_qualidade() {
        return $this->fis_garantia_qualidade;
    }

    function getFis_garantia_qualidade_quant() {
        return $this->fis_garantia_qualidade_quant;
    }

    function getFis_pcp() {
        return $this->fis_pcp;
    }

    function getFis_pcp_quant() {
        return $this->fis_pcp_quant;
    }

    function getFis_fosfatizacao() {
        return $this->fis_fosfatizacao;
    }

    function getFis_fosfatizacao_quant() {
        return $this->fis_fosfatizacao_quant;
    }

    function getFis_trefilacao() {
        return $this->fis_trefilacao;
    }

    function getFis_trefilacao_quant() {
        return $this->fis_trefilacao_quant;
    }

    function getFis_conf_frio_PO() {
        return $this->fis_conf_frio_PO;
    }

    function getFis_conf_frio_PO_quant() {
        return $this->fis_conf_frio_PO_quant;
    }

    function getFis_conf_frio_PA() {
        return $this->fis_conf_frio_PA;
    }

    function getFis_conf_frio_PA_quant() {
        return $this->fis_conf_frio_PA_quant;
    }

    function getFis_machos() {
        return $this->fis_machos;
    }

    function getFis_machos_quant() {
        return $this->fis_machos_quant;
    }

    function getFis_conf_quente() {
        return $this->fis_conf_quente;
    }

    function getFis_conf_quente_quant() {
        return $this->fis_conf_quente_quant;
    }

    function getFis_forno_rev_cont() {
        return $this->fis_forno_rev_cont;
    }

    function getFis_forno_rev_cont_quant() {
        return $this->fis_forno_rev_cont_quant;
    }

    function getFis_galvanizacao() {
        return $this->fis_galvanizacao;
    }

    function getFis_galvanizacao_quant() {
        return $this->fis_galvanizacao_quant;
    }

    function getFis_lab_galvanizacao() {
        return $this->fis_lab_galvanizacao;
    }

    function getFis_lab_galvanizacao_quant() {
        return $this->fis_lab_galvanizacao_quant;
    }

    function getFis_usinagem() {
        return $this->fis_usinagem;
    }

    function getFis_usinagem_quant() {
        return $this->fis_usinagem_quant;
    }

    function getFis_expedicao_expo() {
        return $this->fis_expedicao_expo;
    }

    function getFis_expedicao_expo_quant() {
        return $this->fis_expedicao_expo_quant;
    }

    function getFis_embalagem() {
        return $this->fis_embalagem;
    }

    function getFis_embalagem_quant() {
        return $this->fis_embalagem_quant;
    }

    function getFis_ferramentaria() {
        return $this->fis_ferramentaria;
    }

    function getFis_ferramentaria_quant() {
        return $this->fis_ferramentaria_quant;
    }

    function getFis_manutencao() {
        return $this->fis_manutencao;
    }

    function getFis_manutencao_quant() {
        return $this->fis_manutencao_quant;
    }

    function getFis_nylon() {
        return $this->fis_nylon;
    }

    function getFis_nylon_quant() {
        return $this->fis_nylon_quant;
    }

    function getFis_ete() {
        return $this->fis_ete;
    }

    function getFis_ete_quant() {
        return $this->fis_ete_quant;
    }

    function getFis_steeltrater() {
        return $this->fis_steeltrater;
    }

    function getFis_steeltrater_quant() {
        return $this->fis_steeltrater_quant;
    }

    function getFis_salt_spray() {
        return $this->fis_salt_spray;
    }

    function getFis_salt_spray_quant() {
        return $this->fis_salt_spray_quant;
    }

    function getFis_jl_galvano() {
        return $this->fis_jl_galvano;
    }

    function getFis_jl_galvano_quant() {
        return $this->fis_jl_galvano_quant;
    }

    function getFis_prada_galvano() {
        return $this->fis_prada_galvano;
    }

    function getFis_prada_galvano_quant() {
        return $this->fis_prada_galvano_quant;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setTotal_Dig($total_Dig) {
        $this->total_Dig = $total_Dig;
    }

    function setTotal_Fis($total_Fis) {
        $this->total_Fis = $total_Fis;
    }

    function setRevisao($revisao) {
        $this->revisao = $revisao;
    }

    function setDig_direcao($dig_direcao) {
        $this->dig_direcao = $dig_direcao;
    }

    function setDig_direcao_quant($dig_direcao_quant) {
        $this->dig_direcao_quant = $dig_direcao_quant;
    }

    function setDig_gestao_qualidade($dig_gestao_qualidade) {
        $this->dig_gestao_qualidade = $dig_gestao_qualidade;
    }

    function setDig_gestao_qualidade_quant($dig_gestao_qualidade_quant) {
        $this->dig_gestao_qualidade_quant = $dig_gestao_qualidade_quant;
    }

    function setDig_vendas($dig_vendas) {
        $this->dig_vendas = $dig_vendas;
    }

    function setDig_vendas_quant($dig_vendas_quant) {
        $this->dig_vendas_quant = $dig_vendas_quant;
    }

    function setDig_plan_producao($dig_plan_producao) {
        $this->dig_plan_producao = $dig_plan_producao;
    }

    function setDig_plan_producao_quant($dig_plan_producao_quant) {
        $this->dig_plan_producao_quant = $dig_plan_producao_quant;
    }

    function setDig_compras($dig_compras) {
        $this->dig_compras = $dig_compras;
    }

    function setDig_compras_quant($dig_compras_quant) {
        $this->dig_compras_quant = $dig_compras_quant;
    }

    function setDig_almoxarifado($dig_almoxarifado) {
        $this->dig_almoxarifado = $dig_almoxarifado;
    }

    function setDig_almoxarifado_quant($dig_almoxarifado_quant) {
        $this->dig_almoxarifado_quant = $dig_almoxarifado_quant;
    }

    function setDig_rh($dig_rh) {
        $this->dig_rh = $dig_rh;
    }

    function setDig_rh_quant($dig_rh_quant) {
        $this->dig_rh_quant = $dig_rh_quant;
    }

    function setDig_ti($dig_ti) {
        $this->dig_ti = $dig_ti;
    }

    function setDig_ti_quant($dig_ti_quant) {
        $this->dig_ti_quant = $dig_ti_quant;
    }

    function setDig_expedicao($dig_expedicao) {
        $this->dig_expedicao = $dig_expedicao;
    }

    function setDig_expedicao_quant($dig_expedicao_quant) {
        $this->dig_expedicao_quant = $dig_expedicao_quant;
    }

    function setDig_seguranca($dig_seguranca) {
        $this->dig_seguranca = $dig_seguranca;
    }

    function setDig_seguranca_quant($dig_seguranca_quant) {
        $this->dig_seguranca_quant = $dig_seguranca_quant;
    }

    function setDig_garantia_qualidade($dig_garantia_qualidade) {
        $this->dig_garantia_qualidade = $dig_garantia_qualidade;
    }

    function setDig_garantia_qualidade_quant($dig_garantia_qualidade_quant) {
        $this->dig_garantia_qualidade_quant = $dig_garantia_qualidade_quant;
    }

    function setDig_pcp($dig_pcp) {
        $this->dig_pcp = $dig_pcp;
    }

    function setDig_pcp_quant($dig_pcp_quant) {
        $this->dig_pcp_quant = $dig_pcp_quant;
    }

    function setDig_projetos($dig_projetos) {
        $this->dig_projetos = $dig_projetos;
    }

    function setDig_projetos_quant($dig_projetos_quant) {
        $this->dig_projetos_quant = $dig_projetos_quant;
    }

    function setDig_fosfatizacao($dig_fosfatizacao) {
        $this->dig_fosfatizacao = $dig_fosfatizacao;
    }

    function setDig_fosfatizacao_quant($dig_fosfatizacao_quant) {
        $this->dig_fosfatizacao_quant = $dig_fosfatizacao_quant;
    }

    function setDig_trefilacao($dig_trefilacao) {
        $this->dig_trefilacao = $dig_trefilacao;
    }

    function setDig_trefilacao_quant($dig_trefilacao_quant) {
        $this->dig_trefilacao_quant = $dig_trefilacao_quant;
    }

    function setDig_conf_frio_PO($dig_conf_frio_PO) {
        $this->dig_conf_frio_PO = $dig_conf_frio_PO;
    }

    function setDig_conf_frio_PO_quant($dig_conf_frio_PO_quant) {
        $this->dig_conf_frio_PO_quant = $dig_conf_frio_PO_quant;
    }

    function setDig_conf_frio_PA($dig_conf_frio_PA) {
        $this->dig_conf_frio_PA = $dig_conf_frio_PA;
    }

    function setDig_conf_frio_PA_quant($dig_conf_frio_PA_quant) {
        $this->dig_conf_frio_PA_quant = $dig_conf_frio_PA_quant;
    }

    function setDig_machos($dig_machos) {
        $this->dig_machos = $dig_machos;
    }

    function setDig_machos_quant($dig_machos_quant) {
        $this->dig_machos_quant = $dig_machos_quant;
    }

    function setDig_conf_quente($dig_conf_quente) {
        $this->dig_conf_quente = $dig_conf_quente;
    }

    function setDig_conf_quente_quant($dig_conf_quente_quant) {
        $this->dig_conf_quente_quant = $dig_conf_quente_quant;
    }

    function setDig_forno_rev_cont($dig_forno_rev_cont) {
        $this->dig_forno_rev_cont = $dig_forno_rev_cont;
    }

    function setDig_forno_rev_cont_quant($dig_forno_rev_cont_quant) {
        $this->dig_forno_rev_cont_quant = $dig_forno_rev_cont_quant;
    }

    function setDig_galvanizacao($dig_galvanizacao) {
        $this->dig_galvanizacao = $dig_galvanizacao;
    }

    function setDig_galvanizacao_quant($dig_galvanizacao_quant) {
        $this->dig_galvanizacao_quant = $dig_galvanizacao_quant;
    }

    function setDig_lab_galvanizacao($dig_lab_galvanizacao) {
        $this->dig_lab_galvanizacao = $dig_lab_galvanizacao;
    }

    function setDig_lab_galvanizacao_quant($dig_lab_galvanizacao_quant) {
        $this->dig_lab_galvanizacao_quant = $dig_lab_galvanizacao_quant;
    }

    function setDig_usinagem($dig_usinagem) {
        $this->dig_usinagem = $dig_usinagem;
    }

    function setDig_usinagem_quant($dig_usinagem_quant) {
        $this->dig_usinagem_quant = $dig_usinagem_quant;
    }

    function setDig_expedicao_expo($dig_expedicao_expo) {
        $this->dig_expedicao_expo = $dig_expedicao_expo;
    }

    function setDig_expedicao_expo_quant($dig_expedicao_expo_quant) {
        $this->dig_expedicao_expo_quant = $dig_expedicao_expo_quant;
    }

    function setDig_embalagem($dig_embalagem) {
        $this->dig_embalagem = $dig_embalagem;
    }

    function setDig_embalagem_quant($dig_embalagem_quant) {
        $this->dig_embalagem_quant = $dig_embalagem_quant;
    }

    function setDig_ferramentaria($dig_ferramentaria) {
        $this->dig_ferramentaria = $dig_ferramentaria;
    }

    function setDig_ferramentaria_quant($dig_ferramentaria_quant) {
        $this->dig_ferramentaria_quant = $dig_ferramentaria_quant;
    }

    function setDig_manutencao($dig_manutencao) {
        $this->dig_manutencao = $dig_manutencao;
    }

    function setDig_manutencao_quant($dig_manutencao_quant) {
        $this->dig_manutencao_quant = $dig_manutencao_quant;
    }

    function setDig_nylon($dig_nylon) {
        $this->dig_nylon = $dig_nylon;
    }

    function setDig_nylon_quant($dig_nylon_quant) {
        $this->dig_nylon_quant = $dig_nylon_quant;
    }

    function setDig_ete($dig_ete) {
        $this->dig_ete = $dig_ete;
    }

    function setDig_ete_quant($dig_ete_quant) {
        $this->dig_ete_quant = $dig_ete_quant;
    }

    function setDig_steeltrater($dig_steeltrater) {
        $this->dig_steeltrater = $dig_steeltrater;
    }

    function setDig_steeltrater_quant($dig_steeltrater_quant) {
        $this->dig_steeltrater_quant = $dig_steeltrater_quant;
    }

    function setDig_salt_spray($dig_salt_spray) {
        $this->dig_salt_spray = $dig_salt_spray;
    }

    function setDig_salt_spray_quant($dig_salt_spray_quant) {
        $this->dig_salt_spray_quant = $dig_salt_spray_quant;
    }

    function setDig_jl_galvano($dig_jl_galvano) {
        $this->dig_jl_galvano = $dig_jl_galvano;
    }

    function setDig_jl_galvano_quant($dig_jl_galvano_quant) {
        $this->dig_jl_galvano_quant = $dig_jl_galvano_quant;
    }

    function setDig_prada_galvano($dig_prada_galvano) {
        $this->dig_prada_galvano = $dig_prada_galvano;
    }

    function setDig_prada_galvano_quant($dig_prada_galvano_quant) {
        $this->dig_prada_galvano_quant = $dig_prada_galvano_quant;
    }

    function setFis_direcao($fis_direcao) {
        $this->fis_direcao = $fis_direcao;
    }

    function setFis_direcao_quant($fis_direcao_quant) {
        $this->fis_direcao_quant = $fis_direcao_quant;
    }

    function setFis_gestao_qualidade($fis_gestao_qualidade) {
        $this->fis_gestao_qualidade = $fis_gestao_qualidade;
    }

    function setFis_gestao_qualidade_quant($fis_gestao_qualidade_quant) {
        $this->fis_gestao_qualidade_quant = $fis_gestao_qualidade_quant;
    }

    function setFis_vendas($fis_vendas) {
        $this->fis_vendas = $fis_vendas;
    }

    function setFis_vendas_quant($fis_vendas_quant) {
        $this->fis_vendas_quant = $fis_vendas_quant;
    }

    function setFis_projetos($fis_projetos) {
        $this->fis_projetos = $fis_projetos;
    }

    function setFis_projetos_quant($fis_projetos_quant) {
        $this->fis_projetos_quant = $fis_projetos_quant;
    }

    function setFis_plan_producao($fis_plan_producao) {
        $this->fis_plan_producao = $fis_plan_producao;
    }

    function setFis_plan_producao_quant($fis_plan_producao_quant) {
        $this->fis_plan_producao_quant = $fis_plan_producao_quant;
    }

    function setFis_compras($fis_compras) {
        $this->fis_compras = $fis_compras;
    }

    function setFis_compras_quant($fis_compras_quant) {
        $this->fis_compras_quant = $fis_compras_quant;
    }

    function setFis_almoxarifado($fis_almoxarifado) {
        $this->fis_almoxarifado = $fis_almoxarifado;
    }

    function setFis_almoxarifado_quant($fis_almoxarifado_quant) {
        $this->fis_almoxarifado_quant = $fis_almoxarifado_quant;
    }

    function setFis_rh($fis_rh) {
        $this->fis_rh = $fis_rh;
    }

    function setFis_rh_quant($fis_rh_quant) {
        $this->fis_rh_quant = $fis_rh_quant;
    }

    function setFis_ti($fis_ti) {
        $this->fis_ti = $fis_ti;
    }

    function setFis_ti_quant($fis_ti_quant) {
        $this->fis_ti_quant = $fis_ti_quant;
    }

    function setFis_expedicao($fis_expedicao) {
        $this->fis_expedicao = $fis_expedicao;
    }

    function setFis_expedicao_quant($fis_expedicao_quant) {
        $this->fis_expedicao_quant = $fis_expedicao_quant;
    }

    function setFis_seguranca($fis_seguranca) {
        $this->fis_seguranca = $fis_seguranca;
    }

    function setFis_seguranca_quant($fis_seguranca_quant) {
        $this->fis_seguranca_quant = $fis_seguranca_quant;
    }

    function setFis_garantia_qualidade($fis_garantia_qualidade) {
        $this->fis_garantia_qualidade = $fis_garantia_qualidade;
    }

    function setFis_garantia_qualidade_quant($fis_garantia_qualidade_quant) {
        $this->fis_garantia_qualidade_quant = $fis_garantia_qualidade_quant;
    }

    function setFis_pcp($fis_pcp) {
        $this->fis_pcp = $fis_pcp;
    }

    function setFis_pcp_quant($fis_pcp_quant) {
        $this->fis_pcp_quant = $fis_pcp_quant;
    }

    function setFis_fosfatizacao($fis_fosfatizacao) {
        $this->fis_fosfatizacao = $fis_fosfatizacao;
    }

    function setFis_fosfatizacao_quant($fis_fosfatizacao_quant) {
        $this->fis_fosfatizacao_quant = $fis_fosfatizacao_quant;
    }

    function setFis_trefilacao($fis_trefilacao) {
        $this->fis_trefilacao = $fis_trefilacao;
    }

    function setFis_trefilacao_quant($fis_trefilacao_quant) {
        $this->fis_trefilacao_quant = $fis_trefilacao_quant;
    }

    function setFis_conf_frio_PO($fis_conf_frio_PO) {
        $this->fis_conf_frio_PO = $fis_conf_frio_PO;
    }

    function setFis_conf_frio_PO_quant($fis_conf_frio_PO_quant) {
        $this->fis_conf_frio_PO_quant = $fis_conf_frio_PO_quant;
    }

    function setFis_conf_frio_PA($fis_conf_frio_PA) {
        $this->fis_conf_frio_PA = $fis_conf_frio_PA;
    }

    function setFis_conf_frio_PA_quant($fis_conf_frio_PA_quant) {
        $this->fis_conf_frio_PA_quant = $fis_conf_frio_PA_quant;
    }

    function setFis_machos($fis_machos) {
        $this->fis_machos = $fis_machos;
    }

    function setFis_machos_quant($fis_machos_quant) {
        $this->fis_machos_quant = $fis_machos_quant;
    }

    function setFis_conf_quente($fis_conf_quente) {
        $this->fis_conf_quente = $fis_conf_quente;
    }

    function setFis_conf_quente_quant($fis_conf_quente_quant) {
        $this->fis_conf_quente_quant = $fis_conf_quente_quant;
    }

    function setFis_forno_rev_cont($fis_forno_rev_cont) {
        $this->fis_forno_rev_cont = $fis_forno_rev_cont;
    }

    function setFis_forno_rev_cont_quant($fis_forno_rev_cont_quant) {
        $this->fis_forno_rev_cont_quant = $fis_forno_rev_cont_quant;
    }

    function setFis_galvanizacao($fis_galvanizacao) {
        $this->fis_galvanizacao = $fis_galvanizacao;
    }

    function setFis_galvanizacao_quant($fis_galvanizacao_quant) {
        $this->fis_galvanizacao_quant = $fis_galvanizacao_quant;
    }

    function setFis_lab_galvanizacao($fis_lab_galvanizacao) {
        $this->fis_lab_galvanizacao = $fis_lab_galvanizacao;
    }

    function setFis_lab_galvanizacao_quant($fis_lab_galvanizacao_quant) {
        $this->fis_lab_galvanizacao_quant = $fis_lab_galvanizacao_quant;
    }

    function setFis_usinagem($fis_usinagem) {
        $this->fis_usinagem = $fis_usinagem;
    }

    function setFis_usinagem_quant($fis_usinagem_quant) {
        $this->fis_usinagem_quant = $fis_usinagem_quant;
    }

    function setFis_expedicao_expo($fis_expedicao_expo) {
        $this->fis_expedicao_expo = $fis_expedicao_expo;
    }

    function setFis_expedicao_expo_quant($fis_expedicao_expo_quant) {
        $this->fis_expedicao_expo_quant = $fis_expedicao_expo_quant;
    }

    function setFis_embalagem($fis_embalagem) {
        $this->fis_embalagem = $fis_embalagem;
    }

    function setFis_embalagem_quant($fis_embalagem_quant) {
        $this->fis_embalagem_quant = $fis_embalagem_quant;
    }

    function setFis_ferramentaria($fis_ferramentaria) {
        $this->fis_ferramentaria = $fis_ferramentaria;
    }

    function setFis_ferramentaria_quant($fis_ferramentaria_quant) {
        $this->fis_ferramentaria_quant = $fis_ferramentaria_quant;
    }

    function setFis_manutencao($fis_manutencao) {
        $this->fis_manutencao = $fis_manutencao;
    }

    function setFis_manutencao_quant($fis_manutencao_quant) {
        $this->fis_manutencao_quant = $fis_manutencao_quant;
    }

    function setFis_nylon($fis_nylon) {
        $this->fis_nylon = $fis_nylon;
    }

    function setFis_nylon_quant($fis_nylon_quant) {
        $this->fis_nylon_quant = $fis_nylon_quant;
    }

    function setFis_ete($fis_ete) {
        $this->fis_ete = $fis_ete;
    }

    function setFis_ete_quant($fis_ete_quant) {
        $this->fis_ete_quant = $fis_ete_quant;
    }

    function setFis_steeltrater($fis_steeltrater) {
        $this->fis_steeltrater = $fis_steeltrater;
    }

    function setFis_steeltrater_quant($fis_steeltrater_quant) {
        $this->fis_steeltrater_quant = $fis_steeltrater_quant;
    }

    function setFis_salt_spray($fis_salt_spray) {
        $this->fis_salt_spray = $fis_salt_spray;
    }

    function setFis_salt_spray_quant($fis_salt_spray_quant) {
        $this->fis_salt_spray_quant = $fis_salt_spray_quant;
    }

    function setFis_jl_galvano($fis_jl_galvano) {
        $this->fis_jl_galvano = $fis_jl_galvano;
    }

    function setFis_jl_galvano_quant($fis_jl_galvano_quant) {
        $this->fis_jl_galvano_quant = $fis_jl_galvano_quant;
    }

    function setFis_prada_galvano($fis_prada_galvano) {
        $this->fis_prada_galvano = $fis_prada_galvano;
    }

    function setFis_prada_galvano_quant($fis_prada_galvano_quant) {
        $this->fis_prada_galvano_quant = $fis_prada_galvano_quant;
    }

}
