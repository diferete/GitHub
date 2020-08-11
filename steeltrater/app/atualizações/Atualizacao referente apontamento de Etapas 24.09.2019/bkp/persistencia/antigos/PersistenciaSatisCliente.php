<?php

/* 
 * Persistencia da classe satisfação de cliente
 * 
 * @author Avanei Martendal
 * @since 10/01/2018
 */


class PersistenciaSatisCliente extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbsatiscliente');
        
        $this->adicionaRelacionamento('filcgc','filcgc',TRUE,TRUE);
        $this->adicionaRelacionamento('nr','nr',TRUE,TRUE,TRUE);
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('titulo', 'titulo');
        $this->adicionaRelacionamento('periodo', 'periodo');
        $this->adicionaRelacionamento('obs', 'obs');
        
        $this->adicionaOrderBy('nr',1);
    }
}
