<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaContpagar extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontpagar');
        
        $this->adicionaRelacionamento('empcnpj','empcnpj',true,true);
        $this->adicionaRelacionamento('nfdoc','nfdoc',true,true);
        $this->adicionaRelacionamento('nfserie','nfserie',true,true);
        $this->adicionaRelacionamento('pescnpj','pescnpj',true,true);
        $this->adicionaRelacionamento('contdataemi','contdataemi');
        $this->adicionaRelacionamento('contuseremi','contuseremi');
        $this->adicionaRelacionamento('contdatahora','contdatahora');
    }
    
    /**
     * 
     */
    public function verificaFinan($aChave){
         //valida se há alguma empresa na cotação
            $sSql = "select count(*) as contador from tbcontpagar "
                   ." where empcnpj='".$aChave['empcnpj']."' "
                    ."and nfdoc ='".$aChave['nfdoc']."' "
                    ."and nfserie = '".$aChave['nfserie']."' "
                    ."and pescnpj ='".$aChave['pescnpj']."' ";
            $result = $this->getObjetoSql($sSql);
            $row = $result->fetch(PDO::FETCH_OBJ);
            $count = $row->contador;
            return $count;
    }
    
    
}
