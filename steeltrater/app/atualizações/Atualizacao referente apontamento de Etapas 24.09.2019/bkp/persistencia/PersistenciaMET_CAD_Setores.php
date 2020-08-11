<?php

class PersistenciaMET_CAD_Setores extends Persistencia{
    
   public function __construct() {
       parent::__construct();
       
       $this->setTabela('MET_CAD_setores');
       
       
       $this->adicionaRelacionamento('codsetor', 'codsetor', true, true, true);
       $this->adicionaRelacionamento('descsetor', 'descsetor');
       $this->adicionaRelacionamento('tipoconst', 'tipoconst');
       $this->adicionaRelacionamento('piso', 'piso');
       $this->adicionaRelacionamento('telhado', 'telhado');
       $this->adicionaRelacionamento('vent', 'vent');
       $this->adicionaRelacionamento('ilumin', 'ilumin');
       $this->adicionaRelacionamento('obsSetor', 'obsSetor');
       
       $this->setSTop('1000');
       $this->adicionaOrderBy('codsetor', 1);
       
   }
}