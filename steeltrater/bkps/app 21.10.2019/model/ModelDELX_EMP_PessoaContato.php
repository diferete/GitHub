<?php

/*
 * Classe que implementa os models da DELX_EMP_PessoaContato
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ModelDELX_EMP_PessoaContato {

    private $emp_codigo;
    private $emp_contatoseq;
    private $emp_contatotipo;
    private $emp_contatonome;
    private $emp_contatocargo;
    private $emp_contatotelefone;
    private $emp_contatofax;
    private $emp_contatocelular;
    private $emp_contatoemail;
    private $emp_contatodatanascimento;

    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getEmp_contatoseq() {
        return $this->emp_contatoseq;
    }

    function getEmp_contatotipo() {
        return $this->emp_contatotipo;
    }

    function getEmp_contatonome() {
        return $this->emp_contatonome;
    }

    function getEmp_contatocargo() {
        return $this->emp_contatocargo;
    }

    function getEmp_contatotelefone() {
        return $this->emp_contatotelefone;
    }

    function getEmp_contatofax() {
        return $this->emp_contatofax;
    }

    function getEmp_contatocelular() {
        return $this->emp_contatocelular;
    }

    function getEmp_contatoemail() {
        return $this->emp_contatoemail;
    }

    function getEmp_contatodatanascimento() {
        return $this->emp_contatodatanascimento;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setEmp_contatoseq($emp_contatoseq) {
        $this->emp_contatoseq = $emp_contatoseq;
    }

    function setEmp_contatotipo($emp_contatotipo) {
        $this->emp_contatotipo = $emp_contatotipo;
    }

    function setEmp_contatonome($emp_contatonome) {
        $this->emp_contatonome = $emp_contatonome;
    }

    function setEmp_contatocargo($emp_contatocargo) {
        $this->emp_contatocargo = $emp_contatocargo;
    }

    function setEmp_contatotelefone($emp_contatotelefone) {
        $this->emp_contatotelefone = $emp_contatotelefone;
    }

    function setEmp_contatofax($emp_contatofax) {
        $this->emp_contatofax = $emp_contatofax;
    }

    function setEmp_contatocelular($emp_contatocelular) {
        $this->emp_contatocelular = $emp_contatocelular;
    }

    function setEmp_contatoemail($emp_contatoemail) {
        $this->emp_contatoemail = $emp_contatoemail;
    }

    function setEmp_contatodatanascimento($emp_contatodatanascimento) {
        $this->emp_contatodatanascimento = $emp_contatodatanascimento;
    }

}
