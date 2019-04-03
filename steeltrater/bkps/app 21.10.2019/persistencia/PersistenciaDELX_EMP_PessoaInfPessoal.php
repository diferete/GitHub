<?php

/*
 * Classe que implementa a persistencia de Pessoa INF PESSOAL
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class PersistenciaDELX_EMP_PessoaInfPessoal extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('EMP_PESSOAINFPESSOAL');

        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo', true, true);
        $this->adicionaRelacionamento('emp_infpessoalseq', 'emp_infpessoalseq', true, true);
        $this->adicionaRelacionamento('emp_infpessoalnomepai', 'emp_infpessoalnomepai');
        $this->adicionaRelacionamento('emp_infpessoalnomemae', 'emp_infpessoalnomemae');
        $this->adicionaRelacionamento('emp_infpessoallocalnasc', 'emp_infpessoallocalnasc');
        $this->adicionaRelacionamento('emp_infpessoalescolaridade', 'emp_infpessoalescolaridade');
        $this->adicionaRelacionamento('emp_infpessoalestadocivil', 'emp_infpessoalestadocivil');
        $this->adicionaRelacionamento('emp_infpessoalempresatrabalha', 'emp_infpessoalempresatrabalha');
        $this->adicionaRelacionamento('emp_infpessoadatanascimento', 'emp_infpessoadatanascimento');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('emp_codigo', 0);
    }

}
