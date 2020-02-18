<?php

class PersistenciaMET_CAD_Setores extends Persistencia{
    
   public function __construct() {
       parent::__construct();
       
       $this->setTabela('MET_CAD_setores');
       
       
       $this->adicionaRelacionamento('codsetor', 'codsetor', true, true, true);
       $this->adicionaRelacionamento('descsetor', 'descsetor');
   }
}