<?php

/* 
 *classe responsáveis somente por consultas das empresas que compoem o grupo
 */

class PersistenciaEmpRex extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.emp03');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',TRUE);
        $this->adicionaRelacionamento('fildes', 'fildes');
        
        
    }
}