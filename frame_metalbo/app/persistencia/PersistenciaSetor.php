<?php

class PersistenciaSetor extends Persistencia{
    
   public function __construct() {
       parent::__construct();
       
       $this->setTabela('MetCad_Setores');
       
       
       $this->adicionaRelacionamento('codsetor', 'codsetor', true, true, true);
       $this->adicionaRelacionamento('descsetor', 'descsetor');
   }
}