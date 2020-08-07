<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaNfItenPed extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.nfc003');
        
        $this->adicionaRelacionamento('nfsfilcgc','nfsfilcgc');
        $this->adicionaRelacionamento('nfsnfser','nfsnfser');
        $this->adicionaRelacionamento('nfsnfnro','nfsnfnro');
        $this->adicionaRelacionamento('nfsitcod','nfsitcod');
        $this->adicionaRelacionamento('nfsitdes','nfsitdes');
        $this->adicionaRelacionamento('nfsitqtd','nfsitqtd');
        $this->adicionaRelacionamento('nfsitdtemi','nfsitdtemi');
        $this->adicionaRelacionamento('nfsitpdvnr','nfsitpdvnr');
        $this->adicionaRelacionamento('nfsitseq','nfsitseq');
        
        $this->adicionaFiltro('nfsfilcgc','75483040000211');
        $this->adicionaFiltro('nfsnfser','2');
        $this->adicionaFiltro('nfsitpdvnr','9999999'); 
        $this->setSTop(1000);
        $this->adicionaOrderBy('nfsitseq');
    }
}


/**
 * select *,nfsnfnro,nfsitcod,nfsitdes,nfsitqtd, 
                    convert (varchar,nfsitdtemi,103)as nfsitdtemi 
                    from widl.NFC003(nolock) 
                    where nfsitpdvnr =333583 
                    and nfsnfser = 2
                    and nfsfilcgc = 75483040000211 
                    
 */