<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class PersistenciaMET_MP_CadastroMaquinas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbtipmaq');
        
        $this->adicionaRelacionamento('tipcod','tipcod',true,true, true);
        $this->adicionaRelacionamento('tipdes', 'tipdes');
        
        $this->adicionaOrderBy('tipcod',0);
        
    }
    
    public function buscaDadosTipMaq(){
        $sSql = "select tipdes from tbtipmaq";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
}
