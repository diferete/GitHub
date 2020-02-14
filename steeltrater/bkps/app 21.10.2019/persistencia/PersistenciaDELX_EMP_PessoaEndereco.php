<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class PersistenciaDELX_EMP_PessoaEndereco extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('EMP_PESSOAENDERECO');

        $this->adicionaRelacionamento('emp_Codigo', 'emp_Codigo', true, true);
        $this->adicionaRelacionamento('emp_enderecoseq', 'emp_enderecoseq', true, true);
        $this->adicionaRelacionamento('cid_paiscodigo', 'cid_paiscodigo');
        $this->adicionaRelacionamento('emp_enderecotipo', 'emp_enderecotipo');
        $this->adicionaRelacionamento('emp_enderecologradouro', 'emp_enderecologradouro');
        $this->adicionaRelacionamento('emp_endereconumero', 'emp_endereconumero');
        $this->adicionaRelacionamento('emp_enderecocomplemento', 'emp_enderecocomplemento');
        $this->adicionaRelacionamento('emp_enderecobairro', 'emp_enderecobairro');
        $this->adicionaRelacionamento('emp_enderecoobs', 'emp_enderecoobs');
        $this->adicionaRelacionamento('emp_enderecoemail', 'emp_enderecoemail');
        $this->adicionaRelacionamento('emp_enderecotelefone', 'emp_enderecotelefone');
        $this->adicionaRelacionamento('emp_enderecoinscrural', 'emp_enderecoinscrural');
        $this->adicionaRelacionamento('emp_enderecoinscestadual', 'emp_enderecoinscestadual');
        $this->adicionaRelacionamento('emp_enderecocnpj', 'emp_enderecocnpj');
        $this->adicionaRelacionamento('cid_logradourocep', 'cid_logradourocep');
        $this->adicionaRelacionamento('emp_enderecofax', 'emp_enderecofax');
        $this->adicionaRelacionamento('cid_codigo', 'cid_codigo');
        $this->adicionaRelacionamento('emp_enderecorgdataemissao', 'emp_enderecorgdataemissao');
        $this->adicionaRelacionamento('emp_enderecoresidedata', 'emp_enderecoresidedata');

        $this->setSTop('1000');
        $this->adicionaOrderBy('emp_codigo', 0);
    }

}
