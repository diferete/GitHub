<?php

/*
 * Classe que implementa o model da classe CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ModelCadCliRep {

    private $nr;
    private $empcod;
    private $empdes;
    private $empfj;
    private $empconfina;
    private $pagast;
    private $simplesNacional;
    private $empdtcad;
    private $empusucad;
    private $empfant;
    private $empativo;
    private $empfone;
    private $empinterne;
    private $empend;
    private $cidcep;
    private $empendbair;
    private $empins;
    private $empobs;
    private $repcod;
    private $usucodigo;
    private $empmunicipio;
    private $uf;
    private $officecod;
    private $officedes;
    private $emailNfe;
    private $situaca;
    private $dtlib;
    private $horalib;
    private $resp_venda_cod;
    private $resp_venda_nome;
    private $empnr;
    private $empcobbco;
    private $empcobcar;
    private $certcli;
    private $comer;
    private $transp;

    function getComer() {
        return $this->comer;
    }

    function getTransp() {
        return $this->transp;
    }

    function setComer($comer) {
        $this->comer = $comer;
    }

    function setTransp($transp) {
        $this->transp = $transp;
    }

    function getCertcli() {
        return $this->certcli;
    }

    function setCertcli($certcli) {
        $this->certcli = $certcli;
    }

    function getEmpcobbco() {
        return $this->empcobbco;
    }

    function getEmpcobcar() {
        return $this->empcobcar;
    }

    function setEmpcobbco($empcobbco) {
        $this->empcobbco = $empcobbco;
    }

    function setEmpcobcar($empcobcar) {
        $this->empcobcar = $empcobcar;
    }

    function getEmpnr() {
        return $this->empnr;
    }

    function setEmpnr($empnr) {
        $this->empnr = $empnr;
    }

    function getResp_venda_cod() {
        return $this->resp_venda_cod;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setResp_venda_cod($resp_venda_cod) {
        $this->resp_venda_cod = $resp_venda_cod;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function getDtlib() {
        return $this->dtlib;
    }

    function getHoralib() {
        return $this->horalib;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function setDtlib($dtlib) {
        $this->dtlib = $dtlib;
    }

    function setHoralib($horalib) {
        $this->horalib = $horalib;
    }

    function getEmailNfe() {
        return $this->emailNfe;
    }

    function setEmailNfe($emailNfe) {
        $this->emailNfe = $emailNfe;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function getOfficedes() {
        return $this->officedes;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function setOfficedes($officedes) {
        $this->officedes = $officedes;
    }

    function getUf() {
        return $this->uf;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function getEmpmunicipio() {
        return $this->empmunicipio;
    }

    function setEmpmunicipio($empmunicipio) {
        $this->empmunicipio = $empmunicipio;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function getEmpfj() {
        return $this->empfj;
    }

    function getEmpconfina() {
        return $this->empconfina;
    }

    function getPagast() {
        return $this->pagast;
    }

    function getSimplesNacional() {
        return $this->simplesNacional;
    }

    function getEmpdtcad() {
        return $this->empdtcad;
    }

    function getEmpusucad() {
        return $this->empusucad;
    }

    function getEmpfant() {
        return $this->empfant;
    }

    function getEmpativo() {
        return $this->empativo;
    }

    function getEmpfone() {
        return $this->empfone;
    }

    function getEmpinterne() {
        return $this->empinterne;
    }

    function getEmpend() {
        return $this->empend;
    }

    function getCidcep() {
        return $this->cidcep;
    }

    function getEmpendbair() {
        return $this->empendbair;
    }

    function getEmpins() {
        return $this->empins;
    }

    function getEmpobs() {
        return $this->empobs;
    }

    function getRepcod() {
        return $this->repcod;
    }

    function setEmpfj($empfj) {
        $this->empfj = $empfj;
    }

    function setEmpconfina($empconfina) {
        $this->empconfina = $empconfina;
    }

    function setPagast($pagast) {
        $this->pagast = $pagast;
    }

    function setSimplesNacional($simplesNacional) {
        $this->simplesNacional = $simplesNacional;
    }

    function setEmpdtcad($empdtcad) {
        $this->empdtcad = $empdtcad;
    }

    function setEmpusucad($empusucad) {
        $this->empusucad = $empusucad;
    }

    function setEmpfant($empfant) {
        $this->empfant = $empfant;
    }

    function setEmpativo($empativo) {
        $this->empativo = $empativo;
    }

    function setEmpfone($empfone) {
        $this->empfone = $empfone;
    }

    function setEmpinterne($empinterne) {
        $this->empinterne = $empinterne;
    }

    function setEmpend($empend) {
        $this->empend = $empend;
    }

    function setCidcep($cidcep) {
        $this->cidcep = $cidcep;
    }

    function setEmpendbair($empendbair) {
        $this->empendbair = $empendbair;
    }

    function setEmpins($empins) {
        $this->empins = $empins;
    }

    function setEmpobs($empobs) {
        $this->empobs = $empobs;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

    function getNr() {
        return $this->nr;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

}
