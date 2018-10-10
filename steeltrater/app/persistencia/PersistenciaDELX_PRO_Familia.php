<?php

/* 
 * Classe que implementa a persistencia de familia
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class PersistenciaDELX_PRO_Familia extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_GRUPOSUBGRUPOFAMILIA');
        
        $this->adicionaRelacionamento('pro_grupocodigo', 'pro_grupocodigo',true,true);
        $this->adicionaRelacionamento('pro_subgrupocodigo','pro_subgrupocodigo', true, true);
        $this->adicionaRelacionamento('pro_familiacodigo', 'pro_familiacodigo',true,true);
        $this->adicionaRelacionamento('pro_familiadescricao','pro_familiadescricao');
        
        $this->setSTop('50');                      
        $this->adicionaOrderBy('pro_grupocodigo', 0);
        
    }
}