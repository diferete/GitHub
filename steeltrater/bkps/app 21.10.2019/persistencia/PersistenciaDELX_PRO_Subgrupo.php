<?php

/* 
 * Classe que implementa a persistencia de sub grupos
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class PersistenciaDELX_PRO_Subgrupo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_GRUPOSUBGRUPO');
        
        $this->adicionaRelacionamento('pro_grupocodigo','pro_grupocodigo', true, true);
        $this->adicionaRelacionamento('pro_subgrupocodigo', 'pro_subgrupocodigo', true, true);
        $this->adicionaRelacionamento('pro_subgrupodescricao', 'pro_subgrupodescricao');
        
        $this->setSTop('1000');
        $this->adicionaOrderByConsulta('pro_grupocodigo',0);
       
}
}