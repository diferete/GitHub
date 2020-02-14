<?php

class PersistenciaMobModulos extends Persistencia{
    
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbmobmodulos');
        
        $this->adicionaRelacionamento('mobmodcod', 'mobmodcod',true,true,true);
        $this->adicionaRelacionamento('mobmoddesc', 'mobmoddesc');
        $this->adicionaRelacionamento('mobmodicon', 'mobmodicon');
        $this->adicionaRelacionamento('mobmodrota', 'mobmodrota');
    }
}