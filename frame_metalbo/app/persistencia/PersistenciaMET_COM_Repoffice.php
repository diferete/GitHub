<?php

/* 
 * Gerencia os escritórios dos representantes
 */
class PersistenciaMET_COM_Repoffice extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_COM_repoffice');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('officecod','officecod',true,true,true);
        $this->adicionaRelacionamento('officedes', 'officedes');
        $this->adicionaRelacionamento('officedir','officedir');
        $this->adicionaRelacionamento('officecabsol', 'officecabsol');
        $this->adicionaRelacionamento('officecabsoliten', 'officecabsoliten');
        $this->adicionaRelacionamento('officecabcot', 'officecabcot');
        $this->adicionaRelacionamento('officecabcotiten','officecabcotiten');
        $this->adicionaRelacionamento('officeimgrel', 'officeimgrel');
        $this->adicionaRelacionamento('officesolrel', 'officesolrel');
        $this->adicionaRelacionamento('officecotrel','officecotrel');
        $this->adicionaRelacionamento('officealm', 'officealm');
        $this->adicionaRelacionamento('officeResp','officeResp');
        
        
    }
    
    //retorna a img principal de relatórios
    public function imgRel($codOffice){
        $sSql = 'select officeimgrel from MET_COM_repoffice where officecod ='.$_SESSION['repoffice'];
        
        $result = $this->getObjetoSql($sSql);
        
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $sImg = $row->officeimgrel;
        
        return $sImg;
    }
    
    
    
    
    
}
