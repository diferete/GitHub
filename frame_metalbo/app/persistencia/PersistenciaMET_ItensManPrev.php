<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class PersistenciaMET_ItensManPrev extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbitensmp');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true);
        $this->adicionaRelacionamento('nr','nr', true);
        $this->adicionaRelacionamento('seq','seq', true, true, true);
        $this->adicionaRelacionamento('codmaq','codmaq');
        $this->adicionaRelacionamento('maquina','maquina', false, false, false);
        $this->adicionaRelacionamento('codsit','MET_ServicoMaquina.codsit',false, false, false);
        $this->adicionaRelacionamento('codsit','codsit');
        $this->adicionaRelacionamento('sitmp','sitmp');
        $this->adicionaRelacionamento('dias','dias');
        $this->adicionaRelacionamento('databert','databert');
        $this->adicionaRelacionamento('userinicial','userinicial');
        $this->adicionaRelacionamento('datafech','datafech');
        $this->adicionaRelacionamento('userfinal','userfinal');
        $this->adicionaRelacionamento('obs','obs');
        
        $this->setSTop('500');
        $this->adicionaOrderBy('seq',1);
    
        $this->adicionaJoin('MET_ServicoMaquina');
        
    }   
    
    public function consultaMaqDes($oCodMaq){
        
        $sSql="select maquina"
                . " from metmaq"
                . " where cod = '".$oCodMaq."'";
        $result = $this->getObjetoSql($sSql);
        $oMatDes = $result->fetch(PDO::FETCH_OBJ);

        return $oMatDes;
    }
    
        
}
