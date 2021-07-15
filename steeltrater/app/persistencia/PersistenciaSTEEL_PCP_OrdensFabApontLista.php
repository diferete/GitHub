<?php

/* 
 * Implementa producao steel
 * 
 * @author Cleverton Hoffmann
 * @since 31/07/2018
 */

class PersistenciaSTEEL_PCP_OrdensFabApontLista extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFab');
      
        $this->adicionaRelacionamento('op','op',true);
        $this->adicionaRelacionamento('op','STEEL_PCP_ordensFabLista.op');
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('emp_razaosocial', 'emp_razaosocial');
        $this->adicionaRelacionamento('origem','origem');
        $this->adicionaRelacionamento('documento','documento');
        $this->adicionaRelacionamento('prod','prod');
        $this->adicionaRelacionamento('prodes','prodes');
        $this->adicionaRelacionamento('receita','receita');
        $this->adicionaRelacionamento('receita_des','receita_des');
        $this->adicionaRelacionamento('quant','quant');
        $this->adicionaRelacionamento('peso','peso');
        $this->adicionaRelacionamento('opcliente','opcliente');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('usuario','usuario');
        $this->adicionaRelacionamento('seqprodnf','seqprodnf');
        $this->adicionaRelacionamento('dataprev','dataprev');
        
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('temprev', 'temprev');
        $this->adicionaRelacionamento('referencia','referencia');
        $this->adicionaRelacionamento('tratrevencomp','tratrevencomp');
        $this->adicionaRelacionamento('retrabalho','retrabalho');
       
        $this->adicionaOrderBy('temprev',1);
        $this->setSTop('300');
        
       
        
        $this->adicionaJoin('STEEL_PCP_ordensFabLista',null,1,'op','op');
        
        
    }
}