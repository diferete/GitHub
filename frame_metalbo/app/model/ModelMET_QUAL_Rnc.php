<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_QUAL_Rnc {

    private $nr;
    private $filcgc;
    private $codprobl;
    private $databert;
    private $horaini;
    private $codprod;
    private $codmat;
    private $sit;
    private $op;
    private $lote;
    private $corrida;
    private $qtlote;
    private $qtloternc;
    private $descset01;
    private $userini;
    private $turno01;
    private $tipornc;
    private $fornec;
    private $descrnc;
    private $descset02;
    private $turno02;
    private $usercausa;
    private $causarnc;
    private $desccausa;
    private $decisaornc;
    private $descdescirnc;
    private $respcausa;
    private $lidercausa;
    private $userf;
    private $dataf;
    private $horaf;
    private $anexo1;
    private $anexo2;
    private $anexo3;
    private $anexo4;
    private $MET_QUAL_Prob_Rnc;
    private $Pessoa;
    private $empdes;
    
    function getPessoa() {
     if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

        
    function getFornec() {
        return $this->fornec;
    }

    function setFornec($fornec) {
        $this->fornec = $fornec;
    }

    
    function getMET_QUAL_Prob_Rnc() {
        if (!isset($this->MET_QUAL_Prob_Rnc)) {
            $this->MET_QUAL_Prob_Rnc = Fabrica::FabricarModel('MET_QUAL_Prob_Rnc');
        }
        return $this->MET_QUAL_Prob_Rnc;
    }

    function setMET_QUAL_Prob_Rnc($MET_QUAL_Prob_Rnc) {
        $this->MET_QUAL_Prob_Rnc = $MET_QUAL_Prob_Rnc;
    }

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getCodprobl() {
        return $this->codprobl;
    }

    function getDatabert() {
        return $this->databert;
    }

    function getHoraini() {
        return $this->horaini;
    }

    function getCodprod() {
        return $this->codprod;
    }

    function getCodmat() {
        return $this->codmat;
    }

    function getSit() {
        return $this->sit;
    }

    function getOp() {
        return $this->op;
    }

    function getLote() {
        return $this->lote;
    }

    function getCorrida() {
        return $this->corrida;
    }

    function getQtlote() {
        return $this->qtlote;
    }

    function getQtloternc() {
        return $this->qtloternc;
    }

    function getDescset01() {
        return $this->descset01;
    }

    function getUserini() {
        return $this->userini;
    }

    function getTurno01() {
        return $this->turno01;
    }

    function getTipornc() {
        return $this->tipornc;
    }

    function getDescrnc() {
        return $this->descrnc;
    }

    function getDescset02() {
        return $this->descset02;
    }

    function getTurno02() {
        return $this->turno02;
    }

    function getUsercausa() {
        return $this->usercausa;
    }

    function getCausarnc() {
        return $this->causarnc;
    }

    function getDesccausa() {
        return $this->desccausa;
    }

    function getDecisaornc() {
        return $this->decisaornc;
    }

    function getDescdescirnc() {
        return $this->descdescirnc;
    }

    function getRespcausa() {
        return $this->respcausa;
    }

    function getLidercausa() {
        return $this->lidercausa;
    }

    function getUserf() {
        return $this->userf;
    }

    function getDataf() {
        return $this->dataf;
    }

    function getHoraf() {
        return $this->horaf;
    }

    function getAnexo1() {
        return $this->anexo1;
    }

    function getAnexo2() {
        return $this->anexo2;
    }

    function getAnexo3() {
        return $this->anexo3;
    }

    function getAnexo4() {
        return $this->anexo4;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setCodprobl($codprobl) {
        $this->codprobl = $codprobl;
    }

    function setDatabert($databert) {
        $this->databert = $databert;
    }

    function setHoraini($horaini) {
        $this->horaini = $horaini;
    }

    function setCodprod($codprod) {
        $this->codprod = $codprod;
    }

    function setCodmat($codmat) {
        $this->codmat = $codmat;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setLote($lote) {
        $this->lote = $lote;
    }

    function setCorrida($corrida) {
        $this->corrida = $corrida;
    }

    function setQtlote($qtlote) {
        $this->qtlote = $qtlote;
    }

    function setQtloternc($qtloternc) {
        $this->qtloternc = $qtloternc;
    }

    function setDescset01($descset01) {
        $this->descset01 = $descset01;
    }

    function setUserini($userini) {
        $this->userini = $userini;
    }

    function setTurno01($turno01) {
        $this->turno01 = $turno01;
    }

    function setTipornc($tipornc) {
        $this->tipornc = $tipornc;
    }

    function setDescrnc($descrnc) {
        $this->descrnc = $descrnc;
    }

    function setDescset02($descset02) {
        $this->descset02 = $descset02;
    }

    function setTurno02($turno02) {
        $this->turno02 = $turno02;
    }

    function setUsercausa($usercausa) {
        $this->usercausa = $usercausa;
    }

    function setCausarnc($causarnc) {
        $this->causarnc = $causarnc;
    }

    function setDesccausa($desccausa) {
        $this->desccausa = $desccausa;
    }

    function setDecisaornc($decisaornc) {
        $this->decisaornc = $decisaornc;
    }

    function setDescdescirnc($descdescirnc) {
        $this->descdescirnc = $descdescirnc;
    }

    function setRespcausa($respcausa) {
        $this->respcausa = $respcausa;
    }

    function setLidercausa($lidercausa) {
        $this->lidercausa = $lidercausa;
    }

    function setUserf($userf) {
        $this->userf = $userf;
    }

    function setDataf($dataf) {
        $this->dataf = $dataf;
    }

    function setHoraf($horaf) {
        $this->horaf = $horaf;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

    function setAnexo3($anexo3) {
        $this->anexo3 = $anexo3;
    }

    function setAnexo4($anexo4) {
        $this->anexo4 = $anexo4;
    }

}
