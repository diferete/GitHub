<?php

/*
 * Classe que implementa os models da DELX_EMP_PessoaEndereco
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ModelDELX_EMP_PessoaEndereco {

    private $emp_Codigo;
    private $emp_enderecoseq;
    private $cid_paiscodigo;
    private $emp_enderecotipo;
    private $emp_enderecologradouro;
    private $emp_endereconumero;
    private $emp_enderecocomplemento;
    private $emp_enderecobairro;
    private $emp_enderecoobs;
    private $emp_enderecoemail;
    private $emp_enderecotelefone;
    private $emp_enderecoinscrural;
    private $emp_enderecoinscestadual;
    private $emp_enderecocnpj;
    private $cid_logradourocep;
    private $emp_enderecofax;
    private $cid_codigo;
    private $emp_enderecorgdataemissao;
    private $emp_enderecoresidedata;

    function getEmp_enderecoseq() {
        return $this->emp_enderecoseq;
    }

    function getCid_paiscodigo() {
        return $this->cid_paiscodigo;
    }

    function getEmp_enderecotipo() {
        return $this->emp_enderecotipo;
    }

    function getEmp_enderecologradouro() {
        return $this->emp_enderecologradouro;
    }

    function getEmp_endereconumero() {
        return $this->emp_endereconumero;
    }

    function getEmp_enderecocomplemento() {
        return $this->emp_enderecocomplemento;
    }

    function getEmp_enderecobairro() {
        return $this->emp_enderecobairro;
    }

    function getEmp_enderecoobs() {
        return $this->emp_enderecoobs;
    }

    function getEmp_enderecoemail() {
        return $this->emp_enderecoemail;
    }

    function getEmp_enderecotelefone() {
        return $this->emp_enderecotelefone;
    }

    function getEmp_enderecoinscrural() {
        return $this->emp_enderecoinscrural;
    }

    function getEmp_enderecoinscestadual() {
        return $this->emp_enderecoinscestadual;
    }

    function getEmp_enderecocnpj() {
        return $this->emp_enderecocnpj;
    }

    function getCid_logradourocep() {
        return $this->cid_logradourocep;
    }

    function getEmp_enderecofax() {
        return $this->emp_enderecofax;
    }

    function getCid_codigo() {
        return $this->cid_codigo;
    }

    function getEmp_enderecorgdataemissao() {
        return $this->emp_enderecorgdataemissao;
    }

    function getEmp_enderecoresidedata() {
        return $this->emp_enderecoresidedata;
    }

    function getemp_Codigo() {
        return $this->emp_Codigo;
    }

    function setemp_Codigo($EMP_Codigo) {
        $this->emp_Codigo = $EMP_Codigo;
    }

    function setEmp_enderecoseq($emp_enderecoseq) {
        $this->emp_enderecoseq = $emp_enderecoseq;
    }

    function setCid_paiscodigo($cid_paiscodigo) {
        $this->cid_paiscodigo = $cid_paiscodigo;
    }

    function setEmp_enderecotipo($emp_enderecotipo) {
        $this->emp_enderecotipo = $emp_enderecotipo;
    }

    function setEmp_enderecologradouro($emp_enderecologradouro) {
        $this->emp_enderecologradouro = $emp_enderecologradouro;
    }

    function setEmp_endereconumero($emp_endereconumero) {
        $this->emp_endereconumero = $emp_endereconumero;
    }

    function setEmp_enderecocomplemento($emp_enderecocomplemento) {
        $this->emp_enderecocomplemento = $emp_enderecocomplemento;
    }

    function setEmp_enderecobairro($emp_enderecobairro) {
        $this->emp_enderecobairro = $emp_enderecobairro;
    }

    function setEmp_enderecoobs($emp_enderecoobs) {
        $this->emp_enderecoobs = $emp_enderecoobs;
    }

    function setEmp_enderecoemail($emp_enderecoemail) {
        $this->emp_enderecoemail = $emp_enderecoemail;
    }

    function setEmp_enderecotelefone($emp_enderecotelefone) {
        $this->emp_enderecotelefone = $emp_enderecotelefone;
    }

    function setEmp_enderecoinscrural($emp_enderecoinscrural) {
        $this->emp_enderecoinscrural = $emp_enderecoinscrural;
    }

    function setEmp_enderecoinscestadual($emp_enderecoinscestadual) {
        $this->emp_enderecoinscestadual = $emp_enderecoinscestadual;
    }

    function setEmp_enderecocnpj($emp_enderecocnpj) {
        $this->emp_enderecocnpj = $emp_enderecocnpj;
    }

    function setCid_logradourocep($cid_logradourocep) {
        $this->cid_logradourocep = $cid_logradourocep;
    }

    function setEmp_enderecofax($emp_enderecofax) {
        $this->emp_enderecofax = $emp_enderecofax;
    }

    function setCid_codigo($cid_codigo) {
        $this->cid_codigo = $cid_codigo;
    }

    function setEmp_enderecorgdataemissao($emp_enderecorgdataemissao) {
        $this->emp_enderecorgdataemissao = $emp_enderecorgdataemissao;
    }

    function setEmp_enderecoresidedata($emp_enderecoresidedata) {
        $this->emp_enderecoresidedata = $emp_enderecoresidedata;
    }

}
