<?php

/*
 * Classe que implementa o modelo de dados dos usuários
 * @author Avanei Martendal
 * @since 25/12/2015
 */

class ModelMET_TEC_Usuario {

    private $usucodigo;
    private $usunome;
    private $ususobrenome;
    private $usulogin;
    private $ususenha;
    private $usuimagem;
    private $usucracha;
    private $usufone;
    private $usuramal;
    private $emp_steeltrater;
    private $emp_poliamidos;
    private $emp_metalbo_filial;
    private $emp_metalbo_matriz;
    private $usubloqueado;
    private $usuemail;
    private $filcgc;
    private $officecod;
    private $MET_TEC_UsuTipo;
    private $MET_CAD_Setores;
    private $ususalvasenha;
    private $ususit;
    private $senhaProvisoria;
    private $usunomeDelsoft;
    private $codsismetalbo;
    private $turnoSteel;

    function getEmp_metalbo_filial() {
        return $this->emp_metalbo_filial;
    }

    function getEmp_metalbo_matriz() {
        return $this->emp_metalbo_matriz;
    }

    function setEmp_metalbo_filial($emp_metalbo_filial) {
        $this->emp_metalbo_filial = $emp_metalbo_filial;
    }

    function setEmp_metalbo_matriz($emp_metalbo_matriz) {
        $this->emp_metalbo_matriz = $emp_metalbo_matriz;
    }

    function getEmp_steeltrater() {
        return $this->emp_steeltrater;
    }

    function getEmp_poliamidos() {
        return $this->emp_poliamidos;
    }

    function setEmp_steeltrater($emp_steeltrater) {
        $this->emp_steeltrater = $emp_steeltrater;
    }

    function setEmp_poliamidos($emp_poliamidos) {
        $this->emp_poliamidos = $emp_poliamidos;
    }

    function getTurnoSteel() {
        return $this->turnoSteel;
    }

    function setTurnoSteel($turnoSteel) {
        $this->turnoSteel = $turnoSteel;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

    function getCodsismetalbo() {
        return $this->codsismetalbo;
    }

    function setCodsismetalbo($codsismetalbo) {
        $this->codsismetalbo = $codsismetalbo;
    }

    function getUsunomeDelsoft() {
        return $this->usunomeDelsoft;
    }

    function setUsunomeDelsoft($usunomeDelsoft) {
        $this->usunomeDelsoft = $usunomeDelsoft;
    }

    function getSenhaProvisoria() {
        return $this->senhaProvisoria;
    }

    function setSenhaProvisoria($senhaProvisoria) {
        $this->senhaProvisoria = $senhaProvisoria;
    }

    function getUsusit() {
        return $this->ususit;
    }

    function setUsusit($ususit) {
        $this->ususit = $ususit;
    }

    function getUsusalvasenha() {
        return $this->ususalvasenha;
    }

    function setUsusalvasenha($ususalvasenha) {
        $this->ususalvasenha = $ususalvasenha;
    }

    function getMET_TEC_UsuTipo() {
        if (!isset($this->MET_TEC_UsuTipo)) {
            $this->MET_TEC_UsuTipo = Fabrica::FabricarModel('MET_TEC_UsuTipo');
        }
        return $this->MET_TEC_UsuTipo;
    }

    function setMET_TEC_UsuTipo($MET_TEC_UsuTipo) {
        $this->MET_TEC_UsuTipo = $MET_TEC_UsuTipo;
    }

    function getMET_CAD_Setores() {
        if (!isset($this->MET_CAD_Setores)) {
            $this->MET_CAD_Setores = Fabrica::FabricarModel('MET_CAD_Setores');
        }
        return $this->MET_CAD_Setores;
    }

    function setMET_CAD_Setores($MET_CAD_Setores) {
        $this->MET_CAD_Setores = $MET_CAD_Setores;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function getUsuemail() {
        return $this->usuemail;
    }

    function setUsuemail($usuemail) {
        $this->usuemail = $usuemail;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getUsulogin() {
        return $this->usulogin;
    }

    function getUsusenha() {
        return $this->ususenha;
    }

    function getUsubloqueado() {
        return $this->usubloqueado;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setUsulogin($usulogin) {
        $this->usulogin = $usulogin;
    }

    function setUsusenha($ususenha) {
        $this->ususenha = $ususenha;
    }

    function setUsubloqueado($usubloqueado) {
        $this->usubloqueado = $usubloqueado;
    }

    function getUsuimagem() {
        return $this->usuimagem;
    }

    function setUsuimagem($usuimagem) {
        $this->usuimagem = $usuimagem;
    }

    function getUsusobrenome() {
        return $this->ususobrenome;
    }

    function getUsucracha() {
        return $this->usucracha;
    }

    function getUsufone() {
        return $this->usufone;
    }

    function getUsuramal() {
        return $this->usuramal;
    }

    function setUsusobrenome($ususobrenome) {
        $this->ususobrenome = $ususobrenome;
    }

    function setUsucracha($usucracha) {
        $this->usucracha = $usucracha;
    }

    function setUsufone($usufone) {
        $this->usufone = $usufone;
    }

    function setUsuramal($usuramal) {
        $this->usuramal = $usuramal;
    }

}
