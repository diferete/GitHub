<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaContPagItem extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontpagar_item');
        
        $this->adicionaRelacionamento('empcnpj', 'empcnpj', true, true);//nfdoc
        $this->adicionaRelacionamento('nfdoc', 'nfdoc', true, true);//nfserie
        $this->adicionaRelacionamento('nfserie', 'nfserie', true, true);
        $this->adicionaRelacionamento('pescnpj', 'pescnpj', true, true);
        $this->adicionaRelacionamento('contseq', 'contseq', true, true,true);
        $this->adicionaRelacionamento('contvlr', 'contvlr');
        $this->adicionaRelacionamento('contvenc', 'contvenc');
        $this->adicionaRelacionamento('contsit', 'contsit');
    }
    
    public function insSitFinan($sChave){
         $aDados = explode(',', $sChave);
        
       $sSql = "update tbcontpagar_item set contsit = 'Sem pagamento' where empcnpj = '".$aDados[0]."' and nfdoc = '".$aDados[1]."' and nfserie='".$aDados[2]."' and pescnpj ='".$aDados[3]."'";
       $aRetorno = $this->executaSql($sSql);
       return $aRetorno;
        
    }
}