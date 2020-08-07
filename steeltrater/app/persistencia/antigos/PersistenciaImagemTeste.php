<?php
class PersistenciaImagemTeste extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbtesteimagem');
        
        $this->adicionaRelacionamento('id', 'id', true,true,true);
        $this->adicionaRelacionamento('caminho', 'caminho');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        
    }
    
}
