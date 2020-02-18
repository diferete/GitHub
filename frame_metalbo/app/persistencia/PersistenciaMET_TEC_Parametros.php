<?php

/* 
 * Classe que controla parametros do sistema
 * 
 * @date 25/08/2017
 * @author 25/08/2017
 */

class PersistenciaMET_TEC_Parametros extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_parametros');
        
        $this->adicionaRelacionamento('codigo','codigo',true,true,true);
        $this->adicionaRelacionamento('parametro', 'parametro');
        $this->adicionaRelacionamento('valor','valor');
        $this->adicionaRelacionamento('aplicacao', 'aplicacao');
        $this->adicionaRelacionamento('filcgc','filcgc');
        $this->adicionaRelacionamento('officecod','officecod');
        
        $this->adicionaOrderBy('codigo', 1 );
    }
    
    /**
     * verifica parametro para liberar empenho
     */
    public function liberaEmpenho(){
       $sSql = 'select count(*)as total from MET_TEC_parametros where codigo = 1 and officecod ='.$_SESSION['repoffice'];
       $result = $this->getObjetoSql($sSql);
       $oRow = $result->fetch(PDO::FETCH_OBJ);
       $itot = $oRow->total;
       if($itot>0){
           return true;
       }else{
           return FALSE;
       }
    }
        
}

