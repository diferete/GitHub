<?php

/* 
 * Classe que implementa a persistencia de pais
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class PersistenciaDELX_CID_Pais extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('CID_PAIS');
       
        $this->adicionaRelacionamento('cid_paiscodigo', 'cid_paiscodigo',true,true);
        $this->adicionaRelacionamento('cid_paisdescricao','cid_paisdescricao');
        $this->adicionaRelacionamento('cid_paisusacep', 'cid_paisusacep');
        $this->adicionaRelacionamento('cid_paisibge','cid_paisibge');
        
        $this->setSTop('1000');                      
        $this->adicionaOrderBy('cid_paiscodigo', 0);
        
    }
}