<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_ServicoEquip extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ServicoEquip');
        
        $this->adicionaRelacionamento('tratcod','tratcod',true,true);
        $this->adicionaRelacionamento('tratcod', 'STEEL_PCP_Tratamentos.tratcod', false,false);
        $this->adicionaRelacionamento('fornocod','fornocod',true,true);
        $this->adicionaRelacionamento('fornocod','STEEL_PCP_Forno.fornocod',false,false);
        
        $this->adicionaJoin('STEEL_PCP_Tratamentos');
        $this->adicionaJoin('STEEL_PCP_Forno');
        
        $this->adicionaOrderBy('fornocod');
        
    }
    
    public function retornaFornos($sTratCod){
        $sSql ="select STEEL_PCP_ServicoEquip.fornocod,fornodes 
                from STEEL_PCP_ServicoEquip left outer join steel_pcp_forno
                on STEEL_PCP_ServicoEquip.fornocod = steel_pcp_forno.fornocod
                where STEEL_PCP_ServicoEquip.tratcod = 20";
        
    }
}