<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaTabVenda extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('pdftabvendas');
        
        $this->adicionaRelacionamento('codigo','Produto.procod',true);
        $this->adicionaRelacionamento('preco', 'preco');
        $this->adicionaRelacionamento('revisao', 'revisao');
        $this->adicionaRelacionamento('lotemin', 'lotemin');
        
        $this->adicionaJoin('Produto',NULL,1,'codigo','procod');
        $this->setSTop('50');
        $this->adicionaOrderBy('codigo',1);
    }
    /**
     * Verifica se um item está na tabela ou não
     */
    public function getItemTab($sProcod){
         $sSql='select COUNT(*) as stab from pdftabvendas where codigo ='.$sProcod.' ';
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        if($row->stab > 0){
            $sTab = '';
           //não faz retorno
        }else
        {
            $sTab = 'SemTabela';
            return  $sTab;
        }
           
    }
}