<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaFamProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.PROD04A');
        
        $this->adicionaRelacionamento('grucod','grucod',true);
        $this->adicionaRelacionamento('subcod', 'subcod',true);
        $this->adicionaRelacionamento('famcod', 'famcod',true);
        $this->adicionaRelacionamento('famdes', 'famdes');
        
       // $this->adicionaJoin('GrupoProd',null, self::LEFT_JOIN,null,null,'');
        
       // $this->adicionaJoin('SubGrupoProd',null, self::LEFT_JOIN,NULL,NULL,' and widl.PROD04A.subcod = "SubGrupoProd".subcod');
    }
}