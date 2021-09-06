<?php

/*
 * Implementa a classe model MET_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ModelMET_SOL_Aprovacoes {

    private $filcgc;
    private $solcod;
    private $Pessoa;
    private $soldata;
    private $solobs;
    private $solususoli;
    private $solusuapro;
    private $solsituaca;
    private $soldtaapro;
    private $solpedido;
    private $solusu;
    private $ccnro;
    private $solctad;
    private $solctac;
    private $solpdvnro;
    private $solsimcod;
    private $solsms;
    private $solarecod;
    private $sollocent;
    private $solaprovad;
    private $solhraapro;
    private $solreglib;
    private $solmrpnroc;

    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getSolcod() {
        return $this->solcod;
    }

    function getSoldata() {
        return $this->soldata;
    }

    function getSolobs() {
        return $this->solobs;
    }

    function getSolususoli() {
        return $this->solususoli;
    }

    function getSolusuapro() {
        return $this->solusuapro;
    }

    function getSolsituaca() {
        return $this->solsituaca;
    }

    function getSoldtaapro() {
        return $this->soldtaapro;
    }

    function getSolpedido() {
        return $this->solpedido;
    }

    function getSolusu() {
        return $this->solusu;
    }

    function getCcnro() {
        return $this->ccnro;
    }

    function getSolctad() {
        return $this->solctad;
    }

    function getSolctac() {
        return $this->solctac;
    }

    function getSolpdvnro() {
        return $this->solpdvnro;
    }

    function getSolsimcod() {
        return $this->solsimcod;
    }

    function getSolsms() {
        return $this->solsms;
    }

    function getSolarecod() {
        return $this->solarecod;
    }

    function getSollocent() {
        return $this->sollocent;
    }

    function getSolaprovad() {
        return $this->solaprovad;
    }

    function getSolhraapro() {
        return $this->solhraapro;
    }

    function getSolreglib() {
        return $this->solreglib;
    }

    function getSolmrpnroc() {
        return $this->solmrpnroc;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setSolcod($solcod) {
        $this->solcod = $solcod;
    }

    function setSoldata($soldata) {
        $this->soldata = $soldata;
    }

    function setSolobs($solobs) {
        $this->solobs = $solobs;
    }

    function setSolususoli($solususoli) {
        $this->solususoli = $solususoli;
    }

    function setSolusuapro($solusuapro) {
        $this->solusuapro = $solusuapro;
    }

    function setSolsituaca($solsituaca) {
        $this->solsituaca = $solsituaca;
    }

    function setSoldtaapro($soldtaapro) {
        $this->soldtaapro = $soldtaapro;
    }

    function setSolpedido($solpedido) {
        $this->solpedido = $solpedido;
    }

    function setSolusu($solusu) {
        $this->solusu = $solusu;
    }

    function setCcnro($ccnro) {
        $this->ccnro = $ccnro;
    }

    function setSolctad($solctad) {
        $this->solctad = $solctad;
    }

    function setSolctac($solctac) {
        $this->solctac = $solctac;
    }

    function setSolpdvnro($solpdvnro) {
        $this->solpdvnro = $solpdvnro;
    }

    function setSolsimcod($solsimcod) {
        $this->solsimcod = $solsimcod;
    }

    function setSolsms($solsms) {
        $this->solsms = $solsms;
    }

    function setSolarecod($solarecod) {
        $this->solarecod = $solarecod;
    }

    function setSollocent($sollocent) {
        $this->sollocent = $sollocent;
    }

    function setSolaprovad($solaprovad) {
        $this->solaprovad = $solaprovad;
    }

    function setSolhraapro($solhraapro) {
        $this->solhraapro = $solhraapro;
    }

    function setSolreglib($solreglib) {
        $this->solreglib = $solreglib;
    }

    function setSolmrpnroc($solmrpnroc) {
        $this->solmrpnroc = $solmrpnroc;
    }

}
