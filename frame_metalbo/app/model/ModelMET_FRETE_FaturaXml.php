<?php

//

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelMET_FRETE_FaturaXml
 *
 * @author Alexandre
 */
class ModelMET_FRETE_FaturaXml {

    private $Pessoa;
    private $filcgc;
    private $cnpj;
    private $fatura;
    private $dataEmit;
    private $dataVenc;
    private $usuario;
    private $dataUpload;
    private $horaUpload;
    private $arquivo;
    private $extraido;
    private $empdes;

    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

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

    function getCnpj() {
        return $this->cnpj;
    }

    function getFatura() {
        return $this->fatura;
    }

    function getDataEmit() {
        return $this->dataEmit;
    }

    function getDataVenc() {
        return $this->dataVenc;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getDataUpload() {
        return $this->dataUpload;
    }

    function getHoraUpload() {
        return $this->horaUpload;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function getExtraido() {
        return $this->extraido;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setFatura($fatura) {
        $this->fatura = $fatura;
    }

    function setDataEmit($dataEmit) {
        $this->dataEmit = $dataEmit;
    }

    function setDataVenc($dataVenc) {
        $this->dataVenc = $dataVenc;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setDataUpload($dataUpload) {
        $this->dataUpload = $dataUpload;
    }

    function setHoraUpload($horaUpload) {
        $this->horaUpload = $horaUpload;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    function setExtraido($extraido) {
        $this->extraido = $extraido;
    }

}
