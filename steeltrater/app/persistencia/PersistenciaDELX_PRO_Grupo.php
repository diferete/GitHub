<?php

/* 
 * Classe que implementa a persistencia de grupos
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class PersistenciaDELX_PRO_Grupo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_GRUPO');
        
        $this->adicionaRelacionamento('pro_grupocodigo', 'pro_grupocodigo',true,true);
        $this->adicionaRelacionamento('pro_grupodescricao','pro_grupodescricao');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('pro_grupocodigo', 1);
        
    }
}