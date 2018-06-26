<?php

/*
 * Classe que implementa o modelo de dados dos usuários
 * @author Avanei Martendal
 * @since 25/12/2015
 */

class ModelUser {

    private $usucodigo;
    private $usunome;
    private $ususobrenome;
    private $usulogin;
    private $ususenha;
    private $usuimagem;
    private $usucracha;
    private $usufone;
    private $usuramal;
    private $usubloqueado;
    private $usuemail;
    private $filcgc;
    private $RepOffice;
    private $UsuTipo;
    private $Setor;
    private $ususalvasenha;
    private $ususit;
    private $senhaProvisoria;
    private $usunomeDelsoft;

    function getUsunomeDelsoft() {
        return $this->usunomeDelsoft;
    }

    function setUsunomeDelsoft($usunomeDelsoft) {
        $this->usunomeDelsoft = $usunomeDelsoft;
    }

    function getRepOffice() {
        if (!isset($this->RepOffice)) {
            $this->RepOffice = Fabrica::FabricarModel('RepOffice');
        }
        return $this->RepOffice;
    }

    function setRepOffice($RepOffice) {
        $this->RepOffice = $RepOffice;
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

    function getUsuTipo() {
        if (!isset($this->UsuTipo)) {
            $this->UsuTipo = Fabrica::FabricarModel('UsuTipo');
        }

        return $this->UsuTipo;
    }

    function setUsuTipo($UsuTipo) {
        $this->UsuTipo = $UsuTipo;
    }

    function getSetor() {
        if (!isset($this->Setor)) {
            $this->Setor = Fabrica::FabricarModel('Setor');
        }

        return $this->Setor;
    }

    function setSetor($Setor) {
        $this->Setor = $Setor;
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
