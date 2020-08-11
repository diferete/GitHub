<?php

/* 
classe Resposanvel pelas consultas de codinções de pagamento 
 * autor:Goga
 * data:01/06/2016
 */

class PersistenciaCondPag extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.vencpa');
        
        $this->adicionaRelacionamento('cpgcod', 'cpgcod',true);
        $this->adicionaRelacionamento('cpgdes', 'cpgdes');
        
        $this->setSTop('40');
        $this->adicionaOrderBy('cpgcod',1); 
    }
    
            
}
