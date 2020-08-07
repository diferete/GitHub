<?php

/* 
 * Implementa a classe persistência MET_ItensManPrevConsulta
 * 
 * @author Cleverton Hoffmann
 * @since 18/02/2019
 */

class PersistenciaMET_ItensManPrevConsulta extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbitensmp');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true);
        $this->adicionaRelacionamento('nr','nr', true);
        $this->adicionaRelacionamento('seq','seq', true, true, true);
        $this->adicionaRelacionamento('codmaq','codmaq');
        $this->adicionaRelacionamento('codmaq','MET_Maquinas.cod',false,false,false);
        $this->adicionaRelacionamento('maquina','MET_Maquinas.maquina',false,false,false);
        $this->adicionaRelacionamento('codsit','MET_ServicoMaquina.codsit',false, false, false);
        $this->adicionaRelacionamento('codsit','codsit');
        $this->adicionaRelacionamento('servico','servico',false, false, false);
        $this->adicionaRelacionamento('sitmp','sitmp');
        $this->adicionaRelacionamento('dias','dias');
        $this->adicionaRelacionamento('databert','databert');
        $this->adicionaRelacionamento('userinicial','userinicial');
        $this->adicionaRelacionamento('datafech','datafech');
        $this->adicionaRelacionamento('userfinal','userfinal');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('oqfazer','oqfazer');
        
        $this->setSTop('100');
        $this->adicionaOrderBy('seq',1);
    
        $this->adicionaJoin('MET_ServicoMaquina');
        $this->adicionaJoin('MET_Maquinas', null,1, 'codmaq','cod');
        
    }   
    
}
