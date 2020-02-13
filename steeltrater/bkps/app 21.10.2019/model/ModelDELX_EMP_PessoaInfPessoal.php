<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ModelDELX_EMP_PessoaInfPessoal {

    private $emp_codigo;
    private $emp_infpessoalseq;
    private $emp_infpessoalnomepai;
    private $emp_infpessoalnomemae;
    private $emp_infpessoallocalnasc;
    private $emp_infpessoalescolaridade;
    private $emp_infpessoalestadocivil;
    private $emp_infpessoalempresatrabalha;
    private $emp_infpessoadatanascimento;

    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getEmp_infpessoalseq() {
        return $this->emp_infpessoalseq;
    }

    function getEmp_infpessoalnomepai() {
        return $this->emp_infpessoalnomepai;
    }

    function getEmp_infpessoalnomemae() {
        return $this->emp_infpessoalnomemae;
    }

    function getEmp_infpessoallocalnasc() {
        return $this->emp_infpessoallocalnasc;
    }

    function getEmp_infpessoalescolaridade() {
        return $this->emp_infpessoalescolaridade;
    }

    function getEmp_infpessoalestadocivil() {
        return $this->emp_infpessoalestadocivil;
    }

    function getEmp_infpessoalempresatrabalha() {
        return $this->emp_infpessoalempresatrabalha;
    }

    function getEmp_infpessoadatanascimento() {
        return $this->emp_infpessoadatanascimento;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setEmp_infpessoalseq($emp_infpessoalseq) {
        $this->emp_infpessoalseq = $emp_infpessoalseq;
    }

    function setEmp_infpessoalnomepai($emp_infpessoalnomepai) {
        $this->emp_infpessoalnomepai = $emp_infpessoalnomepai;
    }

    function setEmp_infpessoalnomemae($emp_infpessoalnomemae) {
        $this->emp_infpessoalnomemae = $emp_infpessoalnomemae;
    }

    function setEmp_infpessoallocalnasc($emp_infpessoallocalnasc) {
        $this->emp_infpessoallocalnasc = $emp_infpessoallocalnasc;
    }

    function setEmp_infpessoalescolaridade($emp_infpessoalescolaridade) {
        $this->emp_infpessoalescolaridade = $emp_infpessoalescolaridade;
    }

    function setEmp_infpessoalestadocivil($emp_infpessoalestadocivil) {
        $this->emp_infpessoalestadocivil = $emp_infpessoalestadocivil;
    }

    function setEmp_infpessoalempresatrabalha($emp_infpessoalempresatrabalha) {
        $this->emp_infpessoalempresatrabalha = $emp_infpessoalempresatrabalha;
    }

    function setEmp_infpessoadatanascimento($emp_infpessoadatanascimento) {
        $this->emp_infpessoadatanascimento = $emp_infpessoadatanascimento;
    }

}
