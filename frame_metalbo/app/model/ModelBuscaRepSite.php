<?php

/*
 * Classe que gerencia a busca de representantes por estado
 * @author: Alexandre
 * @since: 19/01/2018
 * 
 */

class ModelBuscaRepSite {

    private $filcgc;
    private $estado;
    private $pais;
    private $ufrep;
    private $codigo;
    private $logo;
    private $nome;
    private $endereco;
    private $bairro;
    private $cidade;
    private $cep;
    private $fone1;
    private $fone2;
    private $email1;
    private $email2;
    private $website;

    function getUfrep() {
        return $this->ufrep;
    }

    function setUfrep($ufrep) {
        $this->ufrep = $ufrep;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getEstado() {
        return $this->estado;
    }

    function getLogo() {
        return $this->logo;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getCep() {
        return $this->cep;
    }

    function getFone1() {
        return $this->fone1;
    }

    function getFone2() {
        return $this->fone2;
    }

    function getEmail1() {
        return $this->email1;
    }

    function getEmail2() {
        return $this->email2;
    }

    function getWebsite() {
        return $this->website;
    }

    function getPais() {
        return $this->pais;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setFone1($fone1) {
        $this->fone1 = $fone1;
    }

    function setFone2($fone2) {
        $this->fone2 = $fone2;
    }

    function setEmail1($email1) {
        $this->email1 = $email1;
    }

    function setEmail2($email2) {
        $this->email2 = $email2;
    }

    function setWebsite($website) {
        $this->website = $website;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

}
