<?php

/*
 * Class Model 
 * 
 * @autor Avanei Martendal
 * 
 * @since 01/06/2017
 */

class ModelQualAqPlan {

    private $filcgc;
    private $nr;
    private $seq;
    private $plano;
    private $dataprev;
    private $datafim;
    private $obsfim;
    private $sitfim;
    private $anexoplan1;
    private $usucodigo;
    private $usunome;
    private $anexofim;
    private $tipo;
    private $nrEfi;
    private $funcao;
    private $treinamento;
    private $preventiva;
    private $contexto;
    private $ppap;
    private $planocontrole;
    private $it;
    private $procedimento;
    private $fluxograma;

    function getFuncao() {
        return $this->funcao;
    }

    function getTreinamento() {
        return $this->treinamento;
    }

    function getPreventiva() {
        return $this->preventiva;
    }

    function getContexto() {
        return $this->contexto;
    }

    function getPpap() {
        return $this->ppap;
    }

    function getPlanocontrole() {
        return $this->planocontrole;
    }

    function getIt() {
        return $this->it;
    }

    function getProcedimento() {
        return $this->procedimento;
    }

    function getFluxograma() {
        return $this->fluxograma;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setTreinamento($treinamento) {
        $this->treinamento = $treinamento;
    }

    function setPreventiva($preventiva) {
        $this->preventiva = $preventiva;
    }

    function setContexto($contexto) {
        $this->contexto = $contexto;
    }

    function setPpap($ppap) {
        $this->ppap = $ppap;
    }

    function setPlanocontrole($planocontrole) {
        $this->planocontrole = $planocontrole;
    }

    function setIt($it) {
        $this->it = $it;
    }

    function setProcedimento($procedimento) {
        $this->procedimento = $procedimento;
    }

    function setFluxograma($fluxograma) {
        $this->fluxograma = $fluxograma;
    }

    function getDatafim() {
        return $this->datafim;
    }

    function getObsfim() {
        return $this->obsfim;
    }

    function getSitfim() {
        return $this->sitfim;
    }

    function getAnexofim() {
        return $this->anexofim;
    }

    function getNrEfi() {
        return $this->nrEfi;
    }

    function setDatafim($datafim) {
        $this->datafim = $datafim;
    }

    function setObsfim($obsfim) {
        $this->obsfim = $obsfim;
    }

    function setSitfim($sitfim) {
        $this->sitfim = $sitfim;
    }

    function setAnexofim($anexofim) {
        $this->anexofim = $anexofim;
    }

    function setNrEfi($nrEfi) {
        $this->nrEfi = $nrEfi;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function getAnexoplan1() {
        return $this->anexoplan1;
    }

    function setAnexoplan1($anexoplan1) {
        $this->anexoplan1 = $anexoplan1;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getPlano() {
        return $this->plano;
    }

    function getDataprev() {
        return $this->dataprev;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }

}
