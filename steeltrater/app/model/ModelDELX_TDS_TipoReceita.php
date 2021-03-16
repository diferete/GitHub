<?php

/*
 * Classe que implementa os models da DELX_TDS_TipoReceita
 * 
 * @author Cleverton Hoffmann
 * @since 22/09/2020
 */

class ModelDELX_TDS_TipoReceita {

    private $tds_codigo;
    private $tds_descricao;
    private $tds_inativa;
    private $tds_contatitulo;
    private $tds_tipo;
    private $tds_grupo;
    private $tds_desconsiderafluxo;
    private $tds_despesaoperacional;
    private $tds_classificacao;
    private $tds_controleviagem;
    private $tds_grupodescricao;
    private $tds_tipodespesavaldocsup;

    function getTds_codigo() {
        return $this->tds_codigo;
    }

    function getTds_descricao() {
        return $this->tds_descricao;
    }

    function getTds_inativa() {
        return $this->tds_inativa;
    }

    function getTds_contatitulo() {
        return $this->tds_contatitulo;
    }

    function getTds_tipo() {
        return $this->tds_tipo;
    }

    function getTds_grupo() {
        return $this->tds_grupo;
    }

    function getTds_desconsiderafluxo() {
        return $this->tds_desconsiderafluxo;
    }

    function getTds_despesaoperacional() {
        return $this->tds_despesaoperacional;
    }

    function getTds_classificacao() {
        return $this->tds_classificacao;
    }

    function getTds_controleviagem() {
        return $this->tds_controleviagem;
    }

    function getTds_grupodescricao() {
        return $this->tds_grupodescricao;
    }

    function getTds_tipodespesavaldocsup() {
        return $this->tds_tipodespesavaldocsup;
    }

    function setTds_codigo($tds_codigo) {
        $this->tds_codigo = $tds_codigo;
    }

    function setTds_descricao($tds_descricao) {
        $this->tds_descricao = $tds_descricao;
    }

    function setTds_inativa($tds_inativa) {
        $this->tds_inativa = $tds_inativa;
    }

    function setTds_contatitulo($tds_contatitulo) {
        $this->tds_contatitulo = $tds_contatitulo;
    }

    function setTds_tipo($tds_tipo) {
        $this->tds_tipo = $tds_tipo;
    }

    function setTds_grupo($tds_grupo) {
        $this->tds_grupo = $tds_grupo;
    }

    function setTds_desconsiderafluxo($tds_desconsiderafluxo) {
        $this->tds_desconsiderafluxo = $tds_desconsiderafluxo;
    }

    function setTds_despesaoperacional($tds_despesaoperacional) {
        $this->tds_despesaoperacional = $tds_despesaoperacional;
    }

    function setTds_classificacao($tds_classificacao) {
        $this->tds_classificacao = $tds_classificacao;
    }

    function setTds_controleviagem($tds_controleviagem) {
        $this->tds_controleviagem = $tds_controleviagem;
    }

    function setTds_grupodescricao($tds_grupodescricao) {
        $this->tds_grupodescricao = $tds_grupodescricao;
    }

    function setTds_tipodespesavaldocsup($tds_tipodespesavaldocsup) {
        $this->tds_tipodespesavaldocsup = $tds_tipodespesavaldocsup;
    }

}
