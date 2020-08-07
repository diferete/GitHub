<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualAqEficazApont extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbacaoeficaz');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nr', 'nr',true,true);
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        $this->adicionaRelacionamento('acao', 'acao');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('datareal','datareal');
        $this->adicionaRelacionamento('eficaz','eficaz');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('sit', 'sit');
        $this->adicionaRelacionamento('usucodigo','usucodigo');
        $this->adicionaRelacionamento('usunome','usunome');
        
        
       
    }
    
    public function apontaEfi($sDados){
        
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        
        $sSql = "update tbacaoeficaz set datareal = '".$aCampos['datareal']."',eficaz = '".$aCampos['eficaz']."',obs='".$aCampos['obs']."', sit = 'Finalizado' where filcgc ='".$aCampos['filcgc']."' and nr ='".$aCampos['nr']."' and seq ='".$aCampos['seq']."'";
        $aRetorno =$this->executaSql($sSql);
        return $aRetorno;
    }
    
    public function retEfi(){
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        
        $sSql = "update tbacaoeficaz set datareal = null ,eficaz = null ,obs=null,sit = null where filcgc ='".$aCampos['filcgc']."' and nr ='".$aCampos['nr']."' and seq ='".$aCampos['seq']."'";
        $aRetorno =$this->executaSql($sSql);
        return $aRetorno;
        
        
    }
    
    
}