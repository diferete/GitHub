<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_AqPlanApont extends Persistencia{
    public function __construct() {
        parent::__construct();
         $this->setTabela('MET_QUAL_qualplan');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        $this->adicionaRelacionamento('plano','plano');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('datafim', 'datafim');
        $this->adicionaRelacionamento('obsfim','obsfim');
        $this->adicionaRelacionamento('sitfim', 'sitfim');
        $this->adicionaRelacionamento('anexoplan1', 'anexoplan1');
        $this->adicionaRelacionamento('anexofim','anexofim');
        $this->adicionaRelacionamento('nrefi','nrefi');
        
        
    }
    
    public function apontaPlano(){
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        
        $sSql = "update MET_QUAL_qualplan set datafim = '".$aCampos['datafim']."',"
                . "obsfim = '".$aCampos['obsfim']."', sitfim = 'Finalizado', anexofim = '".$aCampos['anexofim']."'
        where filcgc ='".$aCampos['filcgc']."' and nr = '".$aCampos['nr']."' and seq = '".$aCampos['seq']."' ";
        
        $aRet = $this->executaSql($sSql); 
        return $aRet;
        
        
    }
    
    public function retPlano(){
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        
        $sSql = "update MET_QUAL_qualplan set datafim = null,obsfim = '', sitfim = null 
        where filcgc ='".$aCampos['filcgc']."' and nr = '".$aCampos['nr']."' and seq = '".$aCampos['seq']."' ";
        
        $aRet = $this->executaSql($sSql); 
        return $aRet;
        
        
    }
    
    

}