<?php

class PersistenciaMET_CAD_Setores extends Persistencia{
    
   public function __construct() {
       parent::__construct();
       
       $this->setTabela('MetCad_Setores');
       
       
       $this->adicionaRelacionamento('codsetor', 'codsetor', true, true, true);
       $this->adicionaRelacionamento('descsetor', 'descsetor');
       
       $this->adicionaOrderBy('codsetor',0);
   }
}