<?php

/* 
 * Classe que implementa o controle de usuários que logam no sistema com erro de senha
 * @author Avanei Martendal
 * @date 25/08/2017
 */

class PersistenciaMET_TEC_ErroLogin  extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_erroLogin');
        
        $this->adicionaRelacionamento('codigo','codigo',true,true,true);
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('ip','ip');
        $this->adicionaRelacionamento('nome','nome');
        $this->adicionaRelacionamento('senha','senha');
        
        $this->adicionaOrderBy('codigo',1);
    }
}

