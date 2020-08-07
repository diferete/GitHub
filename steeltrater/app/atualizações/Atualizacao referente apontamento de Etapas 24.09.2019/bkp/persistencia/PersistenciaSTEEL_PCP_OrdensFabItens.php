<?php

/* 
 * Classe que implementa a emissão de ordens da steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 * 
 */

class PersistenciaSTEEL_PCP_OrdensFabItens extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFabItens');
        
        $this->adicionaRelacionamento('op', 'op',true,true);
        $this->adicionaRelacionamento('opseq', 'opseq',true,true,true);
        $this->adicionaRelacionamento('receita', 'receita');
        $this->adicionaRelacionamento('receita_seq','receita_seq');
        $this->adicionaRelacionamento('tratamento', 'STEEL_PCP_Tratamentos.tratcod',false,false);
        $this->adicionaRelacionamento('tratamento', 'tratamento');
        $this->adicionaRelacionamento('camada_min', 'camada_min');
        $this->adicionaRelacionamento('camada_max', 'camada_max');
        $this->adicionaRelacionamento('temperatura', 'temperatura');
        $this->adicionaRelacionamento('tempo', 'tempo');
        $this->adicionaRelacionamento('resfriamento', 'resfriamento');
        
        $this->adicionaJoin('STEEL_PCP_tratamentos', null,1, 'tratamento','tratcod');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('500');
    }
}