<?php

/* 
 * Classe que implementa a persistencia de subfamilia
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class PersistenciaDELX_PRO_Subfamilia extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_GRUPOSUBGRUPOFAMILIASUBFAM');
        
        $this->adicionaRelacionamento('pro_grupocodigo', 'pro_grupocodigo',true,true);
        $this->adicionaRelacionamento('pro_subgrupocodigo','pro_subgrupocodigo', true, true);
        $this->adicionaRelacionamento('pro_familiacodigo', 'pro_familiacodigo',true,true);
        $this->adicionaRelacionamento('pro_subfamiliacodigo', 'pro_subfamiliacodigo', true,true);
        $this->adicionaRelacionamento('pro_subfamiliadescricao','pro_subfamiliadescricao');
        
        $this->setSTop('1000');                      
        $this->adicionaOrderBy('pro_grupocodigo', 0);
        
    }
}