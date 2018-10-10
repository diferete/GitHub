<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Emplogo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_emplogo');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('fillogo','fillogo');
        
        //$this->adicionaJoin('EmpRex');
        
    }
    
    public function retornaLogo($sCodUser){
        $sSql = "select fillogo from MET_TEC_usuario left outer join MET_TEC_emplogo
                on MET_TEC_usuario.filcgc = MET_TEC_emplogo.filcgc 
                where usucodigo =".$sCodUser;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sLogo = $row->fillogo;
        
        return $sLogo;
        
    }
}