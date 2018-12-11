<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualNovoProjProd {

    private $EmpRex;
    private $nr;
    private $dtimp;
    private $resp_proj_nome;
    private $resp_venda_nome;
    private $desc_novo_prod;
    private $obsaprovcli;
    private $sitgeralproj;
    private $sitcliente;
    private $procod;
    private $prodsimilar;
    private $procodsimilar;
    private $chavemin;
    private $chavemax;
    private $altmin;
    private $altmax;
    private $diamfmin;
    private $diamfmax;
    private $compmin;
    private $compmax;
    private $diampmin;
    private $diampmax;
    private $diamexmin;
    private $diamexmax;
    private $comprmin;
    private $comprmax;
    private $comphmin;
    private $comphmax;
    private $diamhmin;
    private $diamhmax;
    private $anghelice;
    private $acab;
    private $material;
    private $classe;
    private $tiprosca;
    private $normadimen;
    private $normarosca;
    private $normapropmec;
    private $ppap;
    private $vendaprev;
    private $reqcli;
    private $codresproj;
    private $respproj;
    private $dataprod;
    private $dadosent;
    private $dadosent_obs;
    private $reqlegal;
    private $reqlegal_obs;
    private $reqadicional;
    private $reqadicional_obs;
    private $reqadverif;
    private $reqadverif_obs;
    private $reqadval;
    private $reqadval_obs;
    private $reqproblem;
    private $reqproblem_obs;
    private $comem;
    private $grucod;
    private $subcod;
    private $famcod;
    private $famsub;
    private $profcanecomin;
    private $profcanecomax;

    function getProfcanecomin() {
        return $this->profcanecomin;
    }

    function getProfcanecomax() {
        return $this->profcanecomax;
    }

    function setProfcanecomin($profcanecomin) {
        $this->profcanecomin = $profcanecomin;
    }

    function setProfcanecomax($profcanecomax) {
        $this->profcanecomax = $profcanecomax;
    }

    function getSubcod() {
        return $this->subcod;
    }

    function getFamcod() {
        return $this->famcod;
    }

    function getFamsub() {
        return $this->famsub;
    }

    function setSubcod($subcod) {
        $this->subcod = $subcod;
    }

    function setFamcod($famcod) {
        $this->famcod = $famcod;
    }

    function setFamsub($famsub) {
        $this->famsub = $famsub;
    }

    function getGrucod() {
        return $this->grucod;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function getSitcliente() {
        return $this->sitcliente;
    }

    function setSitcliente($sitcliente) {
        $this->sitcliente = $sitcliente;
    }

    function getComem() {
        return $this->comem;
    }

    function setComem($comem) {
        $this->comem = $comem;
    }

    function getReqproblem() {
        return $this->reqproblem;
    }

    function getReqproblem_obs() {
        return $this->reqproblem_obs;
    }

    function setReqproblem($reqproblem) {
        $this->reqproblem = $reqproblem;
    }

    function setReqproblem_obs($reqproblem_obs) {
        $this->reqproblem_obs = $reqproblem_obs;
    }

    function getReqadval() {
        return $this->reqadval;
    }

    function getReqadval_obs() {
        return $this->reqadval_obs;
    }

    function setReqadval($reqadval) {
        $this->reqadval = $reqadval;
    }

    function setReqadval_obs($reqadval_obs) {
        $this->reqadval_obs = $reqadval_obs;
    }

    function getReqadicional() {
        return $this->reqadicional;
    }

    function getReqadicional_obs() {
        return $this->reqadicional_obs;
    }

    function getReqadverif() {
        return $this->reqadverif;
    }

    function getReqadverif_obs() {
        return $this->reqadverif_obs;
    }

    function setReqadicional($reqadicional) {
        $this->reqadicional = $reqadicional;
    }

    function setReqadicional_obs($reqadicional_obs) {
        $this->reqadicional_obs = $reqadicional_obs;
    }

    function setReqadverif($reqadverif) {
        $this->reqadverif = $reqadverif;
    }

    function setReqadverif_obs($reqadverif_obs) {
        $this->reqadverif_obs = $reqadverif_obs;
    }

    function getDadosent() {
        return $this->dadosent;
    }

    function getDadosent_obs() {
        return $this->dadosent_obs;
    }

    function getReqlegal() {
        return $this->reqlegal;
    }

    function getReqlegal_obs() {
        return $this->reqlegal_obs;
    }

    function setDadosent($dadosent) {
        $this->dadosent = $dadosent;
    }

    function setDadosent_obs($dadosent_obs) {
        $this->dadosent_obs = $dadosent_obs;
    }

    function setReqlegal($reqlegal) {
        $this->reqlegal = $reqlegal;
    }

    function setReqlegal_obs($reqlegal_obs) {
        $this->reqlegal_obs = $reqlegal_obs;
    }

    function getPpap() {
        return $this->ppap;
    }

    function getVendaprev() {
        return $this->vendaprev;
    }

    function getReqcli() {
        return $this->reqcli;
    }

    function getCodresproj() {
        return $this->codresproj;
    }

    function getRespproj() {
        return $this->respproj;
    }

    function getDataprod() {
        return $this->dataprod;
    }

    function setPpap($ppap) {
        $this->ppap = $ppap;
    }

    function setVendaprev($vendaprev) {
        $this->vendaprev = $vendaprev;
    }

    function setReqcli($reqcli) {
        $this->reqcli = $reqcli;
    }

    function setCodresproj($codresproj) {
        $this->codresproj = $codresproj;
    }

    function setRespproj($respproj) {
        $this->respproj = $respproj;
    }

    function setDataprod($dataprod) {
        $this->dataprod = $dataprod;
    }

    function getTiprosca() {
        return $this->tiprosca;
    }

    function getNormadimen() {
        return $this->normadimen;
    }

    function getNormarosca() {
        return $this->normarosca;
    }

    function getNormapropmec() {
        return $this->normapropmec;
    }

    function setTiprosca($tiprosca) {
        $this->tiprosca = $tiprosca;
    }

    function setNormadimen($normadimen) {
        $this->normadimen = $normadimen;
    }

    function setNormarosca($normarosca) {
        $this->normarosca = $normarosca;
    }

    function setNormapropmec($normapropmec) {
        $this->normapropmec = $normapropmec;
    }

    function getAcab() {
        return $this->acab;
    }

    function getMaterial() {
        return $this->material;
    }

    function getClasse() {
        return $this->classe;
    }

    function setAcab($acab) {
        $this->acab = $acab;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

    function getChavemin() {
        return $this->chavemin;
    }

    function getChavemax() {
        return $this->chavemax;
    }

    function getAltmin() {
        return $this->altmin;
    }

    function getAltmax() {
        return $this->altmax;
    }

    function getDiamfmin() {
        return $this->diamfmin;
    }

    function getDiamfmax() {
        return $this->diamfmax;
    }

    function getCompmin() {
        return $this->compmin;
    }

    function getCompmax() {
        return $this->compmax;
    }

    function getDiampmin() {
        return $this->diampmin;
    }

    function getDiampmax() {
        return $this->diampmax;
    }

    function getDiamexmin() {
        return $this->diamexmin;
    }

    function getDiamexmax() {
        return $this->diamexmax;
    }

    function getComprmin() {
        return $this->comprmin;
    }

    function getComprmax() {
        return $this->comprmax;
    }

    function getComphmin() {
        return $this->comphmin;
    }

    function getComphmax() {
        return $this->comphmax;
    }

    function getDiamhmin() {
        return $this->diamhmin;
    }

    function getDiamhmax() {
        return $this->diamhmax;
    }

    function getAnghelice() {
        return $this->anghelice;
    }

    function setChavemin($chavemin) {
        $this->chavemin = $chavemin;
    }

    function setChavemax($chavemax) {
        $this->chavemax = $chavemax;
    }

    function setAltmin($altmin) {
        $this->altmin = $altmin;
    }

    function setAltmax($altmax) {
        $this->altmax = $altmax;
    }

    function setDiamfmin($diamfmin) {
        $this->diamfmin = $diamfmin;
    }

    function setDiamfmax($diamfmax) {
        $this->diamfmax = $diamfmax;
    }

    function setCompmin($compmin) {
        $this->compmin = $compmin;
    }

    function setCompmax($compmax) {
        $this->compmax = $compmax;
    }

    function setDiampmin($diampmin) {
        $this->diampmin = $diampmin;
    }

    function setDiampmax($diampmax) {
        $this->diampmax = $diampmax;
    }

    function setDiamexmin($diamexmin) {
        $this->diamexmin = $diamexmin;
    }

    function setDiamexmax($diamexmax) {
        $this->diamexmax = $diamexmax;
    }

    function setComprmin($comprmin) {
        $this->comprmin = $comprmin;
    }

    function setComprmax($comprmax) {
        $this->comprmax = $comprmax;
    }

    function setComphmin($comphmin) {
        $this->comphmin = $comphmin;
    }

    function setComphmax($comphmax) {
        $this->comphmax = $comphmax;
    }

    function setDiamhmin($diamhmin) {
        $this->diamhmin = $diamhmin;
    }

    function setDiamhmax($diamhmax) {
        $this->diamhmax = $diamhmax;
    }

    function setAnghelice($anghelice) {
        $this->anghelice = $anghelice;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdsimilar() {
        return $this->prodsimilar;
    }

    function getProcodsimilar() {
        return $this->procodsimilar;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdsimilar($prodsimilar) {
        $this->prodsimilar = $prodsimilar;
    }

    function setProcodsimilar($procodsimilar) {
        $this->procodsimilar = $procodsimilar;
    }

    function getSitgeralproj() {
        return $this->sitgeralproj;
    }

    function setSitgeralproj($sitgeralproj) {
        $this->sitgeralproj = $sitgeralproj;
    }

    function getObsaprovcli() {
        return $this->obsaprovcli;
    }

    function setObsaprovcli($obsaprovcli) {
        $this->obsaprovcli = $obsaprovcli;
    }

    function getDesc_novo_prod() {
        return $this->desc_novo_prod;
    }

    function setDesc_novo_prod($desc_novo_prod) {
        $this->desc_novo_prod = $desc_novo_prod;
    }

    function getResp_proj_nome() {
        return $this->resp_proj_nome;
    }

    function setResp_proj_nome($resp_proj_nome) {
        $this->resp_proj_nome = $resp_proj_nome;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

    function getDtimp() {
        return $this->dtimp;
    }

    function setDtimp($dtimp) {
        $this->dtimp = $dtimp;
    }

    function getEmpRex() {
        if (!isset($this->EmpRex)) {
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }

        return $this->EmpRex;
    }

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

    function getNr() {
        return $this->nr;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

}
