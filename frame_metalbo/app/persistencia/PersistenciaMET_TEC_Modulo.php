<?php
class PersistenciaMET_TEC_Modulo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_modulo');
        
        $this->adicionaRelacionamento('modcod','modcod',true,true,true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');
        
        $this->adicionaOrderBy('modcod',1);

    }
    
}

