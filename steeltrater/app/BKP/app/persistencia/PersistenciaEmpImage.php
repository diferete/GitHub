<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaEmpImage extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbempimage');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('fillogo','fillogo');
        
        //$this->adicionaJoin('EmpRex');
        
    }
    
    public function retornaLogo($sCodUser){
        $sSql = "select fillogo from tbusuario left outer join tbempimage
                on tbusuario.filcgc = tbempimage.filcgc 
                where usucodigo =".$sCodUser;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sLogo = $row->fillogo;
        
        return $sLogo;
        
    }
}