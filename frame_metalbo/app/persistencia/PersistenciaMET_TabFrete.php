<?php

/*
 * Classe que gerencia a Persistência da MET_TabFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class PersistenciaMET_TabFrete extends Persistencia{
   public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbfrete');
        
        $this->adicionaRelacionamento('seq','seq',true,true,true);
        $this->adicionaRelacionamento('cnpj','cnpj',true,true);
        $this->adicionaRelacionamento('cnpj','Pessoa.empcod',false,false);
        $this->adicionaRelacionamento('empdes','empdes',false,false);
        $this->adicionaRelacionamento('codtipo','codtipo');
        $this->adicionaRelacionamento('ref','ref');
        $this->adicionaRelacionamento('taxamin','taxamin');
        $this->adicionaRelacionamento('fretevalor','fretevalor');
        $this->adicionaRelacionamento('fretepeso','fretepeso');
        $this->adicionaRelacionamento('pedagio','pedagio');
        $this->adicionaRelacionamento('taxa2','taxa2');
        $this->adicionaRelacionamento('tas','tas');
        $this->adicionaRelacionamento('gris','gris');
        $this->adicionaRelacionamento('taxa','taxa');
        $this->adicionaRelacionamento('imposto','imposto');
        $this->adicionaRelacionamento('formula1','formula1');
        $this->adicionaRelacionamento('formula2','formula2');
        $this->adicionaRelacionamento('formula3','formula3');
        $this->adicionaRelacionamento('formula4','formula4');
        
        $this->adicionaOrderBy('seq',1);
        $this->adicionaJoin('Pessoa', null,1, 'cnpj','empcod');
        
   }
}