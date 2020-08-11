<?php

/*
 * Classe que implementa a persistencia de PessoaContato
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class PersistenciaDELX_EMP_PessoaContato extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('EMP_PESSOACONTATO');

        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo', true, true);
        $this->adicionaRelacionamento('emp_contatoseq', 'emp_contatoseq', true, true);
        $this->adicionaRelacionamento('emp_contatotipo', 'emp_contatotipo');
        $this->adicionaRelacionamento('emp_contatonome', 'emp_contatonome');
        $this->adicionaRelacionamento('emp_contatocargo', 'emp_contatocargo');
        $this->adicionaRelacionamento('emp_contatotelefone', 'emp_contatotelefone');
        $this->adicionaRelacionamento('emp_contatofax', 'emp_contatofax');
        $this->adicionaRelacionamento('emp_contatocelular', 'emp_contatocelular');
        $this->adicionaRelacionamento('emp_contatoemail', 'emp_contatoemail');
        $this->adicionaRelacionamento('emp_contatodatanascimento', 'emp_contatodatanascimento');

        $this->setSTop('1000');
        $this->adicionaOrderBy('emp_codigo', 0);
    }

}
