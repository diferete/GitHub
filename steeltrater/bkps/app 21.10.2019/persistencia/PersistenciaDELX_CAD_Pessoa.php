<?php

/* 
 * Classe que implementa a persistencia de pessoas
 * 
 * @author Avanei Martendal
 * @since 11/06/2018
 */

class PersistenciaDELX_CAD_Pessoa extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('EMP_PESSOA');
        
        $this->adicionaRelacionamento('emp_codigo','emp_codigo',true,true);
        $this->adicionaRelacionamento('emp_razaosocial','emp_razaosocial');
        $this->adicionaRelacionamento('emp_fantasia', 'emp_fantasia');
        $this->adicionaRelacionamento('emp_cadastrodata', 'emp_cadastrodata');
        $this->adicionaRelacionamento('emp_cadastrousuario', 'emp_cadastrousuario');
        
        
        $this->setSTop('100');
        $this->adicionaOrderBy('emp_codigo', 1);
        
    }
}

